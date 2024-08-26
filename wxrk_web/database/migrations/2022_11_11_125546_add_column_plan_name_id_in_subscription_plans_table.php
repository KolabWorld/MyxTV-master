<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnPlanNameIdInSubscriptionPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('plan_name_id')->nullable()->after('name');

            $table->foreign('plan_name_id')->references('id')->on('plan_names');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            //
            $table->dropForeign(['plan_name_id']);
            $table->dropColumn('plan_name_id');
        });
    }
}
