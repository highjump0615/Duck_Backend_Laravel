<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeGroupbuyNullableInOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(CreateOrderTable::$tableName, function (Blueprint $table) {
            $table->unsignedInteger('groupbuy_id')->nullable()->change();
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
            $table->unsignedInteger('groupbuy_id')->nullable(false)->change();
        });
    }
}
