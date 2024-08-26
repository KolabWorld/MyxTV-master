<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('states',function(Blueprint $table){
            $table->bigIncrements('id');
            $table->string('name',199)->nullable();
            $table->bigInteger('country_id')->unsigned();
            $table->enum('status', ['active','inactive','pending']);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('country_id')->references('id')->on('countries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('states', function(Blueprint $table){
            $table->dropForeign(['country_id']);
        });
        
        Schema::dropIfExists('states');
    }
}
