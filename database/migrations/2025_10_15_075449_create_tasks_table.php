<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// database/migrations/2024_01_01_000003_create_tasks_table.php
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            
            $table->string('title');
            $table->text('description')->nullable();
            
            $table->enum('status', [
                'pending',
                'in_progress',
                'completed',
                'blocked'
            ])->default('pending');
            
            $table->date('due_date')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->integer('estimated_minutes')->nullable();
            $table->integer('actual_minutes')->default(0);
            
            $table->integer('order')->default(0);
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};