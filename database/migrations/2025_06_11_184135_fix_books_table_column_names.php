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
        Schema::table('books', function (Blueprint $table) {
            // Rename publisher_id to publishers_id to match the model
            $table->renameColumn('publisher_id', 'publishers_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            // Rename back publishers_id to publisher_id
            $table->renameColumn('publishers_id', 'publisher_id');
        });
    }
};
