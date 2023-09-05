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
            $table->string('student_id', 20)->require();
            $table->unsignedBigInteger('achievement_id')->require();
            $table->unsignedBigInteger('generation_id')->require();
            $table->unsignedBigInteger('grade_id')->require();
            $table->dateTime('date', $precision = 0)->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->unsignedBigInteger('file_id')->require();
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
