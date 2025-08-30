<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_trades', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('symbol_id')->constrained('symbols');
            $table->enum('type', ['buy', 'sell']);
            $table->float('amount');
            $table->foreignId('session_id')->constrained('time_sessions');
            $table->float('profit')->nullable();
            $table->enum('status', ['pending', 'success', 'failed'])->default('pending');
            $table->dateTime('trade_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('trade_end')->nullable();
            $table->string('open_price')->nullable();
            $table->string('close_price')->nullable();
            $table->float('before_balance')->nullable();
            $table->float('after_balance')->nullable();
            $table->enum('result', ['win', 'lose'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_trades');
    }
};
