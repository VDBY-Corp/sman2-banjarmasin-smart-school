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
        Schema::table('attendances', function (Blueprint $table) {
            $table->foreign('grade_id')->references('id')->on('grades')->onDelete('set null');
            $table->foreign('generation_id')->references('id')->on('generations')->onDelete('set null');
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropForeign('attendances_grade_id_foreign');
            $table->dropForeign('attendances_generation_id_foreign');
            $table->dropForeign('attendances_teacher_id_foreign');
        });
    }
};
