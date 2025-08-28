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
            // Antibiotics
            ['name' => 'Amoxicillin 500mg', 'category' => 'Antibiotics', 'description' => 'Broad-spectrum antibiotic for bacterial infections', 'uom' => 'TAB'],
            ['name' => 'Ciprofloxacin 250mg', 'category' => 'Antibiotics', 'description' => 'Fluoroquinolone antibiotic for various infections', 'uom' => 'TAB'],
            ['name' => 'Azithromycin 500mg', 'category' => 'Antibiotics', 'description' => 'Macrolide antibiotic for respiratory infections', 'uom' => 'TAB'],
            ['name' => 'Doxycycline 100mg', 'category' => 'Antibiotics', 'description' => 'Tetracycline antibiotic for various infections', 'uom' => 'CAP'],
            ['name' => 'Metronidazole 400mg', 'category' => 'Antibiotics', 'description' => 'Antibiotic for anaerobic bacterial infections', 'uom' => 'TAB'],

            // Analgesics
            ['name' => 'Paracetamol 500mg', 'category' => 'Analgesics', 'description' => 'Pain reliever and fever reducer', 'uom' => 'TAB'],
            ['name' => 'Ibuprofen 400mg', 'category' => 'Analgesics', 'description' => 'Non-steroidal anti-inflammatory drug', 'uom' => 'TAB'],
            ['name' => 'Diclofenac 50mg', 'category' => 'Analgesics', 'description' => 'NSAID for pain and inflammation', 'uom' => 'TAB'],
            ['name' => 'Tramadol 50mg', 'category' => 'Analgesics', 'description' => 'Opioid pain medication', 'uom' => 'CAP'],
            ['name' => 'Morphine 10mg', 'category' => 'Analgesics', 'description' => 'Strong opioid pain reliever', 'uom' => 'AMP'],

            // Cardiovascular
            ['name' => 'Amlodipine 5mg', 'category' => 'Cardiovascular', 'description' => 'Calcium channel blocker for hypertension', 'uom' => 'TAB'],
            ['name' => 'Metoprolol 50mg', 'category' => 'Cardiovascular', 'description' => 'Beta-blocker for heart conditions', 'uom' => 'TAB'],
            ['name' => 'Losartan 50mg', 'category' => 'Cardiovascular', 'description' => 'Angiotensin receptor blocker', 'uom' => 'TAB'],
            ['name' => 'Atorvastatin 20mg', 'category' => 'Cardiovascular', 'description' => 'Statin for cholesterol management', 'uom' => 'TAB'],
            ['name' => 'Aspirin 100mg', 'category' => 'Cardiovascular', 'description' => 'Blood thinner and pain reliever', 'uom' => 'TAB'],

            // Diabetes
            ['name' => 'Metformin 500mg', 'category' => 'Diabetes', 'description' => 'First-line diabetes medication', 'uom' => 'TAB'],
            ['name' => 'Glimepiride 1mg', 'category' => 'Diabetes', 'description' => 'Sulfonylurea for diabetes', 'uom' => 'TAB'],
            ['name' => 'Insulin Regular', 'category' => 'Diabetes', 'description' => 'Short-acting insulin injection', 'uom' => 'VIAL'],
            ['name' => 'Insulin NPH', 'category' => 'Diabetes', 'description' => 'Intermediate-acting insulin', 'uom' => 'VIAL'],
            ['name' => 'Sitagliptin 100mg', 'category' => 'Diabetes', 'description' => 'DPP-4 inhibitor for diabetes', 'uom' => 'TAB'],

            // Oncology
            ['name' => 'Cisplatin 50mg', 'category' => 'Oncology', 'description' => 'Platinum-based chemotherapy drug', 'uom' => 'VIAL'],
            ['name' => 'Doxorubicin 50mg', 'category' => 'Oncology', 'description' => 'Anthracycline chemotherapy', 'uom' => 'VIAL'],
            ['name' => 'Paclitaxel 100mg', 'category' => 'Oncology', 'description' => 'Taxane chemotherapy drug', 'uom' => 'VIAL'],
            ['name' => 'Carboplatin 450mg', 'category' => 'Oncology', 'description' => 'Platinum-based chemotherapy', 'uom' => 'VIAL'],
            ['name' => 'Gemcitabine 1g', 'category' => 'Oncology', 'description' => 'Nucleoside analogue chemotherapy', 'uom' => 'VIAL'],

            // Vaccines
            ['name' => 'COVID-19 Vaccine', 'category' => 'Vaccines', 'description' => 'SARS-CoV-2 vaccine for COVID-19', 'uom' => 'VIAL'],
            ['name' => 'Hepatitis B Vaccine', 'category' => 'Vaccines', 'description' => 'Vaccine for hepatitis B prevention', 'uom' => 'VIAL'],
            ['name' => 'Influenza Vaccine', 'category' => 'Vaccines', 'description' => 'Annual flu vaccine', 'uom' => 'VIAL'],
            ['name' => 'MMR Vaccine', 'category' => 'Vaccines', 'description' => 'Measles, Mumps, Rubella vaccine', 'uom' => 'VIAL'],
            ['name' => 'BCG Vaccine', 'category' => 'Vaccines', 'description' => 'Tuberculosis vaccine', 'uom' => 'VIAL'],

            // OTC Medicines
            ['name' => 'Vitamin C 500mg', 'category' => 'OTC Medicines', 'description' => 'Ascorbic acid supplement', 'uom' => 'TAB'],
            ['name' => 'Calcium 500mg', 'category' => 'OTC Medicines', 'description' => 'Calcium carbonate supplement', 'uom' => 'TAB'],
            ['name' => 'Iron 65mg', 'category' => 'OTC Medicines', 'description' => 'Ferrous sulfate supplement', 'uom' => 'TAB'],
            ['name' => 'Zinc 50mg', 'category' => 'OTC Medicines', 'description' => 'Zinc sulfate supplement', 'uom' => 'TAB'],
            ['name' => 'Folic Acid 5mg', 'category' => 'OTC Medicines', 'description' => 'Folate supplement', 'uom' => 'TAB'],

            // Medical Devices
            ['name' => 'Stethoscope', 'category' => 'Medical Devices', 'description' => 'Professional medical stethoscope', 'uom' => 'PCS'],
            ['name' => 'Blood Pressure Monitor', 'category' => 'Medical Devices', 'description' => 'Digital BP monitoring device', 'uom' => 'PCS'],
            ['name' => 'Thermometer Digital', 'category' => 'Medical Devices', 'description' => 'Digital medical thermometer', 'uom' => 'PCS'],
            ['name' => 'Pulse Oximeter', 'category' => 'Medical Devices', 'description' => 'Blood oxygen saturation monitor', 'uom' => 'PCS'],
            ['name' => 'Glucometer', 'category' => 'Medical Devices', 'description' => 'Blood glucose monitoring device', 'uom' => 'PCS'],

            // Surgical Supplies
            ['name' => 'Surgical Mask', 'category' => 'Surgical Supplies', 'description' => '3-ply surgical face mask', 'uom' => 'PACK'],
            ['name' => 'Surgical Gloves', 'category' => 'Surgical Supplies', 'description' => 'Latex-free surgical gloves', 'uom' => 'BOX'],
            ['name' => 'Syringe 5ml', 'category' => 'Surgical Supplies', 'description' => 'Disposable 5ml syringe', 'uom' => 'PCS'],
            ['name' => 'Needle 21G', 'category' => 'Surgical Supplies', 'description' => '21-gauge hypodermic needle', 'uom' => 'PCS'],
            ['name' => 'IV Cannula 18G', 'category' => 'Surgical Supplies', 'description' => '18-gauge IV cannula', 'uom' => 'PCS'],

            // Diagnostic Kits
            ['name' => 'COVID-19 Test Kit', 'category' => 'Diagnostic Kits', 'description' => 'Rapid antigen test for COVID-19', 'uom' => 'KIT'],
            ['name' => 'Pregnancy Test Kit', 'category' => 'Diagnostic Kits', 'description' => 'Urine pregnancy test', 'uom' => 'KIT'],
            ['name' => 'Blood Glucose Test Kit', 'category' => 'Diagnostic Kits', 'description' => 'Blood glucose monitoring kit', 'uom' => 'KIT'],
            ['name' => 'Malaria Test Kit', 'category' => 'Diagnostic Kits', 'description' => 'Rapid malaria diagnostic test', 'uom' => 'KIT'],
            ['name' => 'HIV Test Kit', 'category' => 'Diagnostic Kits', 'description' => 'Rapid HIV screening test', 'uom' => 'KIT'],
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
