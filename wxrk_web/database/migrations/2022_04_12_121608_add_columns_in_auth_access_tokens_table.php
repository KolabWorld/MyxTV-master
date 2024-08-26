<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInAuthAccessTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('oauth_access_tokens', function (Blueprint $table) {
            $table->string('device_name', 291)->after('revoked')->nullable();
            $table->longText('device_address')->after('device_name')->nullable();
            $table->string('os_version', 291)->after('device_address')->nullable();
            $table->string('app_version', 291)->after('os_version')->nullable();
            $table->string('firebase_id', 291)->after('app_version')->nullable();
            $table->string('latitude', 291)->after('firebase_id')->nullable();
            $table->string('longitude', 291)->after('latitude')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('oauth_access_tokens', function (Blueprint $table) {
            $table->dropColumn('longitude');
            $table->dropColumn('latitude');
            $table->dropColumn('firebase_id');
            $table->dropColumn('app_version');
            $table->dropColumn('os_version');
            $table->dropColumn('device_address');
            $table->dropColumn('device_name');
        });
    }
}
