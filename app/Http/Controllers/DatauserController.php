<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class DatauserController extends Controller
{
    /**
     * Display a listing of users
     */
    public function index()
    {
        $user = User::all();
        return view('user.index', compact('user'));
    }

    /**
     * Show the form for creating a new user
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created user in storage
     */
    public function add(Request $request)
    {
        try {
            // Validate input
            $request->validate([
                'nama_user' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:user,username',
                'password' => 'required|string|min:6|confirmed',
                'no_telepon' => 'required|string|max:15',
                'foto_user' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'roles' => 'required|in:admin,kepala_rs,petugas,pasien',
            ]);

            // Handle file upload for user photo
            $fileName = null;
            if ($request->hasFile('foto_user')) {
                $fileName = time() . '.' . $request->foto_user->extension();
                $request->foto_user->storeAs('foto_user', $fileName, 'public');
            }

            // Create new user
            User::create([
                'nama_user' => $request->nama_user,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'no_telepon' => $request->no_telepon,
                'foto_user' => $fileName,
                'roles' => $request->roles,
            ]);

            // Redirect with success message
            return redirect()->route('user.index')->with('success', 'User baru berhasil ditambahkan!');
        } catch (\Exception $e) {
            Log::error('Error adding user: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menambahkan user: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Show the form for editing the specified user
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('user.update', compact('user'));
    }

    /**
     * Update the specified user in storage
     */
    public function update(Request $request, $id)
    {
        try {
            // Validate input
            $request->validate([
                'nama_user' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:user,username,' . $id,
                'password' => 'nullable|string|min:6|confirmed',
                'no_telepon' => 'required|string|max:15',
                'foto_user' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'roles' => 'required|in:admin,kepala_rs,petugas,pasien',
            ]);

            $user = User::findOrFail($id);

            // Handle file upload for user photo
            if ($request->hasFile('foto_user')) {
                // Delete old photo if exists
                if ($user->foto_user) {
                    Storage::disk('public')->delete('foto_user/' . $user->foto_user);
                }

                // Upload new photo
                $fileName = time() . '.' . $request->foto_user->extension();
                $request->foto_user->storeAs('foto_user', $fileName, 'public');
            } else {
                // Keep the existing photo if no new photo is uploaded
                $fileName = $user->foto_user;
            }

            // Update user data
            $user->update([
                'nama_user' => $request->nama_user,
                'username' => $request->username,
                'password' => $request->password ? Hash::make($request->password) : $user->password,
                'no_telepon' => $request->no_telepon,
                'foto_user' => $fileName,
                'roles' => $request->roles,
            ]);

            // Redirect with success message
            return redirect()->route('user.index')->with('success', 'Data user berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Error updating user: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memperbarui user: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified user from storage
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);

            // Delete user photo if exists
            if ($user->foto_user) {
                Storage::disk('public')->delete('foto_user/' . $user->foto_user);
            }

            // Delete user
            $user->delete();

            // Redirect with success message
            return redirect()->route('user.index')->with('success', 'User berhasil dihapus!');
        } catch (\Exception $e) {
            Log::error('Error deleting user: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menghapus user: ' . $e->getMessage());
        }
    }
}