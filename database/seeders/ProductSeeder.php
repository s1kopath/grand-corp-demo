<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            ['name' => 'LED TV 55"', 'category' => 'Electronics', 'description' => 'High-definition LED television', 'uom' => 'PCS'],
            ['name' => 'Smartphone Galaxy S21', 'category' => 'Electronics', 'description' => 'Latest Samsung smartphone', 'uom' => 'PCS'],
            ['name' => 'Laptop Dell XPS', 'category' => 'Electronics', 'description' => 'Premium business laptop', 'uom' => 'PCS'],
            ['name' => 'Cotton Fabric', 'category' => 'Textiles', 'description' => 'Premium cotton fabric', 'uom' => 'MTR'],
            ['name' => 'Silk Scarf', 'category' => 'Textiles', 'description' => 'Luxury silk scarf', 'uom' => 'PCS'],
            ['name' => 'Denim Jeans', 'category' => 'Textiles', 'description' => 'High-quality denim jeans', 'uom' => 'PCS'],
            ['name' => 'Industrial Pump', 'category' => 'Machinery', 'description' => 'Heavy-duty industrial pump', 'uom' => 'PCS'],
            ['name' => 'Conveyor Belt', 'category' => 'Machinery', 'description' => 'Industrial conveyor system', 'uom' => 'MTR'],
            ['name' => 'Hydraulic Cylinder', 'category' => 'Machinery', 'description' => 'Precision hydraulic cylinder', 'uom' => 'PCS'],
            ['name' => 'Sulfuric Acid', 'category' => 'Chemicals', 'description' => 'Industrial grade sulfuric acid', 'uom' => 'LTR'],
            ['name' => 'Sodium Hydroxide', 'category' => 'Chemicals', 'description' => 'Caustic soda solution', 'uom' => 'KG'],
            ['name' => 'Polyethylene', 'category' => 'Chemicals', 'description' => 'High-density polyethylene', 'uom' => 'KG'],
            ['name' => 'Coffee Beans', 'category' => 'Food & Beverages', 'description' => 'Premium Arabica coffee beans', 'uom' => 'KG'],
            ['name' => 'Olive Oil', 'category' => 'Food & Beverages', 'description' => 'Extra virgin olive oil', 'uom' => 'LTR'],
            ['name' => 'Wine Red', 'category' => 'Food & Beverages', 'description' => 'Premium red wine', 'uom' => 'LTR'],
            ['name' => 'Car Engine Parts', 'category' => 'Automotive', 'description' => 'Automotive engine components', 'uom' => 'PCS'],
            ['name' => 'Tire Set', 'category' => 'Automotive', 'description' => 'Complete tire set', 'uom' => 'SET'],
            ['name' => 'Brake Pads', 'category' => 'Automotive', 'description' => 'High-performance brake pads', 'uom' => 'PCS'],
            ['name' => 'Wireless Headphones', 'category' => 'Electronics', 'description' => 'Bluetooth wireless headphones', 'uom' => 'PCS'],
            ['name' => 'Tablet iPad Pro', 'category' => 'Electronics', 'description' => 'Apple iPad Pro tablet', 'uom' => 'PCS'],
            ['name' => 'Gaming Console', 'category' => 'Electronics', 'description' => 'Next-gen gaming console', 'uom' => 'PCS'],
            ['name' => 'Wool Sweater', 'category' => 'Textiles', 'description' => 'Premium wool sweater', 'uom' => 'PCS'],
            ['name' => 'Leather Jacket', 'category' => 'Textiles', 'description' => 'Genuine leather jacket', 'uom' => 'PCS'],
            ['name' => 'Synthetic Fiber', 'category' => 'Textiles', 'description' => 'High-quality synthetic fiber', 'uom' => 'KG'],
            ['name' => 'CNC Machine', 'category' => 'Machinery', 'description' => 'Computer numerical control machine', 'uom' => 'PCS'],
            ['name' => 'Welding Equipment', 'category' => 'Machinery', 'description' => 'Professional welding equipment', 'uom' => 'PCS'],
            ['name' => 'Compressor', 'category' => 'Machinery', 'description' => 'Industrial air compressor', 'uom' => 'PCS'],
            ['name' => 'Nitric Acid', 'category' => 'Chemicals', 'description' => 'Concentrated nitric acid', 'uom' => 'LTR'],
            ['name' => 'Ammonia', 'category' => 'Chemicals', 'description' => 'Anhydrous ammonia', 'uom' => 'KG'],
            ['name' => 'PVC Resin', 'category' => 'Chemicals', 'description' => 'Polyvinyl chloride resin', 'uom' => 'KG'],
            ['name' => 'Tea Leaves', 'category' => 'Food & Beverages', 'description' => 'Premium tea leaves', 'uom' => 'KG'],
            ['name' => 'Honey', 'category' => 'Food & Beverages', 'description' => 'Pure natural honey', 'uom' => 'KG'],
            ['name' => 'Cheese', 'category' => 'Food & Beverages', 'description' => 'Aged premium cheese', 'uom' => 'KG'],
            ['name' => 'Transmission System', 'category' => 'Automotive', 'description' => 'Automotive transmission', 'uom' => 'PCS'],
            ['name' => 'Battery Pack', 'category' => 'Automotive', 'description' => 'Electric vehicle battery pack', 'uom' => 'PCS'],
            ['name' => 'Air Filter', 'category' => 'Automotive', 'description' => 'High-performance air filter', 'uom' => 'PCS'],
            ['name' => 'Solar Panel', 'category' => 'Electronics', 'description' => 'High-efficiency solar panel', 'uom' => 'PCS'],
            ['name' => 'Drone Camera', 'category' => 'Electronics', 'description' => 'Professional drone with camera', 'uom' => 'PCS'],
            ['name' => 'Smart Watch', 'category' => 'Electronics', 'description' => 'Advanced smartwatch', 'uom' => 'PCS'],
        ];

        foreach ($products as $product) {
            Product::create([
                'name' => $product['name'],
                'category' => $product['category'],
                'description' => $product['description'],
                'default_uom' => $product['uom'],
                'is_enabled' => true,
            ]);
        }
    }
}
