<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quiz_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users');
            $table->foreignId('quiz_id')->constrained('quizzes');
            $table->integer('score');
            $table->text('student_answer')->nullable();
            $table->string('student_answer_image')->nullable();
            $table->timestamps();
        });     
    }
    public function down(): void
    {
        Schema::dropIfExists('quiz_results');
    }
};
