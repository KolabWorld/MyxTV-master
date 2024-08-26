<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnPlanExpiresAtInAdminSubscriptionPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_subscription_plans', function (Blueprint $table) {
            //
            $table->timestamp('plan_expires_at')->nullable()->after('subscription_plan_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admin_subscription_plans', function (Blueprint $table) {
            //
            $table->dropColumn('plan_expires_at');
        });
    }
}
