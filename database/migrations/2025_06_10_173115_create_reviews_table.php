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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->integer('rating')->unsigned();
            $table->text('review_text');
            $table->unsignedBigInteger('books_id');
            $table->unsignedBigInteger('users_id');
            $table->timestamps();

            // Add foreign key constraints
            $table->foreign('books_id')->references('id')->on('books')->onDelete('cascade');
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
            
            // Ensure user can only review a book once
            $table->unique(['books_id', 'users_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
