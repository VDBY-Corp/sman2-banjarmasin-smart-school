<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
            $table->unsignedBigInteger('student_id')->nullable();
            $table->unsignedBigInteger('achievement_id')->nullable();
            $table->unsignedBigInteger('generation_id')->nullable();
            $table->unsignedBigInteger('grade_id')->nullable();
            $table->dateTime('date', $precision = 0)->default(DB::raw('CURRENT_TIMESTAMP'));

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
        Schema::dropIfExists('achievement_data');
    }
};
