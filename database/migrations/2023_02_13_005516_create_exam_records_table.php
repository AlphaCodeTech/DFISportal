<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->references('id')->on('exams');
            $table->foreignId('student_id')->references('id')->on('students');
            $table->foreignId('class_id')->references('id')->on('classes');
            $table->foreignId('section_id')->references('id')->on('class_sections');
            $table->integer('total')->nullable();
            $table->string('average')->nullable();
            $table->string('class_average')->nullable();
            $table->integer('position')->nullable();
            $table->string('af')->nullable();
            $table->string('ps')->nullable();
            $table->string('p_comment')->nullable();
            $table->string('t_comment')->nullable();
            $table->string('year');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exam_records');
    }
};
