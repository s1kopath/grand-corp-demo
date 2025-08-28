<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Shipment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DebitNote>
 */
class DebitNoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $issueDate = $this->faker->dateTimeBetween('-30 days', 'now');
        $dueDate = $this->faker->dateTimeBetween($issueDate, '+30 days');
        $subtotal = $this->faker->randomFloat(2, 1000, 50000);
        $taxRate = $this->faker->randomFloat(2, 0, 15);
        $taxAmount = $subtotal * ($taxRate / 100);
        $totalAmount = $subtotal + $taxAmount;

        return [
            'number' => 'DN-' . $this->faker->unique()->numberBetween(1000, 9999),
            'debit_note_number' => 'DN-' . $this->faker->unique()->numberBetween(1000, 9999),
            'reference_number' => 'REF-' . $this->faker->unique()->numberBetween(10000, 99999),
            'shipment_id' => Shipment::factory(),
            'customer_id' => Customer::factory(),
            'status' => $this->faker->randomElement(['pending', 'approved', 'paid', 'cancelled']),
            'issue_date' => $issueDate,
            'due_date' => $dueDate,
            'paid_date' => $this->faker->optional(0.3)->dateTimeBetween($issueDate, $dueDate),
            'total_amount' => $totalAmount,
            'subtotal' => $subtotal,
            'tax_rate' => $taxRate,
            'tax_amount' => $taxAmount,
            'currency' => 'USD',
            'payment_terms' => 'Net 30 days',
            'late_payment_fee' => '2% per month',
            'terms_conditions' => 'Standard payment terms apply. Payment is due within the specified period. Late payments may incur additional charges.',
            'charges' => [
                ['description' => 'Freight Charges', 'amount' => $this->faker->randomFloat(2, 100, 1000)],
                ['description' => 'Insurance', 'amount' => $this->faker->randomFloat(2, 50, 500)],
                ['description' => 'Handling Fee', 'amount' => $this->faker->randomFloat(2, 25, 250)],
            ],
            'issued_at' => $issueDate,
        ];
    }
}
