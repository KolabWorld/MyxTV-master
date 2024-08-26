<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeInOtpRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('otp_request', function (Blueprint $table) {
            //
            $table->dropForeign(['user_id']);
        });
        Schema::table('otp_request', function (Blueprint $table) {
            //
            $table->bigInteger('user_id')->unsigned()->nullable()->change();
            $table->string('auth_type', 100)->nullable()->after('user_id');
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
        Schema::table('otp_request', function (Blueprint $table) {
            //
            $table->dropForeign(['user_id']);
            $table->dropColumn('auth_type');
        });
        Schema::table('otp_request', function (Blueprint $table) {
            //
            $table->bigInteger('user_id')->unsigned()->change();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }
}
