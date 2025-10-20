<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// database/migrations/2024_01_01_000005_create_payments_table.php
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->foreignId('recorded_by')->constrained('users')->cascadeOnDelete();
            
            $table->decimal('amount', 10, 2);
            $table->enum('payment_method', [
                'cash',
                'mobile_money',
                'bank_transfer',
                'other'
            ]);
            $table->string('transaction_reference')->nullable();
            $table->enum('payment_type', ['deposit', 'partial', 'full', 'balance']);
            
            $table->date('payment_date');
            $table->text('notes')->nullable();
            
            $table->timestamps();
            
            $table->index(['project_id', 'payment_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};