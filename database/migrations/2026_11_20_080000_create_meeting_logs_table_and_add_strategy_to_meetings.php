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
        // 1. Add latest_ai_strategy and latest_ai_strategy_at to meetings table
        Schema::table('meetings', function (Blueprint $table) {
            $table->longText('latest_ai_strategy')->nullable()->after('commitment_result');
            $table->timestamp('latest_ai_strategy_at')->nullable()->after('latest_ai_strategy');
        });

        // 2. Create meeting_logs table for tracking all processes & negotiation touchpoints
        Schema::create('meeting_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meeting_id')->constrained('meetings')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('channel', 50)->default('note'); // whatsapp, call, meeting, email, note
            $table->string('sentiment', 50)->default('neutral'); // positive, neutral, objection, negotiation
            $table->text('content');
            $table->dateTime('logged_at');
            $table->timestamps();

            $table->index(['meeting_id', 'logged_at']);
            $table->index(['user_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meeting_logs');

        Schema::table('meetings', function (Blueprint $table) {
            $table->dropColumn(['latest_ai_strategy', 'latest_ai_strategy_at']);
        });
    }
};
