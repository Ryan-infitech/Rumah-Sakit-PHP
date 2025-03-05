<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the user profile page
     */
    public function index()
    {
        return view('user.profile');
    }

    /**
     * Update the user profile
     */
    public function update(Request $request, $id)
    {
        try {
            // Ensure the user can only update their own profile
            if (Auth::id() != $id) {
                return redirect()->back()->with('error', 'Anda tidak diizinkan mengubah profil pengguna lain');
            }

            // Validate input
            $request->validate([
                'nama_user' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:user,username,' . $id,
                'password' => 'nullable|string|min:6|confirmed',
                'no_telepon' => 'required|string|max:15',
                'foto_user' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
                // roles remains unchanged
            ]);

            // Redirect with success message
            return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Error updating profile: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memperbarui profil: ' . $e->getMessage())->withInput();
        }
    }
}