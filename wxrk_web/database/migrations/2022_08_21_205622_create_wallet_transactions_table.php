<?php

use App\Helpers\ConstantHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('offer_id')->unsigned()->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->string('type', 299)->nullable();
            $table->decimal('wxrk_balance', 10,2)->default(0.00)->nullable();
            $table->decimal('app_usage_time', 10,2)->default(0.00)->nullable();
            $table->decimal('idle_time', 10,2)->default(0.00)->nullable();
            $table->string('status', 199)->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('offer_id')->references('id')->on('offers');
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
        Schema::dropIfExists('wallet_transactions');
    }
}
