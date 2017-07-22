<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSoftdeleteToObject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 分类
        Schema::table(CreateCategoryTable::$tableName, function (Blueprint $table) {
            $table->softDeletes();
        });

        // 商品
        Schema::table(CreateProductTable::$tableName, function (Blueprint $table) {
            $table->softDeletes();
        });

        // 规格
        Schema::table(CreateSpecTable::$tableName, function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // 分类
        Schema::table(CreateCategoryTable::$tableName, function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        // 商品
        Schema::table(CreateProductTable::$tableName, function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        // 规格
        Schema::table(CreateSpecTable::$tableName, function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
