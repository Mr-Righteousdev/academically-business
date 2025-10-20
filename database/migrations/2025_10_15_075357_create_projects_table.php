<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// database/migrations/2024_01_01_000002_create_projects_table.php
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('project_number')->unique(); // e.g., "AA-2024-001"
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            
            $table->enum('service_type', [
                'coursework',
                'research_paper',
                'final_year_project',
                'programming',
                'data_analysis',
                'presentation',
                'thesis',
                'other'
            ]);
            
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('requirements')->nullable();
            
            $table->decimal('quoted_price', 10, 2)->nullable();
            $table->decimal('agreed_price', 10, 2)->nullable();
            $table->decimal('deposit_paid', 10, 2)->default(0);
            $table->decimal('total_paid', 10, 2)->default(0);
            $table->decimal('balance', 10, 2)->default(0);
            
            $table->enum('payment_status', [
                'not_paid',
                'deposit_paid',
                'partially_paid',
                'fully_paid'
            ])->default('not_paid');
            
            $table->enum('status', [
                'inquiry',
                'quoted',
                'accepted',
                'in_progress',
                'review',
                'revision',
                'completed',
                'delivered',
                'cancelled'
            ])->default('inquiry');
            
            $table->date('deadline')->nullable();
            $table->date('started_at')->nullable();
            $table->date('completed_at')->nullable();
            $table->date('delivered_at')->nullable();
            
            $table->integer('estimated_hours')->nullable();
            $table->integer('actual_hours')->default(0);
            
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->integer('revision_count')->default(0);
            $table->integer('client_satisfaction')->nullable(); // 1-5 rating
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('project_number');
            $table->index(['status', 'deadline']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};