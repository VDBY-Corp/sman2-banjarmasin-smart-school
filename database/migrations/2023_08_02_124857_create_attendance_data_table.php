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
        Schema::create('attendance_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('attendance_id')->require();
            $table->unsignedBigInteger('student_id')->require();
            $table->unsignedBigInteger('grade_id')->require();
            $table->unsignedBigInteger('generation_id')->require();
            $table->unsignedBigInteger('teacher_id')->require();
            $table->string('status', 15);
            $table->date('date');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_data');
    }
};
