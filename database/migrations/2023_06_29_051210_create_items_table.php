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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('group');
            $table->string('gst');
            $table->string('HSN');
            $table->string('stock_opening');
            $table->string('purchase_price');
            $table->string('selling_price');
            $table->string('batch_no');
            $table->string('manufacture_date');
            $table->string('expiry_date');
            $table->string('units_main');
            $table->string('units_secondary');
            $table->string('units_relation');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
