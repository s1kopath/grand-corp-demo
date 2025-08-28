<?php

namespace Database\Seeders;

use App\Models\DebitNote;
use App\Models\Shipment;
use App\Models\Customer;
use Illuminate\Database\Seeder;

class DebitNoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $shipments = Shipment::all();
        $customers = Customer::all();
        $statuses = ['pending', 'approved', 'paid', 'cancelled'];

        for ($i = 1; $i <= 12; $i++) {
            $issueDate = now()->subDays(rand(1, 30));
            $dueDate = $issueDate->copy()->addDays(rand(15, 45));
            $subtotal = rand(1000, 50000);
            $taxRate = rand(0, 15);
            $taxAmount = $subtotal * ($taxRate / 100);
            $totalAmount = $subtotal + $taxAmount;

            DebitNote::create([
                'number' => 'DN-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'debit_note_number' => 'DN-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'reference_number' => 'REF-' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'shipment_id' => $shipments->count() > 0 ? $shipments->random()->id : null,
                'customer_id' => $customers->random()->id,
                'status' => $statuses[array_rand($statuses)],
                'issue_date' => $issueDate,
                'due_date' => $dueDate,
                'paid_date' => rand(0, 1) ? $issueDate->copy()->addDays(rand(1, 30)) : null,
                'total_amount' => $totalAmount,
                'subtotal' => $subtotal,
                'tax_rate' => $taxRate,
                'tax_amount' => $taxAmount,
                'currency' => 'USD',
                'payment_terms' => 'Net 30 days',
                'late_payment_fee' => '2% per month',
                'terms_conditions' => 'Standard payment terms apply. Payment is due within the specified period. Late payments may incur additional charges.',
                'charges' => [
                    ['description' => 'Freight Charges', 'amount' => rand(100, 1000)],
                    ['description' => 'Insurance', 'amount' => rand(50, 500)],
                    ['description' => 'Handling Fee', 'amount' => rand(25, 250)],
                ],
                'issued_at' => $issueDate,
            ]);
        }
    }
}
