<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderHistoryTable extends Migration
{
    public static $tableName = 'order_histories';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(CreateOrderHistoryTable::$tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->unsignedInteger('order_id')->comment('订单');
            $table->tinyInteger('status')->comment('状态');
            $table->timestamps();

            //
            // 外键
            //

            // 订单
            $table->foreign('order_id')->references('id')
                ->on(CreateOrderTable::$tableName)
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
        Schema::dropIfExists(CreateOrderHistoryTable::$tableName);
    }
}
