<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contributed_by')->constrained('users')->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->string('purpose')->nullable();
            $table->date('date')->default(now());
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contributions');
    }
};
