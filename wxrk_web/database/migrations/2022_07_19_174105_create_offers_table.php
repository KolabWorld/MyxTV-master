<?php

use App\Helpers\ConstantHelper;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offer_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->string('status', 191)->default(ConstantHelper::ACTIVE)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('offer_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->string('status', 191)->default(ConstantHelper::ACTIVE)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('premium_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->string('status', 191)->default(ConstantHelper::ACTIVE)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('offers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('country_id')->unsigned()->nullable();
            $table->unsignedBigInteger('offer_type_id')->unsigned()->nullable();
            $table->unsignedBigInteger('offer_category_id')->unsigned()->nullable();
            $table->unsignedBigInteger('premium_category_id')->unsigned()->nullable();
            $table->string('offer_name', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->decimal('offer_price', 10,2)->default(0.00)->nullable();
            $table->unsignedBigInteger('offer_period')->unsigned()->nullable();
            $table->date('start_date')->nullable();
            $table->unsignedBigInteger('stock')->unsigned()->nullable();
            $table->unsignedBigInteger('low_stock')->unsigned()->nullable();
            $table->string('you_get', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->decimal('time_to_redeem', 10,2)->default(0.00)->nullable();
            $table->longText('highlight_of_offer')->nullable();
            $table->longText('details_of_offer')->nullable();
            $table->string('link', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->string('offer_code_bg_color', ConstantHelper::NAME_MAX_LENGTH)->nullable();
            $table->string('offer_code_text_color', ConstantHelper::NAME_MAX_LENGTH)->nullable();
            $table->string('status', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->unsignedBigInteger('created_by')->unsigned()->nullable();
            $table->unsignedBigInteger('updated_by')->unsigned()->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('offer_type_id')->references('id')->on('offer_types');
            $table->foreign('offer_category_id')->references('id')->on('offer_categories');
            $table->foreign('premium_category_id')->references('id')->on('premium_categories');
            $table->foreign('created_by')->references('id')->on('admins');
            $table->foreign('updated_by')->references('id')->on('admins');
        });

        Schema::create('promo_codes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('offer_id')->unsigned()->nullable();
            $table->string('promo_code', ConstantHelper::NAME_MAX_LENGTH)->nullable();
            $table->string('redemption_status', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->date('redemption_date')->nullable();
            $table->string('status', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->unsignedBigInteger('created_by')->unsigned()->nullable();
            $table->unsignedBigInteger('updated_by')->unsigned()->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('offer_id')->references('id')->on('offers');
            $table->foreign('created_by')->references('id')->on('admins');
            $table->foreign('updated_by')->references('id')->on('admins');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promo_codes');
        Schema::dropIfExists('offers');
        Schema::dropIfExists('premium_categories');
        Schema::dropIfExists('offer_categories');
        Schema::dropIfExists('offer_types');
    }
}
