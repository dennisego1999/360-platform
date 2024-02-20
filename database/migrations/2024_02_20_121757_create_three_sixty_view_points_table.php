<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('three_sixty_view_points', static function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->boolean('is_default')->default(false);
            $table->foreignId('three_sixty_area_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('three_sixty_view_points');
    }
};
