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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            
            $table->string('date');
            $table->string('invoice_number');
            $table->bigInteger('logistic_charge')->nullable();
            $table->bigInteger('handling_charge')->nullable();
            $table->bigInteger('discount')->nullable();
            $table->string('scheme')->nullable();
            $table->bigInteger('sub_total')->nullable();
            $table->bigInteger('grand_total')->nullable();
            $table->unsignedBigInteger('customer_id');
            $table->timestamps();

            // $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
