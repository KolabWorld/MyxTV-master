<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBaseValueAgainstUsdColumnInPoolMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pool_masters', function (Blueprint $table) {
            //
            $table->double('base_value_against_usd')->nullable()->after('max_coin_per_user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pool_masters', function (Blueprint $table) {
            //
            $table->dropColumn('base_value_against_usd');
        });
    }
}
