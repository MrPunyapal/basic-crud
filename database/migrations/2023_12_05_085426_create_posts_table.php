<?php

use App\Enums\FeaturedStatus;
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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->string('slug', 120)->unique();
            $table->string('description');
            $table->string('image')->nullable();
            $table->text('body');
            $table->boolean('published')->default(false);
            $table->unsignedTinyInteger('category');
            $table->json('tags')->nullable();
            $table->unsignedTinyInteger('is_featured')->default(FeaturedStatus::NOT_FEATURED);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
