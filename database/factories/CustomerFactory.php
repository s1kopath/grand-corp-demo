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
            ['name' => 'ABC Trading Co.', 'code' => 'CUST001', 'contact' => 'John Smith', 'phone' => '+1-555-0101', 'email' => 'john@abctrading.com', 'company' => 'ABC Trading Co.', 'region' => 'North America', 'status' => 'active'],
            ['name' => 'XYZ Importers', 'code' => 'CUST002', 'contact' => 'Sarah Johnson', 'phone' => '+1-555-0102', 'email' => 'sarah@xyzimporters.com', 'company' => 'XYZ Importers Ltd.', 'region' => 'North America', 'status' => 'active'],
            ['name' => 'Global Merchants', 'code' => 'CUST003', 'contact' => 'Mike Davis', 'phone' => '+1-555-0103', 'email' => 'mike@globalmerchants.com', 'company' => 'Global Merchants Inc.', 'region' => 'North America', 'status' => 'active'],
            ['name' => 'Pacific Traders', 'code' => 'CUST004', 'contact' => 'Lisa Wang', 'phone' => '+1-555-0104', 'email' => 'lisa@pacifictraders.com', 'company' => 'Pacific Traders Co.', 'region' => 'Asia', 'status' => 'active'],
            ['name' => 'Euro Commerce', 'code' => 'CUST005', 'contact' => 'Hans Mueller', 'phone' => '+49-555-0105', 'email' => 'hans@eurocommerce.com', 'company' => 'Euro Commerce GmbH', 'region' => 'Europe', 'status' => 'active'],
            ['name' => 'Asian Markets', 'code' => 'CUST006', 'contact' => 'Yuki Tanaka', 'phone' => '+81-555-0106', 'email' => 'yuki@asianmarkets.com', 'company' => 'Asian Markets Ltd.', 'region' => 'Asia', 'status' => 'active'],
            ['name' => 'American Goods', 'code' => 'CUST007', 'contact' => 'Robert Wilson', 'phone' => '+1-555-0107', 'email' => 'robert@americangoods.com', 'company' => 'American Goods Corp.', 'region' => 'North America', 'status' => 'inactive'],
            ['name' => 'British Imports', 'code' => 'CUST008', 'contact' => 'Emma Thompson', 'phone' => '+44-555-0108', 'email' => 'emma@britishimports.com', 'company' => 'British Imports Ltd.', 'region' => 'Europe', 'status' => 'active'],
            ['name' => 'Canadian Trade', 'code' => 'CUST009', 'contact' => 'David Brown', 'phone' => '+1-555-0109', 'email' => 'david@canadiantrade.com', 'company' => 'Canadian Trade Inc.', 'region' => 'North America', 'status' => 'prospect'],
            ['name' => 'Australian Exports', 'code' => 'CUST010', 'contact' => 'Maria Garcia', 'phone' => '+61-555-0110', 'email' => 'maria@australianexports.com', 'company' => 'Australian Exports Pty.', 'region' => 'Oceania', 'status' => 'active'],
            ['name' => 'South African Trade', 'code' => 'CUST011', 'contact' => 'James Mbeki', 'phone' => '+27-555-0111', 'email' => 'james@southafricantrade.com', 'company' => 'South African Trade Ltd.', 'region' => 'Africa', 'status' => 'prospect'],
            ['name' => 'Indian Markets', 'code' => 'CUST012', 'contact' => 'Priya Patel', 'phone' => '+91-555-0112', 'email' => 'priya@indianmarkets.com', 'company' => 'Indian Markets Pvt.', 'region' => 'Asia', 'status' => 'active'],
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
