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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('unit_measure', ['Unidad', 'Display', 'Caja'])->default('Unidad');
            $table->longText('observation')->nullable()->default(null);
            $table->integer('stock');
            $table->date('shipment_date')->nullable()->default(null);
            $table->tinyInteger('status')->default(0);

            $table->timestamps();

            $table->unsignedBigInteger('brand_id');

            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
