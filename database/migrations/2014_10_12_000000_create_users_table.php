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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('surname');
            $table->string('lastname');
            $table->string('middlename');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('admno');
            $table->string('gender');
            $table->string('dob');
            $table->string('photo');
            $table->string('phone');
            $table->string('category');
            $table->string('department');
            $table->string('position');
            $table->string('religion');
            $table->string('marital_status');
            $table->string('blood_group');
            $table->string('nationality');
            $table->string('qualification');
            $table->string('address');
            $table->string('bank');
            // $table->foreignId('role_id')->constrained('roles')->cascadeOnDelete();
            $table->string('account_name');
            $table->string('account_number');
            $table->boolean('status')->default(true);
            $table->timestamp('email_verified_at')->nullable();
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
        Schema::dropIfExists('users');
    }
};
