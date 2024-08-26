<?php

use App\Helpers\ConstantHelper;
use FontLib\Table\Type\name;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNameInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('name',ConstantHelper::FULLNAME_MAX_LENGTH)->after('id')->nullable();
            $table->tinyInteger('is_new_user')->default(1)->after('timezone');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('is_new_user');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('name',ConstantHelper::FULLNAME_MAX_LENGTH)->after('id');
        });
    }
}
