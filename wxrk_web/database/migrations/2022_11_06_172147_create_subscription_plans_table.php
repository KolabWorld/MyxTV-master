<?php

use App\Helpers\ConstantHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_plans', function (Blueprint $table) {
            
            $table->bigIncrements('id');
            $table->string('name', ConstantHelper::FULLNAME_MAX_LENGTH)
                ->nullable();
            $table->string('plan_type', ConstantHelper::NAME_MAX_LENGTH)
                ->nullable();
            $table->unsignedBigInteger('price')
                ->nullable();
            $table->unsignedBigInteger('no_of_allowed_images')
                ->nullable();
            $table->unsignedBigInteger('no_of_allowed_videos')
                ->nullable();
            $table->longText('description')
                ->nullable();
            $table->string('status', 191)
                ->default(ConstantHelper::ACTIVE)
                ->nullable();
            $table->unsignedBigInteger('created_by')
                ->nullable();
            $table->unsignedBigInteger('updated_by')
                ->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('created_by')->references('id')->on('admins');
            $table->foreign('updated_by')->references('id')->on('admins');

        });

        Schema::create('subscription_plan_logs', function (Blueprint $table) {
            
            $table->bigIncrements('id');
            $table->string('name', ConstantHelper::FULLNAME_MAX_LENGTH)
                ->nullable();
            $table->string('plan_type', ConstantHelper::NAME_MAX_LENGTH)
                ->nullable();
            $table->unsignedBigInteger('subscription_plan_id')
                ->nullable();
            $table->unsignedBigInteger('admin_id')
                ->nullable();
            $table->string('status', 191)
                ->default(ConstantHelper::ACTIVE)
                ->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('subscription_plan_id')->references('id')->on('subscription_plans');
            $table->foreign('admin_id')->references('id')->on('admins');

        });

        Schema::create('admin_subscription_plans', function (Blueprint $table) {
            
            $table->bigIncrements('id');
            $table->string('name', ConstantHelper::FULLNAME_MAX_LENGTH)
                ->nullable();
            $table->string('plan_type', ConstantHelper::NAME_MAX_LENGTH)
                ->nullable();
            $table->unsignedBigInteger('admin_id')
                ->nullable();
            $table->unsignedBigInteger('subscription_plan_id')
                ->nullable();
            $table->string('status', 191)
                ->default(ConstantHelper::ACTIVE)
                ->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('admin_id')->references('id')->on('admins');
            $table->foreign('subscription_plan_id')->references('id')->on('subscription_plans');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_subscription_plans');
        Schema::dropIfExists('subscription_plan_logs');
        Schema::dropIfExists('subscription_plans');
    }
}
