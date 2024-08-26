<?php

use App\Helpers\ConstantHelper;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', ConstantHelper::FULLNAME_MAX_LENGTH);
            $table->string('user_name', ConstantHelper::NAME_MAX_LENGTH)->unique();
            $table->string('password', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->boolean('has_password')->default(1);
            $table->string('email', ConstantHelper::EMAIL_MAX_LENGTH)->nullable();
            $table->boolean('is_email_verified')->default(0);
            $table->string('mobile', ConstantHelper::MOBILE_MAX_LENGTH)->nullable();
            $table->boolean('is_mobile_verified')->default(0);
            $table->boolean('two_step_verification')->default(0);
            $table->rememberToken();
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ConstantHelper::GENDER)->nullable();
            $table->enum('marital_status', ConstantHelper::MARITAL_STATUS)->nullable();
            $table->string('status', 191)->default(ConstantHelper::ACTIVE)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('created_by')->references('id')->on('users')->onDelete('NO ACTION');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}