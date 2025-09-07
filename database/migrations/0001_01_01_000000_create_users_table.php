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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('username')->unique()->nullable();
            $table->string('password');
            $table->enum('role', ['admin', 'user', 'manager', 'super_admin'])->default('user');
            $table->enum('status', ['active', 'inactive', 'band'])->default('active');
            $table->string('avatar')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->float('balance')->default(0);
            $table->float('balance_demo')->default(1000);
            $table->string('referral')->nullable();
            $table->foreignId('referral_parent_id')->nullable()->constrained('users');
            $table->bigInteger('level')->default(0);
            $table->string('wallet_address')->nullable();
            $table->float('balance_usdt')->default(0);
            $table->string('region')->nullable();
            $table->integer('ratio')->default(0);
            $table->string('ip_address')->nullable();
            $table->string('remember_token')->nullable();
            $table->integer('win_rate')->default(50);
            $table->integer('lose_rate')->default(50);
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
