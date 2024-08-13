<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Store>
 */
class StoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name=$this->faker->unique()->company;
        return [
            'name' => $name, // اسم المتجر
            'slug' =>Str::slug($name), // عنوان URL الفريد
            'description' => $this->faker->text, // وصف المتجر
            'logo_image' => $this->faker->imageUrl(200, 200, 'business', true, 'logo'), // صورة الشعار
            'cover_image' => $this->faker->imageUrl(800, 400, 'business', true, 'cover'), // صورة الغلاف
            'status' => $this->faker->randomElement(['active', 'inactive']), 
        ];
    }
}
