<?php

use App\Helpers\ConstantHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInSupportTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('support_tickets', function (Blueprint $table) {
            //
            $table->dropColumn('name');
            $table->dropColumn('mobile_no');
            $table->dropColumn('email');
            $table->dropColumn('feedback');
        });
        Schema::table('support_tickets', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('category_id')->nullable()->after('id');
            $table->unsignedBigInteger('sub_category_id')->nullable()->after('category_id');
            $table->string('subject', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable()->after('sub_category_id');
            $table->longText('description')->nullable()->after('subject');

            $table->foreign('category_id')->references('id')->on('support_categories');
            $table->foreign('sub_category_id')->references('id')->on('support_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('support_tickets', function (Blueprint $table) {
            //

            $table->dropForeign(['category_id']);
            $table->dropForeign(['sub_category_id']);

            $table->dropColumn('category_id');
            $table->dropColumn('sub_category_id');
            $table->dropColumn('subject');
            $table->dropColumn('description');
        });
        Schema::table('support_tickets', function (Blueprint $table) {
            //

            $table->string('name', 191)->nullable()->after('id');
            $table->string('mobile_no', 15)->nullable()->after('name');
            $table->string('email', 191)->nullable()->after('mobile_no');
            $table->longText('feedback')->nullable()->after('email');
        });
    }
}
