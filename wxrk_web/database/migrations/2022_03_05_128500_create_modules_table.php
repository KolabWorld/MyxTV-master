<?php

use App\Helpers\ConstantHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->string('alias', ConstantHelper::ALIAS_MAX_LENGTH)->unique()->nullable();
            $table->longText('description')->nullable();
            $table->string('icon', 100)->nullable();
            $table->integer ('order')->nullable();
            $table->string('status', 191)->default(ConstantHelper::PENDING)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('module_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('module_id')->nullable();
            $table->string('title', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->string('alias', ConstantHelper::ALIAS_MAX_LENGTH)->unique()->nullable();
            $table->string('icon', 100)->nullable();
            $table->string('status', 191)->default(ConstantHelper::PENDING)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('module_id')->references('id')->on('modules');
        });

        Schema::create('admin_modules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->unsignedBigInteger('module_id')->nullable();
            $table->unsignedBigInteger('module_detail_id')->nullable();
            $table->string('title', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->longText('description')->nullable();
            $table->integer ('order')->nullable();
            $table->string('status', 191)->default(ConstantHelper::PENDING);
            $table->timestamps();

            $table->foreign('admin_id')->references('id')->on('admins');
            $table->foreign('module_id')->references('id')->on('modules');
            $table->foreign('module_detail_id')->references('id')->on('module_details');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::dropIfExists('admin_modules');
        Schema::dropIfExists('module_details');
        Schema::dropIfExists('modules');
    }
}