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
        Schema::table('posts', function (Blueprint $table) {
            $table->string('excerpt')->nullable()->after('content');
            $table->string('featured_image')->nullable()->after('image');
            $table->json('tags')->nullable()->after('status');
            $table->string('author')->default('Admin')->after('tags');
            $table->integer('views')->default(0)->after('author');
            $table->boolean('is_featured')->default(false)->after('views');
            $table->timestamp('published_at')->nullable()->after('is_featured');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn([
                'excerpt',
                'featured_image', 
                'tags',
                'author',
                'views',
                'is_featured',
                'published_at'
            ]);
        });
    }
};
