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
        Schema::create('trading_contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('symbol_id')->constrained()->onDelete('cascade');
            $table->foreignId('strategy_id')->nullable()->constrained('trading_strategies')->onDelete('set null');
            $table->foreignId('parent_contract_id')->nullable()->constrained('trading_contracts')->onDelete('set null');
            
            $table->enum('contract_type', ['futures', 'options', 'perpetual', 'margin']);
            $table->enum('position_type', ['long', 'short']);
            $table->enum('status', ['open', 'closed', 'liquidated'])->default('open');
            
            $table->decimal('entry_price', 20, 8);
            $table->decimal('current_price', 20, 8);
            $table->decimal('quantity', 20, 8);
            $table->integer('leverage');
            $table->decimal('margin_required', 20, 8);
            $table->decimal('margin_used', 20, 8);
            $table->decimal('unrealized_pnl', 20, 8)->default(0);
            $table->decimal('realized_pnl', 20, 8)->default(0);
            
            $table->decimal('stop_loss', 20, 8)->nullable();
            $table->decimal('take_profit', 20, 8)->nullable();
            $table->decimal('liquidation_price', 20, 8);
            $table->decimal('maintenance_margin', 20, 8);
            
            $table->decimal('funding_rate', 10, 8)->default(0);
            $table->decimal('mark_price', 20, 8)->nullable();
            $table->decimal('index_price', 20, 8)->nullable();
            
            $table->timestamp('entry_time');
            $table->timestamp('exit_time')->nullable();
            $table->timestamp('funding_time')->nullable();
            
            $table->boolean('auto_renew')->default(false);
            $table->text('notes')->nullable();
            $table->json('tags')->nullable();
            
            $table->timestamps();
            
            $table->index(['user_id', 'status']);
            $table->index(['symbol_id', 'status']);
            $table->index(['contract_type', 'status']);
            $table->index(['position_type', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trading_contracts');
    }
};
