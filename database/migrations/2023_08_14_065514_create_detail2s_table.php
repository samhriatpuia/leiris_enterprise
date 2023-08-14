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
        Schema::create('detail2s', function (Blueprint $table) {
            $table->id();
            $table->string('particulars');
            $table->string('unit');
            $table->string('quantity');
            $table->bigInteger('discount');
            $table->bigInteger('price');
            $table->bigInteger('amount');
            $table->unsignedBigInteger('sales_id');
            $table->foreign('sales_id')->references('id')->on('sales')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail2s');
    }
};
