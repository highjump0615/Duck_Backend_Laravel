<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAreaOnOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(CreateOrderTable::$tableName, function (Blueprint $table) {
            $table->string('area')->nullable()->comment('地区');
            $table->string('zipcode')->nullable()->comment('邮政编号');
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
            $table->dropColumn('area')->nullable()->comment('地区');
            $table->dropColumn('zipcode')->nullable()->comment('邮政编号');
        });
    }
}
