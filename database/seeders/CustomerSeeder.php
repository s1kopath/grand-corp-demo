<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Team;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teamA = Team::where('name', 'Team A')->first();
        $teamB = Team::where('name', 'Team B')->first();

        $customers = [
            ['name' => 'ABC Trading Co.', 'code' => 'CUST001', 'contact' => 'John Smith', 'phone' => '+1-555-0101', 'email' => 'john@abctrading.com', 'team_id' => $teamA->id],
            ['name' => 'XYZ Importers', 'code' => 'CUST002', 'contact' => 'Sarah Johnson', 'phone' => '+1-555-0102', 'email' => 'sarah@xyzimporters.com', 'team_id' => $teamA->id],
            ['name' => 'Global Merchants', 'code' => 'CUST003', 'contact' => 'Mike Davis', 'phone' => '+1-555-0103', 'email' => 'mike@globalmerchants.com', 'team_id' => $teamA->id],
            ['name' => 'Pacific Traders', 'code' => 'CUST004', 'contact' => 'Lisa Wang', 'phone' => '+1-555-0104', 'email' => 'lisa@pacifictraders.com', 'team_id' => $teamA->id],
            ['name' => 'Euro Commerce', 'code' => 'CUST005', 'contact' => 'Hans Mueller', 'phone' => '+49-555-0105', 'email' => 'hans@eurocommerce.com', 'team_id' => $teamA->id],
            ['name' => 'Asian Markets', 'code' => 'CUST006', 'contact' => 'Yuki Tanaka', 'phone' => '+81-555-0106', 'email' => 'yuki@asianmarkets.com', 'team_id' => $teamA->id],
            ['name' => 'American Goods', 'code' => 'CUST007', 'contact' => 'Robert Wilson', 'phone' => '+1-555-0107', 'email' => 'robert@americangoods.com', 'team_id' => $teamB->id],
            ['name' => 'British Imports', 'code' => 'CUST008', 'contact' => 'Emma Thompson', 'phone' => '+44-555-0108', 'email' => 'emma@britishimports.com', 'team_id' => $teamB->id],
            ['name' => 'Canadian Trade', 'code' => 'CUST009', 'contact' => 'David Brown', 'phone' => '+1-555-0109', 'email' => 'david@canadiantrade.com', 'team_id' => $teamB->id],
            ['name' => 'Australian Exports', 'code' => 'CUST010', 'contact' => 'Maria Garcia', 'phone' => '+61-555-0110', 'email' => 'maria@australianexports.com', 'team_id' => $teamB->id],
            ['name' => 'South African Trade', 'code' => 'CUST011', 'contact' => 'James Mbeki', 'phone' => '+27-555-0111', 'email' => 'james@southafricantrade.com', 'team_id' => $teamB->id],
            ['name' => 'Indian Markets', 'code' => 'CUST012', 'contact' => 'Priya Patel', 'phone' => '+91-555-0112', 'email' => 'priya@indianmarkets.com', 'team_id' => $teamB->id],
        ];

        foreach ($customers as $customer) {
            Customer::create([
                'name' => $customer['name'],
                'code' => $customer['code'],
                'contact_person' => $customer['contact'],
                'phone' => $customer['phone'],
                'email' => $customer['email'],
                'address' => '123 Business Street, ' . explode(' ', $customer['name'])[0] . ' City, Country',
                'team_id' => $customer['team_id'],
            ]);
        }
    }
}
