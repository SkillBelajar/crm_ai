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
        Schema::table('meetings', function (Blueprint $table) {
            $table->index(['user_id', 'created_at'], 'meetings_user_created_idx');
            $table->index(['user_id', 'contract_deadline_at'], 'meetings_user_deadline_idx');
            $table->index(['user_id', 'meeting_date'], 'meetings_user_meeting_date_idx');
        });

        Schema::table('contacts', function (Blueprint $table) {
            $table->index(['user_id', 'created_at'], 'contacts_user_created_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('meetings', function (Blueprint $table) {
            $table->dropIndex('meetings_user_created_idx');
            $table->dropIndex('meetings_user_deadline_idx');
            $table->dropIndex('meetings_user_meeting_date_idx');
        });

        Schema::table('contacts', function (Blueprint $table) {
            $table->dropIndex('contacts_user_created_idx');
        });
    }
};
