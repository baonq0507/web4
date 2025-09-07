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
        Schema::create('trading_strategies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('strategy_type', ['manual', 'automated', 'copy_trading', 'grid', 'dca']);
            $table->enum('status', ['active', 'paused', 'stopped'])->default('active');
            $table->enum('risk_level', ['low', 'medium', 'high'])->default('medium');
            
            $table->decimal('max_position_size', 20, 8)->nullable();
            $table->decimal('max_daily_loss', 20, 8)->nullable();
            $table->decimal('max_total_loss', 20, 8)->nullable();
            $table->decimal('take_profit_percentage', 8, 2)->nullable();
            $table->decimal('stop_loss_percentage', 8, 2)->nullable();
            
            $table->json('entry_rules')->nullable();
            $table->json('exit_rules')->nullable();
            $table->json('parameters')->nullable();
            $table->json('performance_metrics')->nullable();
            
            $table->timestamps();
            
            $table->index(['user_id', 'status']);
            $table->index(['strategy_type', 'status']);
            $table->index(['risk_level']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trading_strategies');
    }
};
