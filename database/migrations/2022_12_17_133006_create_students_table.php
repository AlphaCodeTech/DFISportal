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
            $table->string('blood_group')->nullable();
            $table->string('genotype')->nullable();
            $table->string('allergies')->nullable();
            $table->string('disabilities')->nullable();
            $table->string('prevSchool')->nullable();
            $table->string('reason')->nullable();
            $table->string('introducer')->nullable();
            $table->string('driver')->nullable();
            $table->string('dob');
            $table->string('admission_date');
            $table->foreignId('parent_id')->nullable()->constrained('parents')->cascadeOnDelete();
            $table->foreignId('class_id')->constrained('classes')->cascadeOnDelete();
            $table->string('photo');
            $table->string('birth_certificate')->nullable();
            $table->string('immunization_card')->nullable();
            $table->boolean('status')->default(true); 
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
        Schema::dropIfExists('students');
    }
};
