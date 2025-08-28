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
            // Major Global Pharmaceutical Companies
            ['name' => 'Pfizer Inc', 'country' => 'USA', 'status' => 'active'],
            ['name' => 'Novartis AG', 'country' => 'Switzerland', 'status' => 'active'],
            ['name' => 'Roche Holding AG', 'country' => 'Switzerland', 'status' => 'active'],
            ['name' => 'Johnson & Johnson', 'country' => 'USA', 'status' => 'active'],
            ['name' => 'Merck & Co', 'country' => 'USA', 'status' => 'active'],
            ['name' => 'GlaxoSmithKline', 'country' => 'UK', 'status' => 'active'],
            ['name' => 'Sanofi SA', 'country' => 'France', 'status' => 'active'],
            ['name' => 'AstraZeneca', 'country' => 'UK', 'status' => 'active'],
            ['name' => 'Bayer AG', 'country' => 'Germany', 'status' => 'active'],
            ['name' => 'Eli Lilly', 'country' => 'USA', 'status' => 'active'],

            // Indian Pharmaceutical Companies
            ['name' => 'Sun Pharmaceutical', 'country' => 'India', 'status' => 'active'],
            ['name' => 'Dr. Reddy\'s Laboratories', 'country' => 'India', 'status' => 'active'],
            ['name' => 'Cipla Limited', 'country' => 'India', 'status' => 'active'],
            ['name' => 'Aurobindo Pharma', 'country' => 'India', 'status' => 'active'],
            ['name' => 'Lupin Limited', 'country' => 'India', 'status' => 'active'],
            ['name' => 'Torrent Pharmaceuticals', 'country' => 'India', 'status' => 'active'],
            ['name' => 'Cadila Healthcare', 'country' => 'India', 'status' => 'active'],
            ['name' => 'Glenmark Pharmaceuticals', 'country' => 'India', 'status' => 'active'],

            // Chinese Pharmaceutical Companies
            ['name' => 'Sinopharm Group', 'country' => 'China', 'status' => 'active'],
            ['name' => 'Hengrui Medicine', 'country' => 'China', 'status' => 'active'],
            ['name' => 'Yangtze River Pharma', 'country' => 'China', 'status' => 'active'],
            ['name' => 'CSPC Pharmaceutical', 'country' => 'China', 'status' => 'active'],
            ['name' => 'Harbin Pharmaceutical', 'country' => 'China', 'status' => 'active'],

            // European Pharmaceutical Companies
            ['name' => 'Boehringer Ingelheim', 'country' => 'Germany', 'status' => 'active'],
            ['name' => 'Takeda Pharmaceutical', 'country' => 'Japan', 'status' => 'active'],
            ['name' => 'Astellas Pharma', 'country' => 'Japan', 'status' => 'active'],
            ['name' => 'Daiichi Sankyo', 'country' => 'Japan', 'status' => 'active'],
            ['name' => 'Otsuka Pharmaceutical', 'country' => 'Japan', 'status' => 'active'],

            // Biotech Companies
            ['name' => 'Amgen Inc', 'country' => 'USA', 'status' => 'active'],
            ['name' => 'Biogen Inc', 'country' => 'USA', 'status' => 'active'],
            ['name' => 'Gilead Sciences', 'country' => 'USA', 'status' => 'active'],
            ['name' => 'Regeneron Pharmaceuticals', 'country' => 'USA', 'status' => 'active'],
            ['name' => 'Moderna Inc', 'country' => 'USA', 'status' => 'active'],

            // Generic Manufacturers
            ['name' => 'Teva Pharmaceutical', 'country' => 'Israel', 'status' => 'active'],
            ['name' => 'Mylan NV', 'country' => 'Netherlands', 'status' => 'active'],
            ['name' => 'Sandoz International', 'country' => 'Switzerland', 'status' => 'active'],
            ['name' => 'Fresenius Kabi', 'country' => 'Germany', 'status' => 'active'],
            ['name' => 'Hikma Pharmaceuticals', 'country' => 'UK', 'status' => 'active'],
        ];

        $principal = $this->faker->unique()->randomElement($principals);

        return [
            'name' => $principal['name'],
            'country' => $principal['country'],
            'status' => $principal['status'],
        ];
    }
}
