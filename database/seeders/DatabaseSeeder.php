<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => 'password', // Akan di-hash oleh mutator
            'role' => 'admin',
            'skill' => null,
            'location' => 'Jakarta',
            'photo' => null,
            'identity_card' => null,
        ]);

        // Guru
        User::create([
            'name' => 'Guru User',
            'email' => 'guru@example.com',
            'password' => 'password', // Akan di-hash oleh mutator
            'role' => 'guru',
            'skill' => 'Matematika, Fisika',
            'location' => 'Bandung',
            'photo' => null,
            'identity_card' => null,
        ]);

        // Murid
        User::create([
            'name' => 'Murid User',
            'email' => 'murid@example.com',
            'password' => 'password', // Akan di-hash oleh mutator
            'role' => 'murid',
            'skill' => 'Pelatihan Desain Grafis',
            'location' => 'Surabaya',
            'photo' => null,
            'identity_card' => null,
        ]);
    }
}
