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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('role_or_company')->nullable();
            $table->string('phone_or_contact')->nullable();
            $table->string('category')->default('client');
            $table->text('primary_need')->nullable();
            $table->text('ego_trigger')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            // Indexing for faster searching per user
            $table->index(['user_id', 'category']);
            $table->index(['user_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
