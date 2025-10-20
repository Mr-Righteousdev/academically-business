<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// database/migrations/2024_01_01_000007_create_leads_table.php
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            
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
            
            $table->enum('status', [
                'new',
                'contacted',
                'qualified',
                'quoted',
                'negotiating',
                'won',
                'lost'
            ])->default('new');
            
            $table->text('inquiry_details')->nullable();
            $table->string('service_interested')->nullable();
            $table->string('lost_reason')->nullable();
            
            $table->foreignId('converted_to_client_id')->nullable()->constrained('clients')->nullOnDelete();
            $table->timestamp('contacted_at')->nullable();
            $table->timestamp('converted_at')->nullable();
            
            $table->timestamps();
            
            $table->index(['status', 'source']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};