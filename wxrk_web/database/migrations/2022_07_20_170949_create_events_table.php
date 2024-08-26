<?php
use App\Helpers\ConstantHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->string('status', 191)->default(ConstantHelper::ACTIVE)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('sponsers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->string('email', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->string('mobile', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->string('status', 191)->default(ConstantHelper::ACTIVE)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id', true);
            $table->bigInteger('event_type_id')->unsigned()->nullable();
            $table->string('name', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->longText('description')->nullable();
            $table->string('organizer', ConstantHelper::NAME_MAX_LENGTH)->nullable();
            $table->longText('how_to_join')->nullable();
            $table->bigInteger('country_id')->unsigned()->nullable();
            $table->timestamp('start_date_time')->nullable();
            $table->timestamp('end_date_time')->nullable();
            $table->string('status', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->unsignedBigInteger('created_by')->unsigned()->nullable();
            $table->unsignedBigInteger('updated_by')->unsigned()->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('event_type_id')->references('id')->on('event_types');
            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('created_by')->references('id')->on('admins');
            $table->foreign('updated_by')->references('id')->on('admins');
        });

        Schema::create('event_sponser', function (Blueprint $table) {
            $table->bigIncrements('id', true);
            $table->bigInteger('event_id')->unsigned()->nullable();
            $table->bigInteger('sponser_id')->unsigned()->nullable();
            $table->bigInteger('admin_id')->unsigned()->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('event_id')->references('id')->on('events');
            $table->foreign('sponser_id')->references('id')->on('sponsers');
            $table->foreign('admin_id')->references('id')->on('admins');
        });

        Schema::create('event_participations', function (Blueprint $table) {
            $table->bigIncrements('id', true);
            $table->bigInteger('event_id')->unsigned()->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->bigInteger('admin_id')->unsigned()->nullable();
            $table->date('enrolement_date')->nullable();
            $table->string('enrolement_time', )->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('event_id')->references('id')->on('events');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('admin_id')->references('id')->on('admins');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_participations');
        Schema::dropIfExists('event_sponser');
        Schema::dropIfExists('events');
        Schema::dropIfExists('sponsers');
        Schema::dropIfExists('event_types');
    }
}
