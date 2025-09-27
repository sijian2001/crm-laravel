<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'gender' => $this->faker->randomElement(['male', 'female', 'other']),
            'birth_date' => $this->faker->dateTimeBetween('-80 years', '-18 years'),
            'company' => $this->faker->company(),
            'department' => $this->faker->randomElement(['営業部', '開発部', '企画部', '管理部', '人事部']),
            'position' => $this->faker->randomElement(['部長', '課長', '主任', '係長', '一般']),
            'address' => $this->faker->address(),
            'notes' => $this->faker->optional(0.3)->paragraph(),
        ];
    }
}
