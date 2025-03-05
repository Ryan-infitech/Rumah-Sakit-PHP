<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create admin user
        DB::table('user')->insert([
            'nama_user' => 'Administrator',
            'username' => 'admin@rumahsakit.com',
            'password' => Hash::make('admin123'),
            'no_telepon' => '0812345678',
            'roles' => 'admin',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Create test petugas user
        DB::table('user')->insert([
            'nama_user' => 'Petugas Test',
            'username' => 'petugas@rumahsakit.com',
            'password' => Hash::make('petugas123'),
            'no_telepon' => '0812345679',
            'roles' => 'petugas',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Create test pasien user
        DB::table('user')->insert([
            'nama_user' => 'Pasien Test',
            'username' => 'pasien@rumahsakit.com',
            'password' => Hash::make('pasien123'),
            'no_telepon' => '0812345670',
            'roles' => 'pasien',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
