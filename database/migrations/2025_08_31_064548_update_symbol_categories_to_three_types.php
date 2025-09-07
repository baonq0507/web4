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
            // Update existing data first
            DB::statement("UPDATE symbols SET category = 'crypto' WHERE category = 'crypto'");
            DB::statement("UPDATE symbols SET category = 'usa' WHERE category = 'stock'");
            DB::statement("UPDATE symbols SET category = 'forex' WHERE category = 'forex'");
            DB::statement("UPDATE symbols SET category = 'forex' WHERE category = 'commodity'");
            
            // Change enum to new values
            $table->enum('category', ['crypto', 'usa', 'forex'])->default('crypto')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('symbols', function (Blueprint $table) {
            // Revert enum to old values
            $table->enum('category', ['forex', 'stock', 'crypto', 'commodity'])->default('forex')->change();
            
            // Revert data
            DB::statement("UPDATE symbols SET category = 'stock' WHERE category = 'usa'");
            DB::statement("UPDATE symbols SET category = 'commodity' WHERE category = 'forex' AND name IN ('Gold', 'Silver', 'Crude Oil')");
        });
    }
};
