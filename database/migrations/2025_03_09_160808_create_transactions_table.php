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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('code')->unique();
            $table->enum('payment_type', ['bank', 'usdt'])->nullable();
            $table->foreignId('user_id_to')->nullable();
            $table->foreignId('bank_id')->nullable();
            $table->foreignId('symbol_id')->nullable();
            $table->enum('type', ['deposit', 'withdraw', 'transfer', 'bet', 'win', 'fee', 'other', 'deduct', 'add']);
            $table->bigInteger('amount');
            $table->text('note')->nullable();
            $table->bigInteger('before_balance');
            $table->bigInteger('after_balance');
            $table->string('description')->nullable();
            $table->string('bill_image')->nullable();
            $table->enum('status', ['pending', 'success', 'failed', 'canceled'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
