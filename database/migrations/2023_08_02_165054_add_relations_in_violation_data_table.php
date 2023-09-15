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
        Schema::table('violation_data', function (Blueprint $table) {
            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('violation_id')->references('id')->on('violations');
            $table->foreign('generation_id')->references('id')->on('generations');
            $table->foreign('teacher_id')->references('id')->on('teachers');
            $table->foreign('grade_id')->references('id')->on('grades');
            $table->foreign('proof_file_id')->references('id')->on('files')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('violation_data', function (Blueprint $table) {
            $table->dropForeign('violation_data_student_id_foreign');
            $table->dropForeign('violation_data_violation_id_foreign');
            $table->dropForeign('violation_data_generation_id_foreign');
            $table->dropForeign('violation_data_teacher_id_foreign');
            $table->dropForeign('violation_data_grade_id_foreign');
            $table->dropForeign('violation_data_proof_file_id_foreign');
        });
    }
};
