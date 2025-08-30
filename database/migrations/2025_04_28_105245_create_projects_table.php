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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description_de')->nullable();
            $table->string('description_en')->nullable();
            $table->string('description_id')->nullable();
            $table->string('description_ja')->nullable();
            $table->string('description_ko')->nullable();
            $table->string('description_th')->nullable();
            $table->string('description_vi')->nullable();
            $table->string('description_zh')->nullable();
            $table->integer('min_invest')->nullable();
            $table->integer('max_invest')->nullable();
            $table->integer('progress')->nullable();
            $table->integer('profit')->nullable();
            $table->bigInteger('amount')->nullable();
            $table->bigInteger('total_period')->nullable();
            $table->enum('interval', ['m', 'h', 'd', 'w', 'mo'])->nullable();
            $table->enum('status', ['active', 'inactive', 'stop'])->nullable();
            $table->tinyInteger('payback')->nullable();
            $table->string('image')->nullable();
            $table->string('link')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
