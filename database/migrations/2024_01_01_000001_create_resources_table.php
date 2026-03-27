<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('learning_reason')->nullable();
            $table->string('category');
            $table->string('type');
            $table->string('url')->nullable();
            $table->text('content')->nullable();
            $table->integer('duration_minutes')->default(10);
            $table->integer('difficulty_level')->default(1);
            $table->string('icon')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resources');
    }
};
