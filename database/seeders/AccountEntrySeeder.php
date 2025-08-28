<?php

namespace Database\Seeders;

use App\Models\AccountEntry;
use App\Models\DebitNote;
use App\Models\Indent;
use Illuminate\Database\Seeder;

class AccountEntrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $indents = Indent::all();
        $debitNotes = DebitNote::all();

        // Create account entries for indents
        foreach ($indents as $indent) {
            AccountEntry::create([
                'indent_id' => $indent->id,
                'debit_note_id' => null,
                'type' => 'Debit',
                'amount' => rand(1000, 50000),
                'entry_date' => now()->subDays(rand(1, 30)),
                'notes' => 'Indent related transaction',
            ]);
        }

        // Create account entries for debit notes
        foreach ($debitNotes as $debitNote) {
            AccountEntry::create([
                'indent_id' => null,
                'debit_note_id' => $debitNote->id,
                'type' => 'Credit',
                'amount' => $debitNote->total_amount,
                'entry_date' => $debitNote->issued_at,
                'notes' => 'Debit note payment',
            ]);
        }
    }
}
