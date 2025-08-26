<?php

namespace Database\Seeders;

use App\Models\Principal;
use Illuminate\Database\Seeder;

class PrincipalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
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

        foreach ($principals as $principal) {
            Principal::create($principal);
        }
    }
}
