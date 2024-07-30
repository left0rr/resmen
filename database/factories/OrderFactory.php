<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = \App\Models\Order::class;

    public function definition()
    {
        return [
            'table' => $this->faker->numberBetween(1, 20),
            'details' => json_encode([
                [
                    'id' => $this->faker->numberBetween(1,20),
                    'name' => $this->faker->word,
                    'price' => $this->faker->randomFloat(2, 1, 100),
                    'quantity' => $this->faker->randomNumber(1)
                ],
                [
                    'id' => $this->faker->numberBetween(1,20),
                    'name' => $this->faker->word,
                    'price' => $this->faker->randomFloat(2, 1, 100),
                    'quantity' => $this->faker->randomNumber(1)
                ]
            ]),
            'served' => $this->faker->boolean(),
            'discount' => $this->faker->optional()->word(),
        ];
    }
}
