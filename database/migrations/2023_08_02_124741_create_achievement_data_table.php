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
        Schema::create('achievement_data', function (Blueprint $table) {
            $table->id();
            $table->string('student_id', 20)->require();
            $table->integer('achievement_id')->require();
            $table->integer('generation_id')->require();
            $table->integer('grade_id')->require();
            $table->date('date');
            $table->string('proof', 100);
            $table->timestamps();

            $table->foreign('student_id')->references('nisn')->on('students');
            $table->foreign('achievement_id')->references('id')->on('achievements');
            $table->foreign('generation_id')->references('id')->on('generations');
            $table->foreign('grade_id')->references('id')->on('grades');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('achievement_data');
    }
};
