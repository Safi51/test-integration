<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('g_number');
            $table->date('date');
            $table->date('last_change_date');
            $table->string('supplier_article');
            $table->string('tech_size');
            $table->bigInteger('barcode');
            $table->decimal('total_price', 12, 2);
            $table->unsignedSmallInteger('discount_percent')->default(0);
            $table->boolean('is_supply')->default(false);
            $table->boolean('is_realization')->default(true);
            $table->string('promo_code_discount')->nullable();
            $table->string('warehouse_name');
            $table->string('country_name');
            $table->string('oblast_okrug_name');
            $table->string('region_name');
            $table->unsignedBigInteger('income_id');
            $table->string('sale_id');
            $table->string('odid')->nullable();
            $table->string('spp');
            $table->decimal('for_pay', 12, 2);
            $table->bigInteger('finished_price');
            $table->bigInteger('price_with_disc');
            $table->bigInteger('nm_id');
            $table->string('subject');
            $table->string('category');
            $table->string('brand');
            $table->string('is_storno')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
