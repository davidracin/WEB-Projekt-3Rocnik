<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    /**
     *  Nad-dimenzované migrace pro databázi knihovny
     *  PS1: vše dělané v rámci jednoho souboru, pokud by nastal problém s migrací, tak je možné je rozdělit do více souborů
     *  PS2: všechny migrace jsou dělané v rámci poskytnutých datových struktur z databáze
     */

    public function up(): void
    {
        Schema::create('authors', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->text('bio');
            $table->string('profile_image', 255);
            $table->timestamps(); // Keep timestamps for tracking
        });
        
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->text('description');
            $table->string('cover_image', 255);
            $table->integer('published_year');
            $table->integer('pages');
            $table->string('ISBN', 13);
            $table->unsignedBigInteger('publisher_id');
            $table->unsignedBigInteger('publisher_cities_id');
            $table->timestamps(); // Keep timestamps for tracking
        });
        
        Schema::create('book_has_authors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('books_id');
            $table->unsignedBigInteger('authors_id');
            // No timestamps needed for pivot table
        });
        
        Schema::create('book_has_genres', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('books_id');
            $table->unsignedBigInteger('genres_id');
            // No timestamps needed for pivot table
        });
        
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->timestamps(); // Keep timestamps for tracking
        });
        
        Schema::create('genres', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->timestamps(); // Keep timestamps for tracking
        });
        
        Schema::create('publishers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->timestamps(); // Keep timestamps for tracking
        });
        
        Schema::create('publisher_cities', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->unsignedBigInteger('countries_id');
            $table->timestamps(); // Keep timestamps for tracking
        });
        
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->integer('rating');
            $table->text('comment');
            $table->unsignedBigInteger('users_id');
            $table->unsignedBigInteger('books_id');
            $table->timestamps(); // Keep timestamps for tracking
        });
        
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username', 255);
            $table->string('password', 255);
            $table->string('email', 255);
            $table->string('profile_image', 255);
            $table->rememberToken(); // Necessary for authentication
            $table->timestamps(); // Keep timestamps for tracking
        });

            

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('genre');
    }
};
