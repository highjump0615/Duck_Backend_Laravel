<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration
{
    public static $tableName = 'orders';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(CreateOrderTable::$tableName, function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('customer_id')->comment('客户');
            $table->integer('count')->comment('数量');
            $table->string('name')->comment('姓名');
            $table->string('phone')->comment('手机号');
            $table->tinyInteger('channel')->comment('渠道 0:发货, 1：自提');
            $table->unsignedInteger('store_id')->comment('门店');
            $table->string('desc')->nullable()->comment('备注');
            $table->string('address')->nullable()->comment('地址');
            $table->tinyInteger('pay_status')->comment('支付状态');
            $table->tinyInteger('status')->comment('状态');
            $table->unsignedInteger('groupbuy_id')->comment('拼团');
            $table->string('deliver_code')->nullable()->comment('快递单号');

            $table->timestamps();
            $table->softDeletes();

            //
            // 外键
            //

            // 客户
            $table->foreign('customer_id')->references('id')
                ->on(CreateCustomerTable::$tableName)
                ->onUpdate('cascade')
                ->onDelete('cascade');
            // 门店
            $table->foreign('store_id')->references('id')
                ->on(CreateStoreTable::$tableName)
                ->onUpdate('cascade')
                ->onDelete('cascade');
            // 拼团状态
            $table->foreign('groupbuy_id')->references('id')
                ->on(CreateGroupBuyTable::$tableName)
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
        Schema::dropIfExists(CreateOrderTable::$tableName);
    }
}
