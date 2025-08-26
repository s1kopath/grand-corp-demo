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
        $categories = ['Electronics', 'Textiles', 'Machinery', 'Chemicals', 'Food & Beverages', 'Automotive'];
        $uoms = ['PCS', 'KG', 'MTR', 'LTR', 'BOX', 'TON'];

        $products = [
            ['name' => 'LED TV 55"', 'category' => 'Electronics', 'uom' => 'PCS'],
            ['name' => 'Smartphone Galaxy S21', 'category' => 'Electronics', 'uom' => 'PCS'],
            ['name' => 'Laptop Dell XPS', 'category' => 'Electronics', 'uom' => 'PCS'],
            ['name' => 'Cotton Fabric', 'category' => 'Textiles', 'uom' => 'MTR'],
            ['name' => 'Silk Scarf', 'category' => 'Textiles', 'uom' => 'PCS'],
            ['name' => 'Denim Jeans', 'category' => 'Textiles', 'uom' => 'PCS'],
            ['name' => 'Industrial Pump', 'category' => 'Machinery', 'uom' => 'PCS'],
            ['name' => 'Conveyor Belt', 'category' => 'Machinery', 'uom' => 'MTR'],
            ['name' => 'Hydraulic Cylinder', 'category' => 'Machinery', 'uom' => 'PCS'],
            ['name' => 'Sulfuric Acid', 'category' => 'Chemicals', 'uom' => 'LTR'],
            ['name' => 'Sodium Hydroxide', 'category' => 'Chemicals', 'uom' => 'KG'],
            ['name' => 'Polyethylene', 'category' => 'Chemicals', 'uom' => 'KG'],
            ['name' => 'Coffee Beans', 'category' => 'Food & Beverages', 'uom' => 'KG'],
            ['name' => 'Olive Oil', 'category' => 'Food & Beverages', 'uom' => 'LTR'],
            ['name' => 'Wine Red', 'category' => 'Food & Beverages', 'uom' => 'LTR'],
            ['name' => 'Car Engine Parts', 'category' => 'Automotive', 'uom' => 'PCS'],
            ['name' => 'Tire Set', 'category' => 'Automotive', 'uom' => 'SET'],
            ['name' => 'Brake Pads', 'category' => 'Automotive', 'uom' => 'PCS'],
            ['name' => 'Wireless Headphones', 'category' => 'Electronics', 'uom' => 'PCS'],
            ['name' => 'Tablet iPad Pro', 'category' => 'Electronics', 'uom' => 'PCS'],
            ['name' => 'Gaming Console', 'category' => 'Electronics', 'uom' => 'PCS'],
            ['name' => 'Wool Sweater', 'category' => 'Textiles', 'uom' => 'PCS'],
            ['name' => 'Leather Jacket', 'category' => 'Textiles', 'uom' => 'PCS'],
            ['name' => 'Synthetic Fiber', 'category' => 'Textiles', 'uom' => 'KG'],
            ['name' => 'CNC Machine', 'category' => 'Machinery', 'uom' => 'PCS'],
            ['name' => 'Welding Equipment', 'category' => 'Machinery', 'uom' => 'PCS'],
            ['name' => 'Compressor', 'category' => 'Machinery', 'uom' => 'PCS'],
            ['name' => 'Nitric Acid', 'category' => 'Chemicals', 'uom' => 'LTR'],
            ['name' => 'Ammonia', 'category' => 'Chemicals', 'uom' => 'KG'],
            ['name' => 'PVC Resin', 'category' => 'Chemicals', 'uom' => 'KG'],
            ['name' => 'Tea Leaves', 'category' => 'Food & Beverages', 'uom' => 'KG'],
            ['name' => 'Honey', 'category' => 'Food & Beverages', 'uom' => 'KG'],
            ['name' => 'Cheese', 'category' => 'Food & Beverages', 'uom' => 'KG'],
            ['name' => 'Transmission System', 'category' => 'Automotive', 'uom' => 'PCS'],
            ['name' => 'Battery Pack', 'category' => 'Automotive', 'uom' => 'PCS'],
            ['name' => 'Air Filter', 'category' => 'Automotive', 'uom' => 'PCS'],
            ['name' => 'Solar Panel', 'category' => 'Electronics', 'uom' => 'PCS'],
            ['name' => 'Drone Camera', 'category' => 'Electronics', 'uom' => 'PCS'],
            ['name' => 'Smart Watch', 'category' => 'Electronics', 'uom' => 'PCS'],
        ];

        $product = $this->faker->unique()->randomElement($products);

        return [
            'name' => $product['name'],
            'category' => $product['category'],
            'description' => $this->faker->sentence(),
            'default_uom' => $product['uom'],
            'is_enabled' => $this->faker->boolean(90), // 90% enabled
        ];
    }
}
