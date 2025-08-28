<?php

namespace Database\Factories;

use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $customers = [
            // Major Hospitals
            ['name' => 'Dhaka Medical College Hospital', 'code' => 'CUST001', 'contact' => 'Dr. Ahmed Khan', 'phone' => '+880-2-966-0011', 'email' => 'dmch@health.gov.bd', 'company' => 'Dhaka Medical College Hospital', 'region' => 'Dhaka', 'status' => 'active'],
            ['name' => 'Bangabandhu Sheikh Mujib Medical University', 'code' => 'CUST002', 'contact' => 'Dr. Fatima Rahman', 'phone' => '+880-2-861-0791', 'email' => 'bsmmu@health.gov.bd', 'company' => 'BSMMU Hospital', 'region' => 'Dhaka', 'status' => 'active'],
            ['name' => 'Chittagong Medical College Hospital', 'code' => 'CUST003', 'contact' => 'Dr. Mohammad Ali', 'phone' => '+880-31-631-0011', 'email' => 'cmch@health.gov.bd', 'company' => 'CMCH Hospital', 'region' => 'Chittagong', 'status' => 'active'],
            ['name' => 'Rajshahi Medical College Hospital', 'code' => 'CUST004', 'contact' => 'Dr. Nasreen Begum', 'phone' => '+880-721-761-0011', 'email' => 'rmch@health.gov.bd', 'company' => 'RMCH Hospital', 'region' => 'Rajshahi', 'status' => 'active'],
            ['name' => 'Sylhet MAG Osmani Medical College Hospital', 'code' => 'CUST005', 'contact' => 'Dr. Kamal Hossain', 'phone' => '+880-821-713-0011', 'email' => 'smch@health.gov.bd', 'company' => 'SMCH Hospital', 'region' => 'Sylhet', 'status' => 'active'],

            // Private Hospitals
            ['name' => 'Square Hospital Ltd', 'code' => 'CUST006', 'contact' => 'Dr. Sarah Johnson', 'phone' => '+880-2-814-4000', 'email' => 'info@squarehospital.com', 'company' => 'Square Hospital Ltd', 'region' => 'Dhaka', 'status' => 'active'],
            ['name' => 'Apollo Hospitals Dhaka', 'code' => 'CUST007', 'contact' => 'Dr. Michael Chen', 'phone' => '+880-2-843-1661', 'email' => 'dhaka@apollohospitals.com', 'company' => 'Apollo Hospitals Dhaka', 'region' => 'Dhaka', 'status' => 'active'],
            ['name' => 'United Hospital Ltd', 'code' => 'CUST008', 'contact' => 'Dr. Emily Davis', 'phone' => '+880-2-883-6444', 'email' => 'info@uhlbd.com', 'company' => 'United Hospital Ltd', 'region' => 'Dhaka', 'status' => 'active'],
            ['name' => 'Popular Medical Centre', 'code' => 'CUST009', 'contact' => 'Dr. Robert Wilson', 'phone' => '+880-2-955-8833', 'email' => 'pmc@popular.com', 'company' => 'Popular Medical Centre', 'region' => 'Dhaka', 'status' => 'active'],
            ['name' => 'Labaid Specialized Hospital', 'code' => 'CUST010', 'contact' => 'Dr. Lisa Wang', 'phone' => '+880-2-967-0101', 'email' => 'info@labaidgroup.com', 'company' => 'Labaid Specialized Hospital', 'region' => 'Dhaka', 'status' => 'active'],

            // Medical Centers & Clinics
            ['name' => 'Ibn Sina Medical Centre', 'code' => 'CUST011', 'contact' => 'Dr. Hans Mueller', 'phone' => '+880-2-966-0011', 'email' => 'ibnsina@medical.com', 'company' => 'Ibn Sina Medical Centre', 'region' => 'Dhaka', 'status' => 'active'],
            ['name' => 'Central Medical Centre', 'code' => 'CUST012', 'contact' => 'Dr. Yuki Tanaka', 'phone' => '+880-2-955-8833', 'email' => 'cmc@central.com', 'company' => 'Central Medical Centre', 'region' => 'Dhaka', 'status' => 'active'],
            ['name' => 'Green Life Medical Centre', 'code' => 'CUST013', 'contact' => 'Dr. Emma Thompson', 'phone' => '+880-2-966-0011', 'email' => 'glmc@greenlife.com', 'company' => 'Green Life Medical Centre', 'region' => 'Dhaka', 'status' => 'active'],
            ['name' => 'City Heart Institute', 'code' => 'CUST014', 'contact' => 'Dr. David Brown', 'phone' => '+880-2-955-8833', 'email' => 'chi@cityheart.com', 'company' => 'City Heart Institute', 'region' => 'Dhaka', 'status' => 'active'],
            ['name' => 'National Heart Foundation', 'code' => 'CUST015', 'contact' => 'Dr. Maria Garcia', 'phone' => '+880-2-966-0011', 'email' => 'nhf@heartfoundation.com', 'company' => 'National Heart Foundation', 'region' => 'Dhaka', 'status' => 'active'],

            // Pharmacies & Drug Stores
            ['name' => 'Apex Pharmacy', 'code' => 'CUST016', 'contact' => 'James Mbeki', 'phone' => '+880-2-955-8833', 'email' => 'apex@pharmacy.com', 'company' => 'Apex Pharmacy Ltd', 'region' => 'Dhaka', 'status' => 'active'],
            ['name' => 'MediCare Pharmacy', 'code' => 'CUST017', 'contact' => 'Priya Patel', 'phone' => '+880-2-966-0011', 'email' => 'medicare@pharmacy.com', 'company' => 'MediCare Pharmacy', 'region' => 'Dhaka', 'status' => 'active'],
            ['name' => 'HealthCare Pharmacy', 'code' => 'CUST018', 'contact' => 'Dr. Ahmed Khan', 'phone' => '+880-2-955-8833', 'email' => 'healthcare@pharmacy.com', 'company' => 'HealthCare Pharmacy', 'region' => 'Dhaka', 'status' => 'active'],
            ['name' => 'LifeCare Pharmacy', 'code' => 'CUST019', 'contact' => 'Dr. Fatima Rahman', 'phone' => '+880-2-966-0011', 'email' => 'lifecare@pharmacy.com', 'company' => 'LifeCare Pharmacy', 'region' => 'Dhaka', 'status' => 'active'],
            ['name' => 'Wellness Pharmacy', 'code' => 'CUST020', 'contact' => 'Dr. Mohammad Ali', 'phone' => '+880-2-955-8833', 'email' => 'wellness@pharmacy.com', 'company' => 'Wellness Pharmacy', 'region' => 'Dhaka', 'status' => 'active'],

            // Diagnostic Centers
            ['name' => 'Popular Diagnostic Centre', 'code' => 'CUST021', 'contact' => 'Dr. Nasreen Begum', 'phone' => '+880-2-966-0011', 'email' => 'pdc@popular.com', 'company' => 'Popular Diagnostic Centre', 'region' => 'Dhaka', 'status' => 'active'],
            ['name' => 'Labaid Diagnostic Centre', 'code' => 'CUST022', 'contact' => 'Dr. Kamal Hossain', 'phone' => '+880-2-955-8833', 'email' => 'ldc@labaidgroup.com', 'company' => 'Labaid Diagnostic Centre', 'region' => 'Dhaka', 'status' => 'active'],
            ['name' => 'Square Diagnostic Centre', 'code' => 'CUST023', 'contact' => 'Dr. Sarah Johnson', 'phone' => '+880-2-966-0011', 'email' => 'sdc@squarehospital.com', 'company' => 'Square Diagnostic Centre', 'region' => 'Dhaka', 'status' => 'active'],

            // Government Health Centers
            ['name' => 'Upazila Health Complex', 'code' => 'CUST024', 'contact' => 'Dr. Michael Chen', 'phone' => '+880-2-955-8833', 'email' => 'uhc@health.gov.bd', 'company' => 'Upazila Health Complex', 'region' => 'Dhaka', 'status' => 'active'],
            ['name' => 'Community Clinic', 'code' => 'CUST025', 'contact' => 'Dr. Emily Davis', 'phone' => '+880-2-966-0011', 'email' => 'cc@health.gov.bd', 'company' => 'Community Clinic', 'region' => 'Dhaka', 'status' => 'active'],
        ];

        $customer = $this->faker->unique()->randomElement($customers);

        return [
            'name' => $customer['name'],
            'code' => $customer['code'],
            'contact_person' => $customer['contact'],
            'phone' => $customer['phone'],
            'email' => $customer['email'],
            'address' => $this->faker->address(),
            'company' => $customer['company'],
            'region' => $customer['region'],
            'status' => $customer['status'],
            'team_id' => Team::factory(),
        ];
    }
}
