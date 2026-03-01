<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stocks', function (Blueprint $table) {

            // Rename price to unit_price
            $table->renameColumn('price', 'unit_price');

            // Drop unused column
            $table->dropColumn('unit');
        });

        Schema::table('stocks', function (Blueprint $table) {

            // Modify columns
            $table->decimal('quantity', 15, 2)->default(0)->change();
            $table->decimal('unit_price', 15, 2)->change();

            // Update enum (if needed)
            $table->enum('measurement_unit', ['gram', 'kg', 'ml', 'liter', 'pcs'])->change();

            // Add new column
            $table->decimal('minimum_stock', 15, 2)->default(0)->after('unit_price');
        });
    }

    public function down(): void
    {
        Schema::table('stocks', function (Blueprint $table) {

            // Revert quantity
            $table->integer('quantity')->change();

            // Revert unit_price back to price
            $table->renameColumn('unit_price', 'price');
            $table->integer('price')->unsigned()->change();

            // Add back removed column
            $table->integer('unit')->unsigned();

            // Remove minimum_stock
            $table->dropColumn('minimum_stock');
        });
    }
};
