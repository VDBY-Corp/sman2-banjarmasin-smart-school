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
            $table->id();
            $table->string('nisn', 20)->unique();
            $table->unsignedBigInteger('grade_id')->nullable();
            $table->unsignedBigInteger('generation_id')->nullable();
            $table->string('name', 50);
            $table->enum('gender', ['laki-laki', 'perempuan']);
            $table->string('place_birth', 20);
            $table->date('date_birth');
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
