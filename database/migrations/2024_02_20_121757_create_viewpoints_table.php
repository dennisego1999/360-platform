<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('viewpoints', static function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->json('description');
            $table->boolean('is_default')->default(false);
            $table->foreignId('area_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('viewpoints');
    }
};
