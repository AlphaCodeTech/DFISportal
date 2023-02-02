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
            $table->foreignId('from_class')->constrained('classes');
            $table->foreignId('from_section')->constrained('class_sections');
            $table->foreignId('to_class')->constrained('classes');
            $table->foreignId('to_section')->constrained('class_sections');
            $table->boolean('graduated')->default(0);
            $table->string('from_session');
            $table->string('to_session');
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
