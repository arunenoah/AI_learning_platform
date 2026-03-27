<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('resource_id')->constrained()->cascadeOnDelete();
            $table->boolean('is_completed')->default(false);
            $table->timestamp('completed_at')->nullable();
            $table->integer('time_spent_minutes')->default(0);
            $table->timestamps();
            
            $table->unique(['user_id', 'resource_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_progress');
    }
};
