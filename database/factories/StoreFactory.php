<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $prefectures = ['東京都', '大阪府', '愛知県', '福岡県', '北海道', '神奈川県', '千葉県', '埼玉県'];
        $storeTypes = ['本店', '支店', '営業所', '出張所', 'サービスセンター'];

        return [
            'name' => $this->faker->company() . ' ' . $this->faker->randomElement($storeTypes),
            'address' => $this->faker->randomElement($prefectures) . $this->faker->city() . $this->faker->streetAddress(),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->optional(0.7)->companyEmail(),
            'opening_hours' => $this->faker->optional(0.8)->randomElement([
                "平日: 9:00-18:00\n土曜: 10:00-17:00",
                "月-金: 8:30-17:30\n土日: 休業",
                "毎日: 10:00-20:00",
                "平日: 9:00-19:00\n土日祝: 10:00-18:00"
            ]),
            'closed_days' => $this->faker->optional(0.6)->randomElement([
                '毎週日曜日',
                '毎週水曜日',
                '第2・第4日曜日',
                '年末年始',
                'なし（年中無休）'
            ]),
            'status' => $this->faker->randomElement(['open', 'open', 'open', 'closed', 'preparing']), // 75% chance of being open
            'manager_name' => $this->faker->optional(0.8)->name(),
            'opening_date' => $this->faker->optional(0.6)->dateTimeBetween('-5 years', '-1 month'),
            'description' => $this->faker->optional(0.4)->paragraph(),
        ];
    }
}
