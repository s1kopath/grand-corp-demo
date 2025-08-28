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
        Schema::table('account_entries', function (Blueprint $table) {
            $table->foreignId('debit_note_id')->nullable()->after('indent_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('account_entries', function (Blueprint $table) {
            $table->dropForeign(['debit_note_id']);
            $table->dropColumn('debit_note_id');
        });
    }
};
