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
            $table->unsignedBigInteger('generation_id')->nullable();
            $table->unsignedBigInteger('grade_id')->nullable();
            $table->unsignedBigInteger('teacher_id')->nullable();
            
            $table->foreign('grade_id')->references('id')->on('grades')->onDelete('set null');
            $table->foreign('generation_id')->references('id')->on('generations')->onDelete('set null');
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('set null');
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
