<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Sandro',
                'email' => 'sandro@example.com',
                'password' => Hash::make('Testerius@111'),
            ],
            [
                'name' => 'Egnate',
                'email' => 'egnate@example.com',
                'password' => Hash::make('Testerius@111'),
            ],
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => Hash::make('Testerius@111'),
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'password' => Hash::make('Testerius@111'),
            ],
            [
                'name' => 'Bob Johnson',
                'email' => 'bob@example.com',
                'password' => Hash::make('Testerius@111'),
            ]
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }
    }
}