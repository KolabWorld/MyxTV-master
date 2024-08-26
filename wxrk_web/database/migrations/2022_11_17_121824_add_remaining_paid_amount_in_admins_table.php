<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRemainingPaidAmountInAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admins', function (Blueprint $table) {
            //
            $table->double('remaining_paid_amount')->default(0)->after('is_payment_done');
        });
        Schema::table('subscription_plan_logs', function (Blueprint $table) {
            //
            $table->double('paid_amount')->nullable()->after('admin_id');
            $table->double('remaining_paid_amount')->default(0)->after('paid_amount');
            $table->timestamp('plan_expires_at')->nullable()->after('remaining_paid_amount');
            $table->timestamp('plan_upgraded_at')->nullable()->after('plan_expires_at');
            $table->integer('used_days')->nullable()->after('plan_upgraded_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admins', function (Blueprint $table) {
            //
            $table->dropColumn('remaining_paid_amount');
        });
        Schema::table('subscription_plan_logs', function (Blueprint $table) {
            //
            $table->dropColumn('paid_amount');
            $table->dropColumn('remaining_paid_amount');
            $table->dropColumn('plan_expires_at');
            $table->dropColumn('plan_upgraded_at');
            $table->dropColumn('used_days');
        });
    }
}
