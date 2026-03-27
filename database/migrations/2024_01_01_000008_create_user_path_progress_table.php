<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_path_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('learning_path_id')->constrained()->cascadeOnDelete();
            $table->boolean('is_started')->default(false);
            $table->boolean('is_completed')->default(false);
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->integer('current_step')->default(0);
            $table->timestamps();
            
            $table->unique(['user_id', 'learning_path_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_path_progress');
    }
};
