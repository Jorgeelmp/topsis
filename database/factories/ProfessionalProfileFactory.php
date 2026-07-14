<?php

namespace Database\Factories;

use App\Models\ProfessionalProfile;
use App\Models\ServiceCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProfessionalProfile>
 */
class ProfessionalProfileFactory extends Factory
{
    public function definition(): array
    {
        return [
            'service_category_id' => ServiceCategory::inRandomOrder()->first()?->id,
            'hourly_price' => fake()->randomFloat(2, 30, 350),
            'response_time' => fake()->randomElement([1, 2, 4, 8, 12, 24, 48]),
            'description' => fake('pt_BR')->paragraph(3),
            'experience_years' => fake()->numberBetween(1, 20),
            'acceptance_rate' => fake()->randomFloat(2, 60, 100),
        ];
    }
}
