<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@veloura.test'],
            [
                'name' => 'Veloura Admin',
                'password' => Hash::make('VelouraDemo2026!'),
                'role' => 'admin',
            ]
        );
    }
}
