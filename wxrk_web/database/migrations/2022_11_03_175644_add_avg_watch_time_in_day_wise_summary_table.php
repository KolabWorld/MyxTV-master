<?php

use App\Helpers\ConstantHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAvgWatchTimeInDayWiseSummaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('day_wise_summary', function (Blueprint $table) {
            $table->bigInteger('time_saved')
                ->after('watch_time')
                ->nullable();

            $table->bigInteger('time_saved_percentage')
                ->after('time_saved')
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
        Schema::table('day_wise_summary', function (Blueprint $table) {
            $table->dropColumn('time_saved_percentage');
            $table->dropColumn('time_saved');
        });
    }
}
