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
        Schema::table('schedules', function (Blueprint $table) {
            // Add post_id column
            $table->foreignId('post_id')
                  ->nullable()
                  ->after('topic_id')
                  ->constrained()
                  ->onDelete('set null');
        });
        
        // Modify existing status enum to add new values
        DB::statement("ALTER TABLE schedules MODIFY COLUMN status ENUM('available', 'pending', 'confirmed', 'cancelled', 'completed', 'upcoming') DEFAULT 'available'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->dropForeign(['post_id']);
            $table->dropColumn('post_id');
        });
        
        // Revert status enum to original
        DB::statement("ALTER TABLE schedules MODIFY COLUMN status ENUM('upcoming', 'completed', 'cancelled') DEFAULT 'upcoming'");
    }
};
