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
        $user = [
            [
                'email' => 'admin@email.com',
                'password' => Hash::make('password'),
                'id_role' => 1,
            ],
            [
                'email' => 'direktur@email.com',
                'password' => Hash::make('password'),
                'id_role' => 2,
            ],
            [
                'email' => 'manager@email.com',
                'password' => Hash::make('password'),
                'id_role' => 3,
            ],
            [
                'email' => 'finance@email.com',
                'password' => Hash::make('password'),
                'id_role' => 4,
            ],
            [
                'email' => 'vendor@email.com',
                'password' => Hash::make('password'),
                'id_role' => 5,
            ],
        ];

        foreach ($user as $row) {
            User::create($row);
        }
    }
}
