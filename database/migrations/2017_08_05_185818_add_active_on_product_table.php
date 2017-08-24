<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddActiveOnProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(CreateProductTable::$tableName, function (Blueprint $table) {
            $table->tinyInteger('active')->default('1')->comment('上架');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(CreateProductTable::$tableName, function (Blueprint $table) {
            $table->dropColumn('active');
        });
    }
}
