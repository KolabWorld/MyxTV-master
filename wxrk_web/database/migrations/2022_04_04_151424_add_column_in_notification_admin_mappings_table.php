<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnInNotificationAdminMappingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notification_admin_mappings', function (Blueprint $table) {
            $table->tinyInteger('mark_as_read')->default(0)->after('admin_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notification_admin_mappings', function (Blueprint $table) {
            $table->dropColumn('mark_as_read');
        });
    }
}
