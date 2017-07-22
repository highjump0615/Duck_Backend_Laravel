<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductSpecTable extends Migration
{
    public static $tableName = 'product_specs';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(CreateProductSpecTable::$tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->unsignedInteger('product_id')->comment('产品');
            $table->unsignedInteger('spec_id')->comment('规格');

            //
            // 外键
            //

            // 产品
            $table->foreign('product_id')->references('id')
                ->on(CreateProductTable::$tableName)
                ->onUpdate('cascade')
                ->onDelete('cascade');
            // 规格
            $table->foreign('spec_id')->references('id')
                ->on(CreateSpecTable::$tableName)
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
        Schema::dropIfExists(CreateProductSpecTable::$tableName);
    }
}
