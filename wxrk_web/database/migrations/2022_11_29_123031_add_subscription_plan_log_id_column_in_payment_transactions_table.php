<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubscriptionPlanLogIdColumnInPaymentTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_transactions', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('subscription_plan_log_id')->nullable()->after('payable_id');

            $table->foreign('subscription_plan_log_id')->references('id')->on('subscription_plan_logs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_transactions', function (Blueprint $table) {
            //
            $table->dropForeign(['subscription_plan_log_id']);
            $table->dropColumn('subscription_plan_log_id');
        });
    }
}
