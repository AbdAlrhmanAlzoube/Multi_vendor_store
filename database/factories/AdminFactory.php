<?php

namespace Database\Factories;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin>
 */
class AdminFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'username' => $this->faker->unique()->userName(),
            'password' => Hash::make('password'), // Ensure password is hashed
            'phone_number' => $this->faker->unique()->phoneNumber(),
            'super_admin' => $this->faker->boolean(),
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'type' => $this->faker->randomElement(['admin', 'super-admin']),      
          ];
    }
}
