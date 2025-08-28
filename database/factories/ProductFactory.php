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
        $categories = ['Antibiotics', 'Analgesics', 'Cardiovascular', 'Diabetes', 'Oncology', 'Vaccines', 'OTC Medicines', 'Medical Devices', 'Surgical Supplies', 'Diagnostic Kits'];
        $uoms = ['TAB', 'CAP', 'VIAL', 'AMP', 'BOTTLE', 'PACK', 'BOX', 'KIT', 'PCS', 'MG', 'ML'];

        $products = [
            // Antibiotics
            ['name' => 'Amoxicillin 500mg', 'category' => 'Antibiotics', 'uom' => 'TAB'],
            ['name' => 'Ciprofloxacin 250mg', 'category' => 'Antibiotics', 'uom' => 'TAB'],
            ['name' => 'Azithromycin 500mg', 'category' => 'Antibiotics', 'uom' => 'TAB'],
            ['name' => 'Ceftriaxone 1g', 'category' => 'Antibiotics', 'uom' => 'VIAL'],
            ['name' => 'Doxycycline 100mg', 'category' => 'Antibiotics', 'uom' => 'CAP'],
            ['name' => 'Metronidazole 400mg', 'category' => 'Antibiotics', 'uom' => 'TAB'],

            // Analgesics
            ['name' => 'Paracetamol 500mg', 'category' => 'Analgesics', 'uom' => 'TAB'],
            ['name' => 'Ibuprofen 400mg', 'category' => 'Analgesics', 'uom' => 'TAB'],
            ['name' => 'Diclofenac 50mg', 'category' => 'Analgesics', 'uom' => 'TAB'],
            ['name' => 'Tramadol 50mg', 'category' => 'Analgesics', 'uom' => 'CAP'],
            ['name' => 'Morphine 10mg', 'category' => 'Analgesics', 'uom' => 'AMP'],
            ['name' => 'Codeine 30mg', 'category' => 'Analgesics', 'uom' => 'TAB'],

            // Cardiovascular
            ['name' => 'Amlodipine 5mg', 'category' => 'Cardiovascular', 'uom' => 'TAB'],
            ['name' => 'Atenolol 50mg', 'category' => 'Cardiovascular', 'uom' => 'TAB'],
            ['name' => 'Lisinopril 10mg', 'category' => 'Cardiovascular', 'uom' => 'TAB'],
            ['name' => 'Simvastatin 20mg', 'category' => 'Cardiovascular', 'uom' => 'TAB'],
            ['name' => 'Aspirin 100mg', 'category' => 'Cardiovascular', 'uom' => 'TAB'],
            ['name' => 'Warfarin 5mg', 'category' => 'Cardiovascular', 'uom' => 'TAB'],

            // Diabetes
            ['name' => 'Metformin 500mg', 'category' => 'Diabetes', 'uom' => 'TAB'],
            ['name' => 'Gliclazide 80mg', 'category' => 'Diabetes', 'uom' => 'TAB'],
            ['name' => 'Insulin Regular', 'category' => 'Diabetes', 'uom' => 'VIAL'],
            ['name' => 'Insulin NPH', 'category' => 'Diabetes', 'uom' => 'VIAL'],
            ['name' => 'Glimepiride 1mg', 'category' => 'Diabetes', 'uom' => 'TAB'],
            ['name' => 'Pioglitazone 15mg', 'category' => 'Diabetes', 'uom' => 'TAB'],

            // Oncology
            ['name' => 'Cisplatin 50mg', 'category' => 'Oncology', 'uom' => 'VIAL'],
            ['name' => 'Paclitaxel 30mg', 'category' => 'Oncology', 'uom' => 'VIAL'],
            ['name' => 'Doxorubicin 10mg', 'category' => 'Oncology', 'uom' => 'VIAL'],
            ['name' => 'Cyclophosphamide 500mg', 'category' => 'Oncology', 'uom' => 'VIAL'],
            ['name' => 'Methotrexate 50mg', 'category' => 'Oncology', 'uom' => 'VIAL'],
            ['name' => '5-Fluorouracil 500mg', 'category' => 'Oncology', 'uom' => 'VIAL'],

            // Vaccines
            ['name' => 'COVID-19 Vaccine', 'category' => 'Vaccines', 'uom' => 'VIAL'],
            ['name' => 'Hepatitis B Vaccine', 'category' => 'Vaccines', 'uom' => 'VIAL'],
            ['name' => 'Influenza Vaccine', 'category' => 'Vaccines', 'uom' => 'VIAL'],
            ['name' => 'MMR Vaccine', 'category' => 'Vaccines', 'uom' => 'VIAL'],
            ['name' => 'Tetanus Vaccine', 'category' => 'Vaccines', 'uom' => 'VIAL'],
            ['name' => 'BCG Vaccine', 'category' => 'Vaccines', 'uom' => 'VIAL'],

            // OTC Medicines
            ['name' => 'Vitamin C 500mg', 'category' => 'OTC Medicines', 'uom' => 'TAB'],
            ['name' => 'Calcium 500mg', 'category' => 'OTC Medicines', 'uom' => 'TAB'],
            ['name' => 'Iron 65mg', 'category' => 'OTC Medicines', 'uom' => 'TAB'],
            ['name' => 'Zinc 50mg', 'category' => 'OTC Medicines', 'uom' => 'TAB'],
            ['name' => 'Folic Acid 5mg', 'category' => 'OTC Medicines', 'uom' => 'TAB'],
            ['name' => 'Multivitamin', 'category' => 'OTC Medicines', 'uom' => 'TAB'],

            // Medical Devices
            ['name' => 'Syringe 5ml', 'category' => 'Medical Devices', 'uom' => 'PCS'],
            ['name' => 'Needle 21G', 'category' => 'Medical Devices', 'uom' => 'PCS'],
            ['name' => 'IV Cannula 18G', 'category' => 'Medical Devices', 'uom' => 'PCS'],
            ['name' => 'Catheter Foley', 'category' => 'Medical Devices', 'uom' => 'PCS'],
            ['name' => 'Glucometer', 'category' => 'Medical Devices', 'uom' => 'PCS'],
            ['name' => 'Blood Pressure Monitor', 'category' => 'Medical Devices', 'uom' => 'PCS'],

            // Surgical Supplies
            ['name' => 'Surgical Gloves L', 'category' => 'Surgical Supplies', 'uom' => 'BOX'],
            ['name' => 'Surgical Mask', 'category' => 'Surgical Supplies', 'uom' => 'BOX'],
            ['name' => 'Gauze Bandage', 'category' => 'Surgical Supplies', 'uom' => 'ROLL'],
            ['name' => 'Surgical Tape', 'category' => 'Surgical Supplies', 'uom' => 'ROLL'],
            ['name' => 'Sutures 3-0', 'category' => 'Surgical Supplies', 'uom' => 'PACK'],
            ['name' => 'Scalpel Blade #10', 'category' => 'Surgical Supplies', 'uom' => 'PCS'],

            // Diagnostic Kits
            ['name' => 'Pregnancy Test Kit', 'category' => 'Diagnostic Kits', 'uom' => 'KIT'],
            ['name' => 'Malaria Test Kit', 'category' => 'Diagnostic Kits', 'uom' => 'KIT'],
            ['name' => 'HIV Test Kit', 'category' => 'Diagnostic Kits', 'uom' => 'KIT'],
            ['name' => 'Blood Glucose Test Strips', 'category' => 'Diagnostic Kits', 'uom' => 'PACK'],
            ['name' => 'Urine Test Strips', 'category' => 'Diagnostic Kits', 'uom' => 'PACK'],
            ['name' => 'COVID-19 Rapid Test', 'category' => 'Diagnostic Kits', 'uom' => 'KIT'],
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
