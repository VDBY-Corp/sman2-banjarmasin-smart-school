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
        Schema::create('students', function (Blueprint $table) {
            $table->string('nisn', 20)->primary();
            $table->unsignedBigInteger('grade_id')->nullable();
            $table->unsignedBigInteger('generation_id')->nullable();
            $table->string('name', 50);
            $table->string('gender', 15);
            $table->integer('point');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
