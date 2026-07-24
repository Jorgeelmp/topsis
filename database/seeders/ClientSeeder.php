<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('pt_BR');
        $faker->seed(1234);

        $password = Hash::make('password');

        User::firstOrCreate(
            ['email' => 'cliente@topsis.com'],
            [
                'name' => 'Cliente Teste',
                'password' => $password,
                'role' => RolesEnum::CLIENT,
                'latitude' => -28.710000,
                'longitude' => -49.420000,
            ]
        );

        for ($i = 0; $i < 50; $i++) {
            User::firstOrCreate(
                ['email' => "cliente_{$i}@exemplo.com"],
                [
                    'name' => $faker->name,
                    'password' => $password,
                    'role' => RolesEnum::CLIENT,
                    'latitude' => $faker->latitude(-28.8, -28.6),
                    'longitude' => $faker->longitude(-49.5, -49.3),
                ]
            );
        }
    }
}
