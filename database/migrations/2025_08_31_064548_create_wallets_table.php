<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('symbol_id')->constrained()->onDelete('cascade');
            $table->decimal('balance', 20, 8)->default(0); // Số lượng coin hiện có
            $table->decimal('frozen_balance', 20, 8)->default(0); // Số lượng coin đang trong lệnh
            $table->decimal('total_bought', 20, 8)->default(0); // Tổng số lượng đã mua
            $table->decimal('total_sold', 20, 8)->default(0); // Tổng số lượng đã bán
            $table->decimal('average_buy_price', 20, 8)->default(0); // Giá mua trung bình
            $table->timestamps();
            
            // Đảm bảo mỗi user chỉ có 1 wallet cho mỗi symbol
            $table->unique(['user_id', 'symbol_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('wallets');
    }
};
