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
            $table->unsignedBigInteger('attendance_id')->nullable();
            $table->unsignedBigInteger('student_id')->nullable();
            $table->enum('status', ['Hadir', 'Alpa', 'Sakit', 'Izin', 'Rekomendasi', 'Telat', 'Bolos', 'Lainnya'])->default('Hadir')->nullable();
            $table->string('description')->nullable();

            $table->unsignedBigInteger('proof_file_id')->nullable();

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
