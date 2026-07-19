<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@nttdigital.com'],
            [
                'name'     => 'Admin NTT Digital',
                'email'    => 'admin@nttdigital.com',
                'password' => Hash::make('nttdigital2025'),
            ]
        );
    }
}
