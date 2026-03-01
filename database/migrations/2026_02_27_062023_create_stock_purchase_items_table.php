<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stock_purchase_items', function (Blueprint $table) {
            $table->id();

            // Relasi ke header pembelian
            $table->foreignId('stock_purchase_id')
                ->constrained()
                ->cascadeOnDelete();

            // Relasi ke bahan / stock
            $table->foreignId('stock_id')
                ->constrained()
                ->cascadeOnDelete();

            // Jumlah yang dibeli
            $table->decimal('quantity', 15, 2);

            // Harga per unit saat dibeli
            $table->decimal('unit_price', 15, 2);

            // Total = quantity × unit_price
            $table->decimal('total', 15, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_purchase_items');
    }
};
