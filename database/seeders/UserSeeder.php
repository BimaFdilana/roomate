<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Menambahkan user dengan data dummy
        User::create([
            'name' => 'John Doe',
            // 'photos' => 'path/to/photo.jpg', // Sesuaikan dengan path foto yang sesuai
            'phone' => '123',
            'email' => 'john.doe@example.com',
            'password' => Hash::make('password'), // Jangan lupa untuk hash password
            'role' => 'guru', // Sesuaikan dengan role yang diinginkan
        ]);

        User::create([
            'name' => 'Jane Doe',
            // 'photos' => 'path/to/photo2.jpg', // Sesuaikan dengan path foto yang sesuai
            'phone' => '1234',
            'email' => 'jane.doe@example.com',
            'password' => Hash::make('password'), // Jangan lupa untuk hash password
            'role' => 'murid', // Sesuaikan dengan role yang diinginkan
        ]);
        
        // Tambahkan lebih banyak pengguna sesuai kebutuhan
    }
}
