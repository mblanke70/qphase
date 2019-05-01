<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSportwahlenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sportwahlen', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nachname');
            $table->string('vorname');
            $table->string('klasse');
            $table->string('sem1');
            $table->string('sem2');
            $table->string('sem3');
            $table->string('sem4');
            $table->string('subA');
            $table->string('subB');            
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
        Schema::dropIfExists('sportwahlen');
    }
}
