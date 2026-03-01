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
        Schema::table('stocks', function (Blueprint $table) {
            $table->timestamp('created_at')->nullable()->after('measurement_unit');
            $table->timestamp('updated_at')->nullable()->after('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stocks', function (Blueprint $table) {
            if (Schema::hasColumn('stocks', 'created_at')) {
                $table->dropColumn('created_at');
            }
            if (Schema::hasColumn('stocks', 'updated_at')) {
                $table->dropColumn('updated_at');
            }
        });
    }
};
