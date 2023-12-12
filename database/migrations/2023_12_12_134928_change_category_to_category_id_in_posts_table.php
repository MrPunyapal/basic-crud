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
            $table->renameColumn('category', 'category_id');
        });
        Schema::table('posts', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->change();
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->renameColumn('category_id', 'category');
        });
        Schema::table('posts', function (Blueprint $table) {
            $table->unsignedTinyInteger('category')->change();
            $table->dropForeign(['category_id']);
        });
    }
};
