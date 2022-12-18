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
            $table->string('admno')->nullable();
            $table->string('gender')->nullable();
            $table->string('dob')->nullable();
            $table->string('photo')->nullable();
            $table->string('phone')->nullable();
            $table->string('category')->nullable();
            $table->string('department')->nullable();
            $table->string('position')->nullable();
            $table->string('religion')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('nationality')->nullable();
            $table->string('qualification')->nullable();
            $table->string('address')->nullable();
            $table->string('bank')->nullable();
            // $table->foreignId('role_id')->constrained('roles')->cascadeOnDelete();
            $table->string('account_name')->nullable();
            $table->string('account_number')->nullable();
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
