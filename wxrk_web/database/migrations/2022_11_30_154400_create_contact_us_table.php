<?php

use App\Helpers\ConstantHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactUsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_us', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', ConstantHelper::FULLNAME_MAX_LENGTH)
                ->nullable();
            $table->string('email',ConstantHelper::EMAIL_MAX_LENGTH)->nullable();
            $table->string('mobile',ConstantHelper::MOBILE_MAX_LENGTH)->nullable();
            $table->longText('message')
                ->nullable(); 
            $table->string('status', 191)
                ->default(ConstantHelper::ACTIVE)
                ->nullable(); 
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contact_us');
    }
}
