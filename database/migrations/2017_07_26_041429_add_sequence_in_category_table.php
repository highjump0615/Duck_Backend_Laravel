<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSequenceInCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(CreateCategoryTable::$tableName, function (Blueprint $table) {
            $table->integer('sequence')->comment('顺序');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(CreateCategoryTable::$tableName, function (Blueprint $table) {
            $table->dropColumn('sequence');
        });
    }
}
