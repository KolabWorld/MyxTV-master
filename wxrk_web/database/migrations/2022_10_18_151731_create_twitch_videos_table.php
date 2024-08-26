<?php

use App\Helpers\ConstantHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTwitchVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('twitch_videos', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('twitch_id', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->string('stream_id', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->string('user_id', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->string('user_login', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->string('user_name', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->string('title', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->longText('description')->nullable();
            $table->string('url', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->string('thumbnail_url', 799)->nullable();
            $table->string('viewable', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->bigInteger('view_count')->unsigned()->nullable();
            $table->string('language', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->string('type', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->string('duration', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->string('muted_segments', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->timestamp('video_created_at')->nullable();
            $table->timestamp('video_published_at')->nullable();
            $table->string('status', ConstantHelper::NAME_MAX_LENGTH)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('twitch_videos');
    }
}
