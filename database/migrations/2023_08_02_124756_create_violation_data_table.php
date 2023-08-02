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
        Schema::create('violation_data', function (Blueprint $table) {
            $table->id();
            $table->string('student_id', 20)->require();
            $table->unsignedBigInteger('violation_id')->require();
            $table->unsignedBigInteger('generation_id')->require();
            $table->unsignedBigInteger('grade_id')->require();
            $table->date('date');
            $table->string('proof', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('violation_data');
    }
};
