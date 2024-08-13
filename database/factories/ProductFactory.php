<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Store;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = \App\Models\Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->word;
        return [
            'store_id' =>Store::inRandomOrder()->first()->id,
            'category_id' => Category::inRandomOrder()->first()->id, // تعيين فئة عشوائية أو null
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->text,
            'image' => $this->faker->imageUrl,
            'price' => $this->faker->randomFloat(2, 1, 999),
            'compare_price' => $this->faker->randomFloat(2, 1000, 1999),
            'option' => json_encode([
                'color' => $this->faker->safeColorName,
                'size' => $this->faker->randomElement(['S', 'M', 'L', 'XL']),
                'material' => $this->faker->word
            ]),
            'rating' => $this->faker->randomFloat(1, 0, 5),
            'featured' => $this->faker->boolean, // استخدم boolean هنا
            'status' => $this->faker->randomElement(['active', 'draft', 'archived']),
        ];
    }
}
