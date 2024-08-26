<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDatatypeInDayWisePoolMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('day_wise_pool_masters', function (Blueprint $table) {
            //
            $table->decimal('pool_balance', 24, 8)->nullable()->change();
            $table->decimal('daily_limit', 24, 8)->nullable()->change();
            $table->decimal('wxrk_dist_limit', 24, 8)->nullable()->change();
            $table->decimal('wxrk_per_user_per_day', 24, 8)->nullable()->change();
            $table->decimal('wxrk_per_min', 24, 8)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('day_wise_pool_masters', function (Blueprint $table) {
            //
            $table->decimal('pool_balance', 10, 2)->nullable()->change();
            $table->decimal('daily_limit', 10, 2)->nullable()->change();
            $table->decimal('wxrk_dist_limit', 10, 2)->nullable()->change();
            $table->decimal('wxrk_per_user_per_day', 10, 2)->nullable()->change();
            $table->decimal('wxrk_per_min', 10, 2)->nullable()->change();
        });
    }
}
