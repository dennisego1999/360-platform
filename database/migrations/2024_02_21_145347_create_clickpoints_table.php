<?php

use App\Enums\ContentTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clickpoints', static function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->json('coordinates');
            $table->json('content');
            $table->enum('content_type', ContentTypeEnum::toValues());
            $table->foreignId('viewpoint_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clickpoints');
    }
};
