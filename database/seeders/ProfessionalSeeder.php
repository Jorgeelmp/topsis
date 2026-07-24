<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
use App\Models\ProfessionalProfile;
use App\Models\ServiceCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class ProfessionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('pt_BR');
        $faker->seed(5678);

        $password = Hash::make('password');

        $testProfessional = User::firstOrCreate(
            ['email' => 'profissional@topsis.com'],
            [
                'name' => 'Profissional Teste',
                'password' => $password,
                'role' => RolesEnum::PROFESSIONAL,
                'latitude' => -28.720000,
                'longitude' => -49.430000,
            ]
        );

        $categories = ServiceCategory::all();

        if (!$testProfessional->professionalProfile) {
            ProfessionalProfile::create([
                'user_id' => $testProfessional->id,
                'service_category_id' => $categories->first()->id ?? 1,
                'hourly_price' => 50.00,
                'experience_years' => 5,
                'response_time' => 30,
                'acceptance_rate' => 90,
            ]);
        }

        $profCounter = 0;
        foreach ($categories as $category) {
            for ($i = 0; $i < 50; $i++) {
                $profCounter++;
                $user = User::firstOrCreate(
                    ['email' => "prof_{$profCounter}@exemplo.com"],
                    [
                        'name' => $faker->name,
                        'password' => $password,
                        'role' => RolesEnum::PROFESSIONAL,
                        'latitude' => $faker->latitude(-28.8, -28.6),
                        'longitude' => $faker->longitude(-49.5, -49.3),
                    ]
                );

                if (!$user->professionalProfile) {
                    ProfessionalProfile::create([
                        'user_id' => $user->id,
                        'service_category_id' => $category->id,
                        'hourly_price' => $faker->randomFloat(2, 20, 150),
                        'experience_years' => $faker->numberBetween(1, 30),
                        'response_time' => $faker->numberBetween(5, 120),
                        'acceptance_rate' => $faker->numberBetween(50, 100),
                    ]);
                }
            }
        }
    }
}
