<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// database/migrations/2024_01_01_000006_create_communications_table.php
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('communications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->foreignId('project_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // team member who communicated
            
            $table->enum('type', [
                'call',
                'whatsapp',
                'email',
                'sms',
                'meeting',
                'other'
            ]);
            
            $table->enum('direction', ['inbound', 'outbound']);
            $table->text('summary');
            $table->text('notes')->nullable();
            $table->timestamp('communicated_at');
            
            $table->timestamps();
            
            $table->index(['client_id', 'communicated_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('communications');
    }
};