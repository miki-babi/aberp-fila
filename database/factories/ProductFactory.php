<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'image' => $this->faker->imageUrl(),
            'category_id' => \App\Models\Category::factory(),
            'sub_category_id' => \App\Models\SubCategory::factory(),
            'spec_id' => \App\Models\Spec::factory(),
        ];
    }
}
