<?php

use App\Helpers\ConstantHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTwitchVideosStreamersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('twitch_videos_streamers', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->bigInteger('twitch_video_id')->unsigned()->nullable();
            $table->string('twitch_id', ConstantHelper::NAME_MAX_LENGTH)->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->string('video_duration', ConstantHelper::NAME_MAX_LENGTH)->nullable();
            $table->string('watching_duration', ConstantHelper::NAME_MAX_LENGTH)->nullable();
            $table->decimal('coin', 10,2)->nullable();
            $table->string('status', ConstantHelper::NAME_MAX_LENGTH)->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('twitch_video_id')->references('id')->on('twitch_videos');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('twitch_videos_streamers');
    }
}
