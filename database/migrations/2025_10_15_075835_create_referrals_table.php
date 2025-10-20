<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// database/migrations/2024_01_01_000010_create_referrals_table.php
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('referrer_client_id')->constrained('clients')->cascadeOnDelete();
            $table->foreignId('referred_client_id')->constrained('clients')->cascadeOnDelete();
            $table->foreignId('project_id')->nullable()->constrained()->nullOnDelete(); // project that triggered reward
            
            $table->enum('status', ['pending', 'converted', 'rewarded'])->default('pending');
            $table->decimal('reward_amount', 10, 2)->nullable();
            $table->enum('reward_type', ['discount', 'cash', 'credit'])->nullable();
            $table->timestamp('rewarded_at')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('referrals');
    }
};