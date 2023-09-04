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
        Schema::table('achievement_data', function (Blueprint $table) {
            $table->foreign('student_id')->references('nisn')->on('students');
            $table->foreign('achievement_id')->references('id')->on('achievements');
            $table->foreign('generation_id')->references('id')->on('generations');
            $table->foreign('grade_id')->references('id')->on('grades');
            $table->foreign('file_id')->references('id')->on('files');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('achievement_data', function (Blueprint $table) {
            $table->dropForeign('achievement_data_student_id_foreign');
            $table->dropForeign('achievement_data_achievement_id_foreign');
            $table->dropForeign('achievement_data_generation_id_foreign');
            $table->dropForeign('achievement_data_grade_id_foreign');
            $table->dropForeign('achievement_data_file_id_foreign');
        });
    }
};
