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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('surname');
            $table->string('lastname');
            $table->string('middlename');
            $table->string('admno');
            $table->string('gender');
            $table->string('blood_group');
            $table->string('genotype');
            $table->string('allergies');
            $table->string('disabilities');
            $table->string('prevSchool');
            $table->string('reason');
            $table->string('introducer');
            $table->string('driver');
            $table->string('dob');
            $table->string('admission_date');
            $table->foreignId('parent_id')->nullable()->constrained('parents')->cascadeOnDelete();
            $table->foreignId('class_id')->constrained('classes')->cascadeOnDelete();
            $table->string('photo');
            $table->string('birth_certificate');
            $table->string('immunization_card');
            $table->string('address'); 
            $table->boolean('status')->default(true); 
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
        Schema::dropIfExists('students');
    }
};
