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
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            // $table->string('HSN')->nullable();
            $table->bigInteger('item_id')->unsigned();
            $table->string('purchase_price')->nullable();
            $table->string('mrp')->nullable();
            $table->string('batch_no')->nullable();
            $table->date('manufacture_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->string('units_main')->nullable();
            $table->string('main_stock')->nullable();
            $table->string('main_selling_price')->nullable();
            $table->string('units_secondary')->nullable();
            $table->string('units_relation')->nullable();
            $table->string('secondary_stock')->nullable();
            $table->string('secondary_unit_price')->nullable();
            $table->timestamps();
           
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batches');
    }
};
