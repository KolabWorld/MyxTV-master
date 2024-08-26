<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOtpRequestTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        Schema::create('otp_request', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->string('email')->nullable();
            $table->string('mobile',15)->nullable();
            $table->integer('otp')->unsigned();
            $table->string('device_address', 100)->nullable();
            $table->string('response', 599)->nullable();
            $table->timestamp('expired_at')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('otp_request', function(Blueprint $table){
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('otp_request');
    }
}
