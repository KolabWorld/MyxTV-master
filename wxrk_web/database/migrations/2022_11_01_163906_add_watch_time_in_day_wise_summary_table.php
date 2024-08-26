<?php

use App\Helpers\ConstantHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWatchTimeInDayWiseSummaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('day_wise_summary', function (Blueprint $table) {
            $table->string('watch_time', ConstantHelper::FULLNAME_MAX_LENGTH)
                ->after('day_idle_time')
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
            $table->dropColumn('watch_time');
        });
    }
}
