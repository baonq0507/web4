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
        Schema::create('session_games', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->foreignId('symbol_id')->constrained('symbols');
            $table->enum('type', ['buy', 'sell'])->nullable();
            $table->string('open_price')->nullable();
            $table->string('change_price')->nullable();
            $table->string('close_price')->nullable();
            $table->string('high_price')->nullable();
            $table->string('low_price')->nullable();
            $table->string('volume_price')->nullable();
            $table->bigInteger('force_close')->nullable();
            $table->string('result')->nullable();
            $table->dateTime('time_start')->nullable();
            $table->dateTime('time_end')->nullable();
            $table->dateTime('reward_time')->nullable();
            $table->integer('profit_sell')->nullable();
            $table->integer('profit_buy')->nullable();
            $table->enum('status_trade', ['pending', 'trade', 'result'])->default('pending');
            $table->enum('status', ['pending', 'success', 'failed'])->default('pending');
            $table->tinyInteger('is_log')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_games');
    }
};
