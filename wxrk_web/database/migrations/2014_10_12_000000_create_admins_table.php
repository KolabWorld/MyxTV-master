<?php

use App\Helpers\ConstantHelper;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->string('status', 191)->default(ConstantHelper::ACTIVE)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('admins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->string('user_name', ConstantHelper::NAME_MAX_LENGTH)->nullable();
            $table->string('admin_type', ConstantHelper::NAME_MAX_LENGTH)->nullable();
            $table->string('password', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->boolean('has_password')->default(1);
            $table->string('email', ConstantHelper::EMAIL_MAX_LENGTH)->nullable();
            $table->boolean('is_email_verified')->default(0);
            $table->string('mobile', ConstantHelper::MOBILE_MAX_LENGTH)->nullable();
            $table->boolean('is_mobile_verified')->default(0);
            $table->boolean('two_step_verification')->default(0);
            $table->string('company_name', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->string('company_website', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->string('contact_person_name', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->string('alternate_contact_number', ConstantHelper::MOBILE_MAX_LENGTH)->nullable();
            $table->string('alternate_email', ConstantHelper::EMAIL_MAX_LENGTH)->nullable();
            $table->string('business_category', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->bigInteger('business_category_id')->unsigned()->nullable();
            $table->rememberToken();
            $table->string('status', 191)->default(ConstantHelper::ACTIVE)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('admins', function (Blueprint $table) {
            $table->foreign('business_category_id')->references('id')->on('business_categories');
            $table->foreign('created_by')->references('id')->on('admins');
            $table->foreign('updated_by')->references('id')->on('admins');
        });

        Schema::create('admin_profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('admin_id')->unsigned()->nullable();
            $table->longText('who_we_are')->nullable();
            $table->string('purpose', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->longText('origins')->nullable();
            $table->string('status', 191)->default(ConstantHelper::ACTIVE)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('admin_profiles', function (Blueprint $table) {
            $table->foreign('admin_id')->references('id')->on('admins');
        });

        Schema::create('origins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->string('status', 191)->default(ConstantHelper::ACTIVE)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_profiles');
        Schema::dropIfExists('admins');
        Schema::dropIfExists('business_categories');
        Schema::dropIfExists('origins');
    }
}