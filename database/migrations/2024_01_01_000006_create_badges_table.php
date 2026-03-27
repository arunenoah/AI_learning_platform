<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('badges', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('slug')->unique();
            $table->string('icon');
            $table->string('type');
            $table->integer('requirement_value')->default(1);
            $table->string('requirement_type')->default('count');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('badges');
    }
};
