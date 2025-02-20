<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_classrooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users');
            $table->foreignId('classroom_id')->constrained('classrooms');
            $table->unique(['student_id', 'classroom_id']);
            $table->timestamps();
        });   
    }
    public function down(): void
    {
        Schema::dropIfExists('student_classrooms');
    }
};
