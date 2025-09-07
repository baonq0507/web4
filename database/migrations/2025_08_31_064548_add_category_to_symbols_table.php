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
            $table->enum('category', ['forex', 'stock', 'crypto', 'commodity'])->default('forex')->after('status');
            $table->string('description')->nullable()->after('category');
            $table->string('base_currency')->nullable()->after('description');
            $table->string('quote_currency')->nullable()->after('base_currency');
            $table->decimal('tick_size', 10, 8)->default(0.00001)->after('quote_currency');
            $table->decimal('lot_size', 10, 2)->default(1.00)->after('tick_size');
            $table->boolean('is_margin_trading')->default(false)->after('lot_size');
            $table->integer('max_leverage')->default(1)->after('is_margin_trading');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('symbols', function (Blueprint $table) {
            $table->dropColumn([
                'category',
                'description', 
                'base_currency',
                'quote_currency',
                'tick_size',
                'lot_size',
                'is_margin_trading',
                'max_leverage'
            ]);
        });
    }
};
