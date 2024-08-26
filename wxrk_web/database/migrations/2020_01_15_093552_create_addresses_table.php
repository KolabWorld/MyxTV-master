<?php

use App\Helpers\ConstantHelper;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Migrations\Migration;


class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('addressable_id')->unsigned();
            $table->string('addressable_type');
            $table->string('name', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->string('mobile', ConstantHelper::MOBILE_MAX_LENGTH)->nullable();
            $table->string('email', ConstantHelper::EMAIL_MAX_LENGTH)->nullable();
            $table->string('gst_number', ConstantHelper::EMAIL_MAX_LENGTH)->nullable();
            $table->string('line_1');
            $table->string('line_2')->nullable();
            $table->string('landmark', ConstantHelper::LANDMARK_MAX_LENGTH)->nullable();
            $table->unsignedBigInteger('city_id')->unsigned()->nullable();
            $table->string('district')->nullable();
            $table->unsignedBigInteger('state_id')->unsigned()->nullable();
            $table->unsignedBigInteger('country_id')->unsigned()->nullable();
            $table->string('postal_code')->nullable();
            $table->string('type', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('state_id')->references('id')->on('states');
            $table->foreign('city_id')->references('id')->on('cities');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
}
