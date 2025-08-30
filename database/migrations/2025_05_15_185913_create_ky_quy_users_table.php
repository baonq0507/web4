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
        Schema::create('ky_quy_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('ky_quy_id')->constrained('ky_quies');
            $table->integer('value')->default(0);
            $table->integer('balance')->default(0);
            $table->bigInteger('before_balance')->default(0);
            $table->bigInteger('after_balance')->default(0);
            $table->enum('status', ['pending', 'approve', 'cancel', 'stop', 'failed', 'finish'])->default('pending');
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->dateTime('approve_date')->nullable();
            $table->dateTime('cancel_date')->nullable();
            $table->dateTime('stop_date')->nullable();
            $table->dateTime('failed_date')->nullable();
            $table->dateTime('finish_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ky_quy_users');
    }
};
