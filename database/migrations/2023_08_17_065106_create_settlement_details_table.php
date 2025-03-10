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
        Schema::create('settlement_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('amount')->nullable();
            $table->bigInteger('balance')->nullable();
            $table->string('mode')->nullable();
            $table->string('payer')->nullable();
            $table->string('recieve_by')->nullable();
            $table->bigInteger('grand_total')->nullable();
            $table->string('transaction_id')->nullable();
            $table->unsignedBigInteger('settlement_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settlement_details');
    }
};
