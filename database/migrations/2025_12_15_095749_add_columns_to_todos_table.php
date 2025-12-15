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
        Schema::table('todos', function (Blueprint $table) {
            // Add missing columns if they don't already exist. Use checks
            // so this migration is safe to run on databases with partial schema.
            if (! Schema::hasColumn('todos', 'title')) {
                $table->string('title')->after('id');
            }

            if (! Schema::hasColumn('todos', 'description')) {
                $table->text('description')->nullable()->after('title');
            }

            if (! Schema::hasColumn('todos', 'image')) {
                $table->string('image')->nullable()->after('description');
            }

            if (! Schema::hasColumn('todos', 'status')) {
                $table->enum('status', ['pending', 'completed'])->default('pending')->after('image');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('todos', function (Blueprint $table) {
            if (Schema::hasColumn('todos', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('todos', 'image')) {
                $table->dropColumn('image');
            }
            if (Schema::hasColumn('todos', 'description')) {
                $table->dropColumn('description');
            }
            if (Schema::hasColumn('todos', 'title')) {
                $table->dropColumn('title');
            }
        });
    }
};
