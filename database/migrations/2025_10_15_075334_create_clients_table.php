<?php

// database/migrations/2024_01_01_000001_create_clients_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone');
            $table->string('whatsapp')->nullable();
            $table->string('program')->nullable(); // e.g., "Computer Science"
            $table->string('year_of_study')->nullable(); // e.g., "Year 3"
            $table->enum('source', [
                'flyer',
                'business_card',
                'whatsapp_group',
                'facebook',
                'referral',
                'website',
                'walk_in',
                'other'
            ])->default('other');
            $table->string('referral_source')->nullable(); // who referred them
            $table->enum('status', [
                'inquiry',
                'negotiating',
                'active',
                'completed',
                'inactive'
            ])->default('inquiry');
            $table->text('notes')->nullable();
            $table->decimal('lifetime_value', 10, 2)->default(0);
            $table->integer('projects_count')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};