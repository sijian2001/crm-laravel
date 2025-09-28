<?php

namespace Database\Factories;

use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $lastNames = ['田中', '佐藤', '鈴木', '高橋', '小林', '山田', '中村', '松本', '井上', '木村', '加藤', '清水', '斉藤', '山本', '石川'];
        $firstNames = ['太郎', '花子', '次郎', '美咲', '健一', '恵子', '修', '由美', '智', '香織', '隆', '真由美', '誠', '千恵', '亮'];
        $lastNamesKana = ['タナカ', 'サトウ', 'スズキ', 'タカハシ', 'コバヤシ', 'ヤマダ', 'ナカムラ', 'マツモト', 'イノウエ', 'キムラ', 'カトウ', 'シミズ', 'サイトウ', 'ヤマモト', 'イシカワ'];
        $firstNamesKana = ['タロウ', 'ハナコ', 'ジロウ', 'ミサキ', 'ケンイチ', 'ケイコ', 'オサム', 'ユミ', 'サトシ', 'カオリ', 'タカシ', 'マユミ', 'マコト', 'チエ', 'リョウ'];
        $departments = ['営業部', '販売部', '管理部', '商品部', 'カスタマーサービス', 'マーケティング部'];

        $lastNameIndex = array_rand($lastNames);
        $firstNameIndex = array_rand($firstNames);

        $lastName = $lastNames[$lastNameIndex];
        $firstName = $firstNames[$firstNameIndex];
        $lastNameKana = $lastNamesKana[$lastNameIndex];
        $firstNameKana = $firstNamesKana[$firstNameIndex];

        $hireDate = $this->faker->dateTimeBetween('-10 years', '-1 month');
        $birthDate = $this->faker->optional(0.8)->dateTimeBetween('-65 years', '-18 years');

        // 雇用形態によって給与設定を変える
        $employmentType = $this->faker->randomElement(['full_time', 'full_time', 'part_time', 'contract', 'temporary']);
        $position = $this->faker->randomElement(['trainee', 'staff', 'staff', 'staff', 'senior_staff', 'supervisor', 'assistant_manager', 'manager']);

        $salary = null;
        $hourlyWage = null;

        if ($employmentType === 'full_time') {
            // 正社員は月給
            switch ($position) {
                case 'manager':
                    $salary = $this->faker->numberBetween(350000, 500000);
                    break;
                case 'assistant_manager':
                    $salary = $this->faker->numberBetween(300000, 400000);
                    break;
                case 'supervisor':
                    $salary = $this->faker->numberBetween(250000, 350000);
                    break;
                case 'senior_staff':
                    $salary = $this->faker->numberBetween(220000, 300000);
                    break;
                case 'staff':
                    $salary = $this->faker->numberBetween(180000, 250000);
                    break;
                case 'trainee':
                    $salary = $this->faker->numberBetween(150000, 200000);
                    break;
            }
        } else {
            // パートタイム・契約・臨時は時給
            $hourlyWage = $this->faker->numberBetween(900, 1800);
        }

        return [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'first_name_kana' => $firstNameKana,
            'last_name_kana' => $lastNameKana,
            'email' => strtolower($lastNameKana . '.' . $firstNameKana) . '@company.co.jp',
            'phone' => $this->faker->optional(0.8)->phoneNumber(),
            'address' => $this->faker->optional(0.7)->address(),
            'birth_date' => $birthDate,
            'hire_date' => $hireDate,
            'termination_date' => $this->faker->optional(0.1)->dateTimeBetween($hireDate, 'now'),
            'employment_type' => $employmentType,
            'position' => $position,
            'salary' => $salary,
            'hourly_wage' => $hourlyWage,
            'department' => $this->faker->optional(0.7)->randomElement($departments),
            'status' => $this->faker->randomElement(['active', 'active', 'active', 'active', 'inactive', 'on_leave', 'terminated']),
            'store_id' => Store::factory(),
            'notes' => $this->faker->optional(0.3)->paragraph(),
        ];
    }

    /**
     * 在職中の店員を作成
     */
    public function active()
    {
        return $this->state([
            'status' => 'active',
            'termination_date' => null,
        ]);
    }

    /**
     * 店長役職の店員を作成
     */
    public function manager()
    {
        return $this->state([
            'position' => 'manager',
            'employment_type' => 'full_time',
            'salary' => $this->faker->numberBetween(350000, 500000),
            'hourly_wage' => null,
            'status' => 'active',
        ]);
    }

    /**
     * パートタイム店員を作成
     */
    public function partTime()
    {
        return $this->state([
            'employment_type' => 'part_time',
            'position' => $this->faker->randomElement(['staff', 'trainee']),
            'salary' => null,
            'hourly_wage' => $this->faker->numberBetween(900, 1500),
        ]);
    }
}
