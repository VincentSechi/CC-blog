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
        Schema::create('articles', function (Blueprint $table) {
            $table  ->id();
            $table  ->string('slug')->unique();
            $table  ->string('title');
            $table  ->string('author');
            $table  ->unsignedBigInteger('category_id')->nullable();
            $table  ->foreign('category_id')
                    ->references('id')
                    ->on('categories')
                    ->onDelete('set null')
                    ->onUpdate('cascade');
            $table  ->string('content');
            $table  ->string('photo')->nullable();
            $table  ->string('excerpt');
            $table  ->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
