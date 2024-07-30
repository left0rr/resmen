<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Menuitem>
 */
class MenuitemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' =>fake()->name,
            'description'=>fake()->text,
            'category_id'=>Category::factory(),
            'price'=>fake()->numberBetween(1,100),
            'image_url'=>fake()->imageUrl(),

            //
        ];
    }
}
