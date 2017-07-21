<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpecTable extends Migration
{
    public static $tableName = 'specs';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(CreateSpecTable::$tableName, function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('名称');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(CreateSpecTable::$tableName);
    }
}
