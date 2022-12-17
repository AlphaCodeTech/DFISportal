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
            $table->string('email')->unique();
            $table->string('password');
            $table->string('admno');
            $table->string('gender');
            $table->string('dob');
            $table->foreignId('parent_id')->constrained('parents')->cascadeOnDelete();
            $table->foreignId('class_id')->constrained('classes')->cascadeOnDelete();
            $table->string('photo');
            $table->string('address'); 
            $table->boolean('status')->default(true); 
            $table->rememberToken();
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
