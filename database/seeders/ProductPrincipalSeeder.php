<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Principal;
use Illuminate\Database\Seeder;

class ProductPrincipalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();
        $principals = Principal::where('status', 'active')->get();

        foreach ($products as $product) {
            // Assign 1-3 principals to each product
            $numPrincipals = rand(1, 3);
            $selectedPrincipals = $principals->random($numPrincipals);

            foreach ($selectedPrincipals as $principal) {
                $product->principals()->attach($principal->id, ['active' => true]);
            }
        }
    }
}
