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
        Schema::create('admission_form_fees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buyer_id')->constrained('guardians');
            $table->string('amount');
            $table->string('current_session');
            $table->string('transaction_ref');
            $table->boolean('used')->default(false);
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
        Schema::dropIfExists('admission_form_fees');
    }
};
