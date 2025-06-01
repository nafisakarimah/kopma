<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
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
        User::create([
            'nama' => 'Admin',
            'no_telp' => '99999999999',
            'alamat' => 'Alamat Admin',
            'email' => 'admin@gmail.com',
            'status' => 1,
            'password' => Hash::make('admin'),
            'role' => 1,
        ]);
        User::create([
            'nama' => 'User',
            'no_telp' => '1234',
            'alamat' => 'Alamat User',
            'email' => 'user@gmail.com',
            'status' => 1,
            'password' => Hash::make('user'),
            'role' => 2,
        ]);

        User::create([
            'nama' => 'Member',
            'no_telp' => '123456',
            'alamat' => 'Alamat User',
            'email' => 'member@gmail.com',
            'status' => 1,
            'password' => Hash::make('member'),
            'role' => 2,
            'member' => 1,
            'member_poin' => 0,
        ]);

        User::create([
            'nama' => 'Member2',
            'no_telp' => '12322456',
            'alamat' => 'Alamat User',
            'email' => 'member2@gmail.com',
            'status' => 1,
            'password' => Hash::make('member'),
            'role' => 2,
            'member' => 1,
            'member_poin' => 0,
        ]);
    }
}
