<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('spot_trades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('symbol_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['buy', 'sell']);
            $table->decimal('amount', 20, 8);
            $table->decimal('price', 20, 8);
            $table->decimal('total_value', 20, 8);
            $table->enum('status', ['pending', 'completed', 'cancelled'])->default('pending');
            $table->enum('order_type', ['market', 'limit'])->default('market');
            $table->decimal('limit_price', 20, 8)->nullable();
            $table->decimal('filled_amount', 20, 8)->default(0);
            $table->decimal('remaining_amount', 20, 8);
            $table->decimal('commission', 20, 8)->default(0);
            $table->timestamp('trade_at');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('spot_trades');
    }
};
