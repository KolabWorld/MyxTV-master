<?php

use App\Helpers\ConstantHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoolMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pool_masters', function (Blueprint $table) {
            $table->bigIncrements('id', true);
            
            $table->unsignedBigInteger('total_supply')->unsigned()->nullable();
            $table->string('wxrk_pool', ConstantHelper::NAME_MAX_LENGTH)->nullable();
            $table->decimal('daily_limit', 10,2)->nullable();
            $table->decimal('max_coin_per_user', 10,2)->nullable();
            $table->string('status', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->unsignedBigInteger('created_by')->unsigned()->nullable();
            $table->unsignedBigInteger('updated_by')->unsigned()->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('created_by')->references('id')->on('admins');
            $table->foreign('updated_by')->references('id')->on('admins');

        });

        Schema::create('day_wise_pool_masters', function (Blueprint $table) {
            $table->bigIncrements('id', true);

            $table->unsignedBigInteger('pool_master_id')->unsigned()->nullable();
            $table->date('pool_date')->nullable();
            $table->decimal('pool_balance', 10,2)->nullable();
            $table->decimal('daily_limit', 10,2)->nullable();
            $table->unsignedBigInteger('total_user')->unsigned()->nullable();
            $table->decimal('wxrk_dist_limit', 10,2)->nullable();
            $table->decimal('wxrk_per_user_per_day', 10,2)->nullable();
            $table->decimal('wxrk_per_min', 20,8)->nullable();
            $table->string('status', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->unsignedBigInteger('created_by')->unsigned()->nullable();
            $table->unsignedBigInteger('updated_by')->unsigned()->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('pool_master_id')->references('id')->on('pool_masters');
            $table->foreign('created_by')->references('id')->on('admins');
            $table->foreign('updated_by')->references('id')->on('admins');
        });

        Schema::create('android_usage_logs', function (Blueprint $table) {
            $table->bigIncrements('id', true);

            $table->unsignedBigInteger('user_id')->unsigned()->nullable();
            $table->date('log_date')->nullable();
            $table->time('last_sync_time')->nullable();
            $table->time('current_time')->nullable();
            $table->string('app_name', ConstantHelper::NAME_MAX_LENGTH)->nullable();
            $table->string('package_name', ConstantHelper::NAME_MAX_LENGTH)->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->decimal('usage_time', 10,2)->nullable();
            $table->string('status', ConstantHelper::NAME_MAX_LENGTH)->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('ios_usage_logs', function (Blueprint $table) {
            $table->bigIncrements('id', true);

            $table->unsignedBigInteger('user_id')->unsigned()->nullable();
            $table->string('event_name', ConstantHelper::NAME_MAX_LENGTH)->nullable();
            $table->date('log_date')->nullable();
            $table->time('event_time')->nullable();
            $table->time('current_time')->nullable();
            $table->decimal('idle_time', 10,2)->nullable();
            $table->decimal('total_idle_time', 10,2)->nullable();
            $table->string('timer_status', ConstantHelper::NAME_MAX_LENGTH)->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('app_summary_logs', function (Blueprint $table) {
            $table->bigIncrements('id', true);

            $table->unsignedBigInteger('user_id')->unsigned()->nullable();
            $table->date('log_date')->nullable();
            $table->string('app_name', ConstantHelper::NAME_MAX_LENGTH)->nullable();
            $table->string('package_name', ConstantHelper::NAME_MAX_LENGTH)->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->decimal('usage_time', 10,2)->nullable();
            $table->string('status', ConstantHelper::NAME_MAX_LENGTH)->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('ios_idle_times', function (Blueprint $table) {
            $table->bigIncrements('id', true);

            $table->unsignedBigInteger('user_id')->unsigned()->nullable();
            $table->unsignedBigInteger('ios_usage_log_id')->unsigned()->nullable();
            $table->date('log_date')->nullable();
            $table->time('last_sync_time')->nullable();
            $table->time('current_time')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->decimal('idle_time', 10,2)->nullable();
            $table->string('status', ConstantHelper::NAME_MAX_LENGTH)->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('ios_usage_log_id')->references('id')->on('ios_usage_logs');
        });

        Schema::create('day_wise_summary', function (Blueprint $table) {
            $table->bigIncrements('id', true);

            $table->unsignedBigInteger('user_id')->unsigned()->nullable();
            $table->unsignedBigInteger('android_usage_log_id')->unsigned()->nullable();
            $table->unsignedBigInteger('app_summary_log_id')->unsigned()->nullable();
            $table->date('log_date')->nullable();
            $table->decimal('wxrk_per_minute', 20,8)->nullable();
            $table->decimal('total_app_usage_time', 10,2)->nullable();
            $table->decimal('day_total_time', 10,2)->nullable();
            $table->decimal('day_idle_time', 10,2)->nullable();
            $table->decimal('wxrk_earned', 10,2)->nullable();
            $table->decimal('wxrk_spent', 10,2)->nullable();
            $table->decimal('wxrk_balance', 10,2)->nullable();
            $table->string('status', ConstantHelper::NAME_MAX_LENGTH)->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('android_usage_log_id')->references('id')->on('android_usage_logs');
            $table->foreign('app_summary_log_id')->references('id')->on('app_summary_logs');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('day_wise_summary');
        Schema::dropIfExists('ios_idle_times');
        Schema::dropIfExists('app_summary_logs');
        Schema::dropIfExists('ios_usage_logs');
        Schema::dropIfExists('android_usage_logs');
        Schema::dropIfExists('day_wise_pool_masters');
        Schema::dropIfExists('pool_masters');
    }
}
