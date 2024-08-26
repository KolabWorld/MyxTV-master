<?php

use App\Helpers\ConstantHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_channels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100);
            $table->string('alias', 100);
            $table->string('access_id', 291)->nullable();
            $table->string('access_code', 291)->nullable();
            $table->string('access_secret', 291)->nullable();
            $table->enum('status', ConstantHelper::STATUS)->default(ConstantHelper::ACTIVE)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('payment_transactions', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->unsignedBigInteger('payment_channel_id')->nullable();
            $table->unsignedBigInteger('offer_id')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('payable_type');
            $table->unsignedBigInteger('payable_id')->nullable();
            $table->string('transection_id', 100)->nullable();
            $table->string('payee_name', 299)->nullable();
            $table->string('payee_email', 299)->nullable();
            $table->string('payee_mobile', 299)->nullable();
            $table->decimal('amount', 10,2)->default(0.00)->nullable();
            $table->string('channel_invoice_id', 299)->nullable();
            $table->string('channel_order_id', 299)->nullable();
            $table->string('payment_link', 299)->nullable();
            $table->string('status', 199)->nullable();
            $table->longText('message')->nullable();
            $table->json('response')->nullable();
            $table->timestamps();

            $table->foreign('payment_channel_id')->references('id')->on('payment_channels');
            $table->foreign('offer_id')->references('id')->on('offers');
            $table->foreign('admin_id')->references('id')->on('admins');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_transactions');
        Schema::dropIfExists('payment_channels');
    }
}
