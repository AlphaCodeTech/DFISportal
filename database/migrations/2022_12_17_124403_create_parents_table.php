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
        Schema::create('parents', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->text('residential_address');
            $table->string('religion');
            $table->string('nationality');
            $table->string('state');
            $table->string('lga');
            $table->string('occupation');
            $table->text('business_address');
            $table->string('password');
            $table->string('phone');
            $table->string('relationship');
            $table->text('family_history')->nullable();
            $table->string('id_card')->nullable();
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
        Schema::dropIfExists('parents');
    }
};
