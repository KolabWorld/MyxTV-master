<?php

use App\Helpers\ConstantHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id', true);
            $table->string('order_number', 100)->nullable();
            $table->bigInteger('offer_id')->unsigned()->nullable();
            $table->string('offer_name', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->decimal('offer_price', 10,2)->default(0.00)->nullable();
            $table->string('offer_promo_code', ConstantHelper::NAME_MAX_LENGTH)->nullable();
            $table->string('promo_code_redemption_status', ConstantHelper::NAME_MAX_LENGTH)->nullable();
            $table->date('promo_code_redemption_date')->nullable();
            $table->string('offer_type', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->string('offer_category', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->string('offer_premium_category', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->decimal('time_to_redeem', 10,2)->default(0.00)->nullable();
            $table->longText('highlight_of_offer')->nullable();
            $table->longText('details_of_offer')->nullable();
            $table->string('link', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->string('customer_name', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->string('customer_mobile', ConstantHelper::NAME_MAX_LENGTH)->nullable();
            $table->string('customer_email', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->string('customer_country', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->bigInteger('admin_id')->unsigned()->nullable();
            $table->string('vendor_name', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->string('vendor_mobile', ConstantHelper::NAME_MAX_LENGTH)->nullable();
            $table->string('vendor_email', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->string('vendor_country', ConstantHelper::NAME_MAX_LENGTH)->nullable();
            $table->string('vendor_category', ConstantHelper::NAME_MAX_LENGTH)->nullable();
            $table->string('vendor_state', ConstantHelper::NAME_MAX_LENGTH)->nullable();
            $table->string('vendor_city', ConstantHelper::NAME_MAX_LENGTH)->nullable();
            $table->longText('vendor_address')->nullable();
            $table->string('vendor_postal_code', ConstantHelper::NAME_MAX_LENGTH)->nullable();
            $table->string('status', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('updated_by')->unsigned()->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('offer_id')->references('id')->on('offers');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('admin_id')->references('id')->on('admins');
            $table->foreign('created_by')->references('id')->on('users');
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
        Schema::dropIfExists('orders');
    }
}
