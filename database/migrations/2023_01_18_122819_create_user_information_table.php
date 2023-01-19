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
        Schema::create('user_information', function (Blueprint $table) {
            $table->id();
            $table->string('phone');
            $table->string('gender');
            $table->string('dob');
            $table->string('religion');
            $table->string('marital_status');
            $table->string('blood_group');
            $table->string('nationality');
            $table->string('qualification');
            $table->string('address');
            $table->string('bank');
            $table->string('account_name');
            $table->string('account_number');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
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
        Schema::dropIfExists('user_information');
    }
};
