<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFormIdOnOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(CreateOrderTable::$tableName, function (Blueprint $table) {
            $table->string('formid')->nullable();
            $table->string('formid_group')->nullable();
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
            $table->dropColumn('formid');
            $table->dropColumn('formid_group');
        });
    }
}
