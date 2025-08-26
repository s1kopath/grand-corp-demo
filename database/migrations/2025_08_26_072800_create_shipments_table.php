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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique();
            $table->foreignId('indent_id')->constrained()->onDelete('cascade');
            $table->foreignId('lc_id')->nullable()->constrained('letter_of_credits')->onDelete('set null');
            $table->enum('status', ['Pending', 'InTransit', 'Arrived', 'Delivered'])->default('Pending');
            $table->date('etd')->nullable();
            $table->date('eta')->nullable();
            $table->date('actual_arrival')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
