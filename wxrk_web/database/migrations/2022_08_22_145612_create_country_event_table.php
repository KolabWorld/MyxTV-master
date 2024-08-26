<?php

use App\Helpers\ConstantHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountryEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('country_event', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('event_id')->unsigned()->nullable();
            $table->bigInteger('country_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('event_id')->references('id')->on('events');
            $table->foreign('country_id')->references('id')->on('countries');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->longText('highlights')->after('description')->nullable();
            $table->string('venue', ConstantHelper::FULLNAME_MAX_LENGTH)->after('end_date_time')->nullable();
            $table->string('company_name', ConstantHelper::FULLNAME_MAX_LENGTH)->after('venue')->nullable();
            $table->longText('about_the_company')->after('company_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('about_the_company');
            $table->dropColumn('company_name');
            $table->dropColumn('venue');
            $table->dropColumn('highlights');
        });
        Schema::dropIfExists('country_event');
    }
}
