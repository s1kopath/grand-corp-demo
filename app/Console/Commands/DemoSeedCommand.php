<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Quotation;
use App\Models\QuotationItem;
use App\Models\Indent;
use App\Models\LetterOfCredit;
use App\Models\Shipment;
use App\Models\ShipmentDocument;
use App\Models\Certificate;
use App\Models\DebitNote;
use App\Models\AccountEntry;
use App\Models\Parameter;
use App\Models\Branding;
use App\Models\DataBankRecord;
use App\Models\PriceHistory;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Principal;
use Carbon\Carbon;

class DemoSeedCommand extends Command
{
    protected $signature = 'demo:seed';
    protected $description = 'Seed demo data for Grand Corporation IMS';

    public function handle()
    {
        $this->info('Seeding demo data...');

        // Seed Parameters
        $this->seedParameters();

        // Seed Branding
        $this->seedBranding();

        // Seed Data Bank Records
        $this->seedDataBankRecords();

        // Seed Price History
        $this->seedPriceHistory();

        // Seed Quotations and related data
        $this->seedQuotations();

        // Seed Indents
        $this->seedIndents();

        // Seed Letters of Credit
        $this->seedLetterOfCredits();

        // Seed Shipments
        $this->seedShipments();

        // Seed Debit Notes
        $this->seedDebitNotes();

        // Seed Account Entries
        $this->seedAccountEntries();

        $this->info('Demo data seeded successfully!');
    }

    private function seedParameters()
    {
        $parameters = [
            ['group' => 'currency', 'key' => 'default', 'value' => 'USD'],
            ['group' => 'currency', 'key' => 'supported', 'value' => 'USD,EUR,GBP,JPY'],
            ['group' => 'shipping_term', 'key' => 'FOB', 'value' => 'Free On Board'],
            ['group' => 'shipping_term', 'key' => 'CIF', 'value' => 'Cost, Insurance and Freight'],
            ['group' => 'shipping_term', 'key' => 'EXW', 'value' => 'Ex Works'],
            ['group' => 'status_label', 'key' => 'draft', 'value' => 'Draft'],
            ['group' => 'status_label', 'key' => 'sent', 'value' => 'Sent'],
            ['group' => 'status_label', 'key' => 'approved', 'value' => 'Approved'],
            ['group' => 'document_type', 'key' => 'invoice', 'value' => 'Commercial Invoice'],
            ['group' => 'document_type', 'key' => 'packing', 'value' => 'Packing List'],
            ['group' => 'document_type', 'key' => 'certificate', 'value' => 'Certificate of Origin'],
        ];

        foreach ($parameters as $param) {
            Parameter::updateOrCreate(
                ['group' => $param['group'], 'key' => $param['key']],
                $param
            );
        }
    }

    private function seedBranding()
    {
        Branding::updateOrCreate(
            ['id' => 1],
            [
                'company_name' => 'Grand Corporation IMS',
                'logo_path' => '/assets/img/logo-ct-dark.png',
                'theme_color' => '#1976d2',
            ]
        );
    }

    private function seedDataBankRecords()
    {
        $products = ['LED TV', 'Smartphone', 'Laptop', 'Tablet', 'Headphones'];
        $principals = ['China Steel Corp', 'Korean Electronics Ltd', 'Japanese Auto Parts'];
        $regions = ['Asia', 'Europe', 'North America'];
        $years = [2020, 2021, 2022, 2023, 2024];

        for ($i = 0; $i < 50; $i++) {
            DataBankRecord::create([
                'product_name' => $products[array_rand($products)] . ' ' . rand(1000, 9999),
                'principal_name' => $principals[array_rand($principals)],
                'year' => $years[array_rand($years)],
                'price_usd' => rand(100, 5000),
                'reliability_score' => rand(1, 5),
                'region' => $regions[array_rand($regions)],
                'active' => true,
                'aliases' => ['alias1', 'alias2', 'alias3'],
            ]);
        }
    }

    private function seedPriceHistory()
    {
        $products = ['LED TV', 'Smartphone', 'Laptop'];
        $principals = ['China Steel Corp', 'Korean Electronics Ltd'];
        $years = [2020, 2021, 2022, 2023, 2024];

        foreach ($products as $product) {
            foreach ($principals as $principal) {
                foreach ($years as $year) {
                    PriceHistory::create([
                        'product_name' => $product,
                        'principal_name' => $principal,
                        'year' => $year,
                        'price_usd' => rand(100, 5000),
                    ]);
                }
            }
        }
    }

    private function seedQuotations()
    {
        $customers = Customer::all();
        $products = Product::all();
        $statuses = ['Draft', 'Sent', 'Approved', 'Rejected'];

        for ($i = 1; $i <= 25; $i++) {
            $quotation = Quotation::create([
                'number' => 'Q-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'customer_id' => $customers->random()->id,
                'status' => $statuses[array_rand($statuses)],
                'requested_at' => Carbon::now()->subDays(rand(1, 30)),
                'sent_at' => Carbon::now()->subDays(rand(1, 20)),
                'approved_at' => Carbon::now()->subDays(rand(1, 10)),
            ]);

            // Add items to quotation
            for ($j = 0; $j < rand(1, 5); $j++) {
                $product = $products->random();
                QuotationItem::create([
                    'quotation_id' => $quotation->id,
                    'product_id' => $product->id,
                    'qty' => rand(1, 100),
                    'price' => rand(10, 1000),
                ]);
            }
        }
    }

    private function seedIndents()
    {
        $quotations = Quotation::where('status', 'Approved')->get();
        $customers = Customer::all();
        $principals = Principal::all();
        $statuses = ['Created', 'Approved', 'LC_Issued', 'Shipped', 'Completed'];

        for ($i = 1; $i <= 18; $i++) {
            Indent::create([
                'number' => 'IN-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'quotation_id' => $quotations->count() > 0 ? $quotations->random()->id : null,
                'customer_id' => $customers->random()->id,
                'principal_id' => $principals->random()->id,
                'status' => $statuses[array_rand($statuses)],
                'rate' => rand(100, 1000),
                'sample' => rand(0, 1) ? 'Yes' : 'No',
                'classification' => 'Standard',
            ]);
        }
    }

    private function seedLetterOfCredits()
    {
        $indents = Indent::where('status', 'LC_Issued')->get();
        $customers = Customer::all();
        $banks = ['Chase Bank', 'Wells Fargo', 'Bank of America', 'Citibank'];

        for ($i = 1; $i <= 14; $i++) {
            $issueDate = Carbon::now()->subDays(rand(30, 180));
            LetterOfCredit::create([
                'number' => 'LC-' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'indent_id' => $indents->count() > 0 ? $indents->random()->id : Indent::first()->id,
                'customer_id' => $customers->random()->id,
                'bank_name' => $banks[array_rand($banks)],
                'issue_date' => $issueDate,
                'expiry_date' => $issueDate->copy()->addDays(rand(90, 365)),
                'last_shipment_date' => $issueDate->copy()->addDays(rand(30, 90)),
                'amount' => rand(10000, 100000),
            ]);
        }
    }

    private function seedShipments()
    {
        $indents = Indent::all();
        $lcs = LetterOfCredit::all();
        $statuses = ['Pending', 'InTransit', 'Arrived', 'Delivered'];

        for ($i = 1; $i <= 20; $i++) {
            $shipment = Shipment::create([
                'number' => 'SH-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'indent_id' => $indents->random()->id,
                'lc_id' => $lcs->count() > 0 ? $lcs->random()->id : null,
                'status' => $statuses[array_rand($statuses)],
                'etd' => Carbon::now()->subDays(rand(10, 30)),
                'eta' => Carbon::now()->addDays(rand(5, 15)),
                'actual_arrival' => Carbon::now()->subDays(rand(0, 5)),
            ]);

            // Add documents
            $docTypes = ['Commercial Invoice', 'Packing List', 'Bill of Lading'];
            for ($j = 0; $j < rand(1, 3); $j++) {
                ShipmentDocument::create([
                    'shipment_id' => $shipment->id,
                    'doc_type' => $docTypes[array_rand($docTypes)],
                    'file_path' => '/storage/demo/documents/doc' . rand(1, 10) . '.pdf',
                ]);
            }

            // Add certificates
            if (rand(0, 1)) {
                Certificate::create([
                    'shipment_id' => $shipment->id,
                    'type' => rand(0, 1) ? 'CO' : 'Endorsement',
                    'issued_date' => Carbon::now()->subDays(rand(1, 10)),
                    'notes' => 'Certificate issued for compliance',
                ]);
            }
        }
    }

    private function seedDebitNotes()
    {
        $shipments = Shipment::where('status', 'Delivered')->get();
        $customers = Customer::all();

        for ($i = 1; $i <= 12; $i++) {
            DebitNote::create([
                'number' => 'DN-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'shipment_id' => $shipments->count() > 0 ? $shipments->random()->id : Shipment::first()->id,
                'customer_id' => $customers->random()->id,
                'total_amount' => rand(5000, 50000),
                'issued_at' => Carbon::now()->subDays(rand(1, 30)),
            ]);
        }
    }

    private function seedAccountEntries()
    {
        $indents = Indent::all();

        foreach ($indents as $indent) {
            // Create debit entries
            for ($i = 0; $i < rand(2, 5); $i++) {
                AccountEntry::create([
                    'indent_id' => $indent->id,
                    'type' => 'Debit',
                    'amount' => rand(1000, 10000),
                    'entry_date' => Carbon::now()->subDays(rand(1, 30)),
                    'notes' => 'Debit entry for ' . $indent->number,
                ]);
            }

            // Create credit entries
            for ($i = 0; $i < rand(1, 3); $i++) {
                AccountEntry::create([
                    'indent_id' => $indent->id,
                    'type' => 'Credit',
                    'amount' => rand(500, 5000),
                    'entry_date' => Carbon::now()->subDays(rand(1, 30)),
                    'notes' => 'Credit entry for ' . $indent->number,
                ]);
            }
        }
    }
}
