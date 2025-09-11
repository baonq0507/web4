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
            $table->string('name'); // V1, V2, V3
            $table->string('display_name'); // Member, Premium, VIP
            $table->decimal('min_deposit', 15, 2)->default(0); // Minimum deposit required
            $table->decimal('max_deposit', 15, 2)->nullable(); // Maximum deposit for this level
            $table->text('benefits')->nullable(); // JSON string of benefits
            $table->string('color', 7)->default('#FFD700'); // Color for display
            $table->string('icon')->nullable(); // Icon class or image
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
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