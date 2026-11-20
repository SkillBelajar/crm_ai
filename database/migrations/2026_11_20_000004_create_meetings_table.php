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
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('contact_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->timestamp('meeting_date')->useCurrent();

            // Misi 1 (Pancing & Catat - Menit 1-3)
            $table->text('biggest_need');
            $table->text('ego_validation_note')->nullable();
            $table->text('user_goal');
            $table->text('context_notes')->nullable();

            // Misi 2 (Filtrasi Anti-Lilin / Conditional Yes)
            $table->longText('ai_conditional_yes')->nullable();

            // Misi 3 (Kunci Kontrak Psikologis - 24 Jam)
            $table->longText('ai_psychological_contract')->nullable();
            $table->timestamp('contract_deadline_at')->nullable();
            $table->string('status')->default('draft'); // draft, sent, committed, failed
            $table->text('commitment_result')->nullable();

            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index('contact_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meetings');
    }
};
