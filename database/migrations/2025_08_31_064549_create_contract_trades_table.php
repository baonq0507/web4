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
        Schema::create('contract_trades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->constrained('trading_contracts')->onDelete('cascade');
            
            $table->enum('trade_type', ['entry', 'exit', 'partial_close', 'stop_loss', 'take_profit']);
            $table->decimal('quantity', 20, 8);
            $table->decimal('price', 20, 8);
            $table->decimal('total_value', 20, 8);
            $table->decimal('realized_pnl', 20, 8)->default(0);
            $table->decimal('commission', 20, 8)->default(0);
            
            $table->timestamp('trade_time');
            $table->text('notes')->nullable();
            
            $table->timestamps();
            
            $table->index(['contract_id', 'trade_type']);
            $table->index(['trade_time']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contract_trades');
    }
};
