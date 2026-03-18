<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->string('target_type')->default('supervisor')->after('priority'); // supervisor, dean, instructor, admission
            $table->foreignId('course_id')->nullable()->after('target_type')->constrained('courses')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign(['course_id']);
            $table->dropColumn(['target_type', 'course_id']);
        });
    }
};
