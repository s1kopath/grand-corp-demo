<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Principal>
 */
class PrincipalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $principals = [
            ['name' => 'China Steel Corp', 'country' => 'China', 'status' => 'active'],
            ['name' => 'Korean Electronics Ltd', 'country' => 'South Korea', 'status' => 'active'],
            ['name' => 'Japanese Auto Parts', 'country' => 'Japan', 'status' => 'active'],
            ['name' => 'German Machinery Co', 'country' => 'Germany', 'status' => 'active'],
            ['name' => 'Italian Textiles', 'country' => 'Italy', 'status' => 'active'],
            ['name' => 'French Cosmetics', 'country' => 'France', 'status' => 'active'],
            ['name' => 'Swiss Watches', 'country' => 'Switzerland', 'status' => 'active'],
            ['name' => 'Dutch Flowers', 'country' => 'Netherlands', 'status' => 'active'],
            ['name' => 'Belgian Chocolates', 'country' => 'Belgium', 'status' => 'inactive'],
            ['name' => 'Spanish Olive Oil', 'country' => 'Spain', 'status' => 'active'],
        ];

        $principal = $this->faker->unique()->randomElement($principals);

        return [
            'name' => $principal['name'],
            'country' => $principal['country'],
            'status' => $principal['status'],
        ];
    }
}
