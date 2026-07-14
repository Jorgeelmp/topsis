<?php

namespace Database\Factories;

use App\Enums\RolesEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake('pt_BR')->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'role' => RolesEnum::CLIENT,
            'latitude' => fake()->randomFloat(8, -29.5, -27.5),
            'longitude' => fake()->randomFloat(8, -50.5, -48.5),
        ];
    }

    public function client(): static
    {
        return $this->state(fn(array $attributes) => [
            'role' => RolesEnum::CLIENT,
        ]);
    }

    public function professional(): static
    {
        return $this->state(fn(array $attributes) => [
            'role' => RolesEnum::PROFESSIONAL,
        ]);
    }


    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
