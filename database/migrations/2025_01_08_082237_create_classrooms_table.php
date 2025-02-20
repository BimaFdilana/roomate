<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('classrooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('banner_class_image');
            $table->string('class_image');
            $table->text('description');
            $table->foreignId('teacher_id')->constrained('users');
            $table->string('class_code')->unique();
            $table->timestamps();
        });  
    }
    public function down(): void
    {
        Schema::dropIfExists('classrooms');
    }
};
