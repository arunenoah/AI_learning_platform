<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('path_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('learning_path_id')->constrained()->cascadeOnDelete();
            $table->foreignId('resource_id')->constrained()->cascadeOnDelete();
            $table->integer('order')->default(0);
            $table->string('title')->nullable();
            $table->text('instructions')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('path_steps');
    }
};
