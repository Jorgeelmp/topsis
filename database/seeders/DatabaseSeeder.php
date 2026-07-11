<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
use App\Models\ServiceCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@topsis.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('password'),
                'role' => RolesEnum::ADMIN,
                'latitude' => -28.702391492581,
                'longitude' => -49.408516371623,
            ]
        );

        $categories = [
            'Diarista',
            'Pedreiro',
            'Pintor',
            'Eletricista',
            'Encanador',
            'Marceneiro',
            'Jardineiro',
        ];

        foreach ($categories as $name) {
            ServiceCategory::firstOrCreate(['name' => $name]);
        }
    }
}
