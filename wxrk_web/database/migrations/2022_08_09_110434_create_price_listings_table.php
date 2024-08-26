<?php

use App\Helpers\ConstantHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePriceListingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_views', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->decimal('offer_price_per_day', 10,2)->nullable();
            $table->decimal('premium_price_per_day', 10,2)->nullable();
            $table->string('status', ConstantHelper::NAME_MAX_LENGTH)->nullable();
            $table->unsignedBigInteger('created_by')->unsigned()->nullable();
            $table->unsignedBigInteger('updated_by')->unsigned()->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('created_by')->references('id')->on('admins');
            $table->foreign('updated_by')->references('id')->on('admins');
        });

        Schema::table('offers', function (Blueprint $table) {
            
            $table->bigInteger('price_view_id')->unsigned()->after('id')->nullable();
            $table->decimal('offer_listing_price', 10,2)->after('offer_period')->nullable();
            $table->decimal('offer_listing_value', 10,2)->after('offer_listing_price')->nullable();
            $table->integer('premium_listing_period')->nullable()->after('offer_listing_value');
            $table->decimal('premium_listing_price', 10,2)->after('premium_listing_period')->nullable();
            $table->decimal('premium_listing_value', 10,2)->after('premium_listing_price')->nullable();
            $table->decimal('total_value', 10,2)->after('premium_listing_value')->nullable();

            $table->foreign('price_view_id')->references('id')->on('price_views');
        
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('offers', function (Blueprint $table) {
            $table->dropForeign(['price_view_id']);
            $table->dropColumn('price_view_id');
            $table->dropColumn('offer_listing_price');
            $table->dropColumn('offer_listing_value');
            $table->dropColumn('premium_listing_period');
            $table->dropColumn('premium_listing_price');
            $table->dropColumn('premium_listing_value');
            $table->dropColumn('total_value');
        });
        Schema::dropIfExists('price_views');
    }
}
