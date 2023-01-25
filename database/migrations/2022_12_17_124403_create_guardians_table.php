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
        Schema::create('guardians', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone');
            $table->string('relationship');
            $table->text('residential_address')->nullable();
            $table->string('religion')->nullable();
            $table->string('nationality')->nullable();
            $table->string('state')->nullable();
            $table->string('lga')->nullable();
            $table->string('occupation')->nullable();
            $table->text('business_address')->nullable();
            $table->text('family_history')->nullable();
            $table->string('id_card')->nullable();
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
        Schema::dropIfExists('guardians');
    }
};
