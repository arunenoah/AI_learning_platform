<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('learning_quests', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('type'); // play, read, write
            $table->foreignId('resource_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('quiz_id')->nullable()->constrained()->onDelete('set null');
            $table->integer('xp_reward')->default(25);
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('user_quest_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('learning_quest_id')->constrained()->onDelete('cascade');
            $table->boolean('is_completed')->default(false);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            $table->unique(['user_id', 'learning_quest_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_quest_progress');
        Schema::dropIfExists('learning_quests');
    }
};
