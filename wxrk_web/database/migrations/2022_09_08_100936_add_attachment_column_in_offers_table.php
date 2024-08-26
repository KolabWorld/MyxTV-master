<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAttachmentColumnInOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('offers', function (Blueprint $table) {
            $table->string('attachment_type', 191)->after('premium_offer_end_date')->nullable();
            $table->integer('is_auto_play')->unsigned()->after('attachment_type')->nullable();
        });

        Schema::table('events', function (Blueprint $table) {
            $table->string('attachment_type', 191)->after('about_the_company')->nullable();
            $table->integer('is_auto_play')->unsigned()->after('attachment_type')->nullable();
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
            $table->dropColumn('is_auto_play');
            $table->dropColumn('attachment_type');
        });
        Schema::table('offers', function (Blueprint $table) {
            $table->dropColumn('is_auto_play');
            $table->dropColumn('attachment_type');
        });
    }
}
