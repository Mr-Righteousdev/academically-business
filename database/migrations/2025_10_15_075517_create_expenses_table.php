<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// database/migrations/2024_01_01_000004_create_expenses_table.php
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // who recorded it
            $table->foreignId('project_id')->nullable()->constrained()->nullOnDelete(); // if linked to project
            
            $table->enum('category', [
                'printing',
                'data_bundle',
                'transport',
                'materials',
                'software',
                'marketing',
                'office_supplies',
                'utilities',
                'other'
            ]);
            
            $table->decimal('amount', 10, 2);
            $table->text('description');
            $table->date('expense_date');
            $table->string('receipt_path')->nullable(); // store receipt image
            
            $table->timestamps();
            
            $table->index(['category', 'expense_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};