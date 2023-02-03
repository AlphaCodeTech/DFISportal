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
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students');
            $table->foreignId('current_class')->constrained('classes');
            $table->foreignId('current_section')->constrained('class_sections');
            $table->foreignId('next_class')->constrained('classes');
            $table->foreignId('next_section')->constrained('class_sections');
            $table->boolean('graduated')->default(0);
            $table->string('current_session');
            $table->string('next_session');
            $table->string('status');
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
        Schema::dropIfExists('promotions');
    }
};
