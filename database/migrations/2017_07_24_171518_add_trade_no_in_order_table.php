<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTradeNoInOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(CreateOrderTable::$tableName, function (Blueprint $table) {
            $table->string('trade_no')->nullable()->comment('商户订单号');
            $table->tinyInteger('refund_reason')->nullable()->comment('退款理由');
            $table->string('refund_reason_other')->nullable()->comment('其他退款理由');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(CreateOrderTable::$tableName, function (Blueprint $table) {
            $table->dropColumn('trade_no');
            $table->dropColumn('refund_reason');
            $table->dropColumn('refund_reason_other');
        });
    }
}
