<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Helpers\ConstantHelper;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->morphs('payable'); // payable_id and payable_type
            $table->text('transection_id');
            $table->string('payee_email',ConstantHelper::EMAIL_MAX_LENGTH)->nullable(); 
            $table->unsignedBigInteger('amount');
            $table->string('currency');
            $table->string('country')->nullable();
            $table->enum('status', ConstantHelper::PAYMENT_STATUS)->default(ConstantHelper::INITIATED);
            $table->text('message')->nullable();
            $table->json('response')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
