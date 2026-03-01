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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->integer('quantity');
            $table->integer('price')->unsigned();
            $table->integer('unit')->unsigned();
            $table->enum('measurement_unit', ['gram', 'liter', 'kg', 'pcs', 'ml']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
