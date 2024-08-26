<?php

use App\Helpers\ConstantHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_wallets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->unsigned()->nullable();
            $table->decimal('wxrk_earned', 10,2)->nullable();
            $table->decimal('wxrk_spent', 10,2)->nullable();
            $table->decimal('wxrk_balance', 10,2)->nullable();
            $table->string('watch_time', ConstantHelper::NAME_MAX_LENGTH)->nullable();
            $table->string('status', ConstantHelper::NAME_MAX_LENGTH)->nullable();
            $table->timestamps();
            $table->softDeletes();

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
        Schema::dropIfExists('user_wallets');
    }
}
