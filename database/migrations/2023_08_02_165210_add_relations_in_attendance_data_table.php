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
        Schema::table('attendance_data', function (Blueprint $table) {
            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('grade_id')->references('id')->on('grades');
            $table->foreign('generation_id')->references('id')->on('generations');
            $table->foreign('teacher_id')->references('id')->on('teachers');
            $table->foreign('attendance_id')->references('id')->on('attendances');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendance_data', function (Blueprint $table) {
            $table->dropForeign('attendance_data_student_id_foreign');
            $table->dropForeign('attendance_data_grade_id_foreign');
            $table->dropForeign('attendance_data_generation_id_foreign');
            $table->dropForeign('attendance_data_teacher_id_foreign');
            $table->dropForeign('attendance_data_attendance_id_foreign');
        });
    }
};
