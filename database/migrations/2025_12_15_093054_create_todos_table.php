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
        // Ensure the todos table has the expected columns. Some environments
        // may have a duplicate migration; only create the table if it
        // doesn't exist to avoid "table already exists" errors.
        if (! Schema::hasTable('todos')) {
            Schema::create('todos', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->text('description')->nullable();
                $table->string('image')->nullable();
                $table->enum('status', ['pending', 'completed'])->default('pending');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('todos');
    }
};
