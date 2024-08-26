<?php

use App\Helpers\ConstantHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanNamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_names', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('plan_type_id')->nullable();
            $table->string('name', ConstantHelper::FULLNAME_MAX_LENGTH)->nullable();
            $table->string('max_images_allowed',291)->nullable();
            $table->string('max_videos_allowed',291)->nullable();
            $table->string('status', 191)->default(ConstantHelper::ACTIVE)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('plan_type_id')->references('id')->on('plan_types');
            $table->foreign('created_by')->references('id')->on('admins');
            $table->foreign('updated_by')->references('id')->on('admins');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plan_names');
    }
}
