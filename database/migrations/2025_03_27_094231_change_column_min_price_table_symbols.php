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
        Schema::table('symbols', function (Blueprint $table) {
            $table->bigInteger('min_price')->nullable()->default(82000)->change();
            $table->bigInteger('max_price')->nullable()->default(84000)->change();
            $table->integer('min_change')->nullable()->default(1)->change();
            $table->integer('max_change')->nullable()->default(3)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('symbols', function (Blueprint $table) {
            $table->bigInteger('min_price')->nullable()->default(0)->change();
            $table->bigInteger('max_price')->nullable()->default(0)->change();
            $table->integer('min_change')->nullable()->default(0)->change();
            $table->integer('max_change')->nullable()->default(0)->change();
        });
    }
};
