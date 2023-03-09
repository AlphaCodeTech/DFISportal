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
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();
            $table->string('surname');
            $table->string('lastname');
            $table->string('middlename');
            $table->string('gender');
            $table->string('dob');
            $table->string('blood_group');
            $table->string('genotype');
            $table->string('allergies');
            $table->string('disabilities');
            $table->string('prevSchool');
            $table->string('reason');
            $table->string('introducer');
            $table->string('driver');
            $table->foreignId('guardian_id')->constrained('guardians');
            $table->foreignId('class_id')->constrained('classes');
            $table->string('photo');
            $table->string('birth_certificate');
            $table->string('immunization_card');
            $table->boolean('admitted')->default(false); 
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
        Schema::dropIfExists('applicants');
    }
};
