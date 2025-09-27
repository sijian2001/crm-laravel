<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $categories = ['電子機器', '食品', '衣類', '家具', '書籍', '美容', 'スポーツ', '自動車用品'];

        return [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->optional(0.8)->paragraph(),
            'price' => $this->faker->randomFloat(2, 100, 50000),
            'sku' => strtoupper($this->faker->unique()->bothify('??###-####')),
            'category' => $this->faker->randomElement($categories),
            'stock_quantity' => $this->faker->numberBetween(0, 100),
            'image_url' => $this->faker->optional(0.3)->imageUrl(400, 400),
            'status' => $this->faker->randomElement([true, true, true, false]), // 75% chance of being active
        ];
    }
}
