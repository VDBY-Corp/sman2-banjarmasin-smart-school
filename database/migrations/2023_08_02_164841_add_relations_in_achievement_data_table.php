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
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('achievement_id')->references('id')->on('achievements')->onDelete('cascade');
            $table->foreign('generation_id')->references('id')->on('generations')->onDelete('cascade');
            $table->foreign('grade_id')->references('id')->on('grades')->onDelete('cascade');
            $table->foreign('proof_file_id')->references('id')->on('files')->onDelete('set null');
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
            $table->dropForeign('achievement_data_proof_file_id_foreign');
        });
    }
};
