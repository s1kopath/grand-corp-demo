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
        Schema::create('data_bank_records', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->string('principal_name');
            $table->integer('year');
            $table->decimal('price_usd', 10, 2);
            $table->integer('reliability_score')->comment('1-5 scale');
            $table->string('region');
            $table->boolean('active')->default(true);
            $table->json('aliases')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_bank_records');
    }
};
