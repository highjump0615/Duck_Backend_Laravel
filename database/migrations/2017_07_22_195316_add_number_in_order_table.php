<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNumberInOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(CreateOrderTable::$tableName, function (Blueprint $table) {
            $table->string('number')->comment('订单编号');
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
            $table->dropColumn('name');
        });
    }
}
