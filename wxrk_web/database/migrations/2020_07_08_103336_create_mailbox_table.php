<?php

use App\Helpers\ConstantHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailboxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_box', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('mail_to', 599);
            $table->string('mail_cc', 599)->nullable();
            $table->string('mail_bcc', 599)->nullable();
            $table->string('subject', 199);
            $table->json('mail_body')->nullable();
            $table->text('attachment')->nullable();
            $table->enum('status', ConstantHelper::MAIL_STATUS)->default(ConstantHelper::PENDING);
            $table->text('response')->nullable();
            $table->string('layout', 100)->nullable();
            $table->string('category', 100)->nullable();
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
        Schema::dropIfExists('mail_box');
    }
}
