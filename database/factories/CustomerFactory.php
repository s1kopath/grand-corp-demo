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
            ['name' => 'ABC Trading Co.', 'code' => 'CUST001', 'contact' => 'John Smith', 'phone' => '+1-555-0101', 'email' => 'john@abctrading.com'],
            ['name' => 'XYZ Importers', 'code' => 'CUST002', 'contact' => 'Sarah Johnson', 'phone' => '+1-555-0102', 'email' => 'sarah@xyzimporters.com'],
            ['name' => 'Global Merchants', 'code' => 'CUST003', 'contact' => 'Mike Davis', 'phone' => '+1-555-0103', 'email' => 'mike@globalmerchants.com'],
            ['name' => 'Pacific Traders', 'code' => 'CUST004', 'contact' => 'Lisa Wang', 'phone' => '+1-555-0104', 'email' => 'lisa@pacifictraders.com'],
            ['name' => 'Euro Commerce', 'code' => 'CUST005', 'contact' => 'Hans Mueller', 'phone' => '+49-555-0105', 'email' => 'hans@eurocommerce.com'],
            ['name' => 'Asian Markets', 'code' => 'CUST006', 'contact' => 'Yuki Tanaka', 'phone' => '+81-555-0106', 'email' => 'yuki@asianmarkets.com'],
            ['name' => 'American Goods', 'code' => 'CUST007', 'contact' => 'Robert Wilson', 'phone' => '+1-555-0107', 'email' => 'robert@americangoods.com'],
            ['name' => 'British Imports', 'code' => 'CUST008', 'contact' => 'Emma Thompson', 'phone' => '+44-555-0108', 'email' => 'emma@britishimports.com'],
            ['name' => 'Canadian Trade', 'code' => 'CUST009', 'contact' => 'David Brown', 'phone' => '+1-555-0109', 'email' => 'david@canadiantrade.com'],
            ['name' => 'Australian Exports', 'code' => 'CUST010', 'contact' => 'Maria Garcia', 'phone' => '+61-555-0110', 'email' => 'maria@australianexports.com'],
            ['name' => 'South African Trade', 'code' => 'CUST011', 'contact' => 'James Mbeki', 'phone' => '+27-555-0111', 'email' => 'james@southafricantrade.com'],
            ['name' => 'Indian Markets', 'code' => 'CUST012', 'contact' => 'Priya Patel', 'phone' => '+91-555-0112', 'email' => 'priya@indianmarkets.com'],
        ];

        $customer = $this->faker->unique()->randomElement($customers);

        return [
            'name' => $customer['name'],
            'code' => $customer['code'],
            'contact_person' => $customer['contact'],
            'phone' => $customer['phone'],
            'email' => $customer['email'],
            'address' => $this->faker->address(),
            'team_id' => Team::factory(),
        ];
    }
}
