<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('guides', function (Blueprint $table) {
            $table->text('description')->nullable()->after('title');
            $table->string('category')->nullable()->after('description');
            $table->string('type')->nullable()->after('category');
            $table->string('icon')->nullable()->after('type');
        });
    }

    public function down(): void
    {
        Schema::table('guides', function (Blueprint $table) {
            $table->dropColumn(['description', 'category', 'type', 'icon']);
        });
    }
};
