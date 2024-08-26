<?php

use App\Helpers\ConstantHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnquiriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enquiries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', ConstantHelper::FULLNAME_MAX_LENGTH);
            $table->string('store_name', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->string('email', ConstantHelper::EMAIL_MAX_LENGTH);
            $table->string('mobile', ConstantHelper::MOBILE_MAX_LENGTH);
            $table->text('description')->nullable();
            $table->string('geo_address', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->string('geo_latitude', ConstantHelper::NAME_MAX_LENGTH)->nullable();
            $table->string('geo_longitude', ConstantHelper::NAME_MAX_LENGTH)->nullable();
            $table->string('ip_address', ConstantHelper::NAME_MAX_LENGTH)->nullable();
            $table->string('enquiry_type', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();

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
        Schema::dropIfExists('enquiries');
    }
}
