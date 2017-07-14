<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdsTable extends Migration
{
    public static $tableName = 'ads';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(CreateAdsTable::$tableName, function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_id')->comment('商品');
            $table->text('image_url')->nullable();
            $table->dateTime('start_at');
            $table->dateTime('end_at');

            $table->timestamps();

            //
            // 外键
            //

            // 订单
            $table->foreign('product_id')->references('id')
                ->on(CreateProductTable::$tableName)
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(CreateAdsTable::$tableName, function (Blueprint $table) {
            $table->dropForeign(CreateOrderTable::$tableName.'_product_id_foreign');
        });

        Schema::dropIfExists(CreateAdsTable::$tableName);
    }
}
