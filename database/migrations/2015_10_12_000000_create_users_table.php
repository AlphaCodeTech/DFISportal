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
            $table->string('name');
            $table->string('lastname');
            $table->string('middlename');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('idNo')->unique();
            $table->string('gender');
            $table->string('dob');
            $table->string('photo');
            $table->string('phone');
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->foreignId('level_id')->constrained('levels')->cascadeOnDelete();;
            $table->string('religion');
            $table->string('marital_status');
            $table->string('blood_group');
            $table->string('nationality');
            $table->string('qualification');
            $table->string('address');
            $table->string('bank');
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
