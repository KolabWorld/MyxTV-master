<?php

use App\Helpers\ConstantHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEarningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('earnings', function (Blueprint $table) {
            $table->bigIncrements('id', true);
            $table->string('transaction_reference_no', ConstantHelper::NAME_MAX_LENGTH)->nullable();
            $table->decimal('transaction_amount', 10,2)->default(0.00)->nullable();
            $table->string('status', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->unsignedBigInteger('offer_id')->unsigned()->nullable();
            $table->unsignedBigInteger('admin_id')->unsigned()->nullable();
            $table->unsignedBigInteger('user_id')->unsigned()->nullable();
            $table->unsignedBigInteger('created_by')->unsigned()->nullable();
            $table->unsignedBigInteger('updated_by')->unsigned()->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('offer_id')->references('id')->on('offers');
            $table->foreign('admin_id')->references('id')->on('admins');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('created_by')->references('id')->on('admins');
            $table->foreign('updated_by')->references('id')->on('admins');
        });

        Schema::create('payouts', function (Blueprint $table) {
            $table->bigIncrements('id', true);
            $table->unsignedBigInteger('earning_id')->unsigned()->nullable();
            $table->unsignedBigInteger('offer_id')->unsigned()->nullable();
            $table->string('status', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('earning_id')->references('id')->on('earnings');
            $table->foreign('offer_id')->references('id')->on('offers');
        });

        Schema::create('supports', function (Blueprint $table) {
            $table->bigIncrements('id', true);
            $table->string('category', ConstantHelper::NAME_MAX_LENGTH)->nullable();
            $table->string('sub_category', ConstantHelper::NAME_MAX_LENGTH)->nullable();
            $table->string('subject', ConstantHelper::NAME_MAX_LENGTH)->nullable();
            $table->longText('description')->nullable();
            $table->string('received_from', ConstantHelper::NAME_MAX_LENGTH)->nullable();
            $table->date('received_date')->nullable();
            $table->string('received_time', )->nullable();
            $table->string('response_status', ConstantHelper::NAME_MAX_LENGTH)->nullable();
            $table->date('response_date')->nullable();
            $table->string('response_time', )->nullable();
            
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
        Schema::dropIfExists('supports');
        Schema::dropIfExists('payouts');
        Schema::dropIfExists('earnings');
    }
}
