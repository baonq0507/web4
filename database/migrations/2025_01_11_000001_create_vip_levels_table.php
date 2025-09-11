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
        Schema::create('vip_levels', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // VIP 0, VIP 1, VIP 2, etc.
            $table->integer('level'); // 0, 1, 2, 3, 4, 5
            $table->decimal('required_deposit', 15, 2)->default(0); // Số tiền nạp tối thiểu
            $table->text('benefits')->nullable(); // Lợi ích dạng JSON
            $table->string('icon')->nullable(); // Icon cho VIP level
            $table->string('color')->default('#ffffff'); // Màu sắc đại diện
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vip_levels');
    }
};