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
        Schema::create('generation_grade_teachers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('generation_id')->require();
            $table->unsignedBigInteger('grade_id')->require();
            $table->unsignedBigInteger('teacher_id')->require();
            
            $table->foreign('grade_id')->references('id')->on('grades');
            $table->foreign('generation_id')->references('id')->on('generations');
            $table->foreign('teacher_id')->references('id')->on('teachers');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('generation_grade_teachers');
    }
};
