<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('debit_notes', function (Blueprint $table) {
            $table->string('debit_note_number')->nullable()->after('number');
            $table->string('reference_number')->nullable()->after('debit_note_number');
            $table->enum('status', ['pending', 'approved', 'paid', 'cancelled'])->default('pending')->after('reference_number');
            $table->date('issue_date')->nullable()->after('status');
            $table->date('due_date')->nullable()->after('issue_date');
            $table->date('paid_date')->nullable()->after('due_date');
            $table->decimal('subtotal', 15, 2)->nullable()->after('paid_date');
            $table->decimal('tax_rate', 5, 2)->default(0)->after('subtotal');
            $table->decimal('tax_amount', 15, 2)->default(0)->after('tax_rate');
            $table->string('currency', 3)->default('USD')->after('tax_amount');
            $table->text('payment_terms')->nullable()->after('currency');
            $table->text('late_payment_fee')->nullable()->after('payment_terms');
            $table->text('terms_conditions')->nullable()->after('late_payment_fee');
            $table->json('charges')->nullable()->after('terms_conditions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('debit_notes', function (Blueprint $table) {
            $table->dropColumn([
                'debit_note_number',
                'reference_number',
                'status',
                'issue_date',
                'due_date',
                'paid_date',
                'subtotal',
                'tax_rate',
                'tax_amount',
                'currency',
                'payment_terms',
                'late_payment_fee',
                'terms_conditions',
                'charges'
            ]);
        });
    }
};
