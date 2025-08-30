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
        Schema::create('ky_quies', function (Blueprint $table) {
            $table->id();
            $table->string('name_de')->nullable();
            $table->string('name_en')->nullable();
            $table->string('name_id')->nullable();
            $table->string('name_ja')->nullable();
            $table->string('name_ko')->nullable();
            $table->string('name_th')->nullable();
            $table->string('name_vi')->nullable();
            $table->string('name_zh')->nullable();
            $table->string('sort_description_de')->nullable();
            $table->string('sort_description_en')->nullable();
            $table->string('sort_description_id')->nullable();
            $table->string('sort_description_ja')->nullable();
            $table->string('sort_description_ko')->nullable();
            $table->string('sort_description_th')->nullable();
            $table->string('sort_description_vi')->nullable();
            $table->string('sort_description_zh')->nullable();
            $table->string('description_de')->nullable();
            $table->string('description_en')->nullable();
            $table->string('description_id')->nullable();
            $table->string('description_ja')->nullable();
            $table->string('description_ko')->nullable();
            $table->string('description_th')->nullable();
            $table->string('description_vi')->nullable();
            $table->string('description_zh')->nullable();
            $table->enum('loai', ['co_dinh', 'linh_hoat'])->default('co_dinh');
            $table->enum('show', ['show', 'hide'])->default('show')->nullable();
            $table->enum('unit', ['d', 'm', 'y'])->default('d')->nullable();
            $table->integer('profit')->default(0)->nullable();
            $table->integer('value')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ky_quies');
    }
};
