<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Update products table
        |--------------------------------------------------------------------------
        */
        Schema::table('products', function (Blueprint $table) {

            // Rename price to selling_price
            if (Schema::hasColumn('products', 'price')) {
                $table->renameColumn('price', 'selling_price');
            }
        });

        Schema::table('products', function (Blueprint $table) {

            // Change type to decimal
            $table->decimal('selling_price', 15, 2)->change();
        });


        /*
        |--------------------------------------------------------------------------
        | Update product_ingredients table
        |--------------------------------------------------------------------------
        */
        Schema::table('product_ingredients', function (Blueprint $table) {

            // Rename typo column
            if (Schema::hasColumn('product_ingredients', 'quantity_reqires')) {
                $table->renameColumn('quantity_reqires', 'quantity_required');
            }
        });

        Schema::table('product_ingredients', function (Blueprint $table) {

            // Change quantity type to decimal
            $table->decimal('quantity_required', 15, 2)->change();

            // Add timestamps if not exists
            if (!Schema::hasColumn('product_ingredients', 'created_at')) {
                $table->timestamps();
            }
        });
    }

    public function down(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Revert products
        |--------------------------------------------------------------------------
        */
        Schema::table('products', function (Blueprint $table) {
            $table->renameColumn('selling_price', 'price');
            $table->integer('price')->unsigned()->change();
        });

        /*
        |--------------------------------------------------------------------------
        | Revert product_ingredients
        |--------------------------------------------------------------------------
        */
        Schema::table('product_ingredients', function (Blueprint $table) {
            $table->renameColumn('quantity_required', 'quantity_reqires');
            $table->integer('quantity_reqires')->unsigned()->change();
            $table->dropTimestamps();
        });
    }
};
