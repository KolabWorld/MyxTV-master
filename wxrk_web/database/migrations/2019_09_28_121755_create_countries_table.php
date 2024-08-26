<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries',function(Blueprint $table){
            $table->bigIncrements('id');
            $table->string('name',199)->nullable();
            $table->string('code',199)->nullable();
            $table->string('dial_code',199)->nullable();
            $table->enum('status', ['active','inactive','pending']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::dropIfExists('countries');
    }
}
