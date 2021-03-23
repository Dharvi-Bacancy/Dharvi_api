<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Accounttype extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounttype', function (Blueprint $table) {
            $table->id();
            $table->Biginteger('register_model_id')->unsigned();
            $table->string('account_type');
            $table->string('date');
            $table->timestamps();
        });
        Schema::table('accounttype', function (Blueprint $table) {
            
            $table->foreign('register_model_id')->references('id')->on('register');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
