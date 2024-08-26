<?php

use App\Helpers\ConstantHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('banners', function (Blueprint $table) {
            
            $table->string('attachment_type', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable()->after('button_link');
            $table->integer('is_auto_play')->default(0)->nullable()->after('attachment_type');
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('banners', function (Blueprint $table) {
            
            $table->dropColumn('attachment_type');
            $table->dropColumn('is_auto_play');
            
        });
    }
}
