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
        Schema::create('account_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('indent_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['Debit', 'Credit']);
            $table->decimal('amount', 15, 2);
            $table->date('entry_date');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_entries');
    }
};
