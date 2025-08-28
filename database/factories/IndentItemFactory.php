<?php

namespace Database\Factories;

use App\Models\Indent;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\IndentItem>
 */
class IndentItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'indent_id' => Indent::factory(),
            'product_id' => Product::factory(),
            'qty' => $this->faker->randomFloat(2, 100, 5000),
            'price' => $this->faker->randomFloat(2, 10, 500),
        ];
    }
}
