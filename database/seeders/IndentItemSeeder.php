<?php

namespace Database\Seeders;

use App\Models\Indent;
use App\Models\IndentItem;
use App\Models\Product;
use Illuminate\Database\Seeder;

class IndentItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $indents = Indent::all();
        $products = Product::all();

        foreach ($indents as $indent) {
            // Create 2-4 items per indent
            $itemCount = rand(2, 4);
            
            for ($i = 0; $i < $itemCount; $i++) {
                IndentItem::create([
                    'indent_id' => $indent->id,
                    'product_id' => $products->random()->id,
                    'qty' => rand(100, 5000),
                    'price' => rand(10, 500),
                ]);
            }
        }
    }
}
