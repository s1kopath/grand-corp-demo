<?php

namespace Database\Factories;

use App\Models\AccountEntry;
use App\Models\DebitNote;
use App\Models\Indent;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AccountEntry>
 */
class AccountEntryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'indent_id' => Indent::factory(),
            'debit_note_id' => DebitNote::factory(),
            'type' => $this->faker->randomElement(['Debit', 'Credit']),
            'amount' => $this->faker->randomFloat(2, 100, 10000),
            'entry_date' => $this->faker->dateTimeBetween('-30 days', 'now'),
            'notes' => $this->faker->sentence(),
        ];
    }
}
