<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInSubscriptionPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->unsignedBigInteger('offers_in_a_month')
                ->after('no_of_allowed_videos')
                ->nullable();

            $table->unsignedBigInteger('premium_days')
                ->after('offers_in_a_month')
                ->nullable();
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
            $table->dropColumn('premium_days');
            $table->dropColumn('offers_in_a_month');
        });
    }
}
