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
        Schema::table('bookings', function (Blueprint $table) {
            // Columns are now defined in create_bookings_table migration
            // This migration is kept for backwards compatibility with existing environments
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (Schema::hasColumn('bookings', 'gym_id')) {
                $table->dropConstrainedForeignId('gym_id');
            }

            if (Schema::hasColumn('bookings', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
