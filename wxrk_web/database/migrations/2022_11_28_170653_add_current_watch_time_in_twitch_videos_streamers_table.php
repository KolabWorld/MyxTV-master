<?php

use App\Helpers\ConstantHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCurrentWatchTimeInTwitchVideosStreamersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('twitch_videos_streamers', function (Blueprint $table) {
            $table->string('current_watching_duration', ConstantHelper::FULLNAME_MAX_LENGTH)
                ->after('watching_duration')
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
        Schema::table('twitch_videos_streamers', function (Blueprint $table) {
            $table->dropColumn('current_watching_duration');
        });
    }
}
