<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('viewpoints', static function (Blueprint $table) {
            $table->json('initial_view')->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('viewpoints', static function (Blueprint $table) {
            $table->dropColumn('initial_view');
        });
    }
};
