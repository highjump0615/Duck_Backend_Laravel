<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    public static $tableName = 'product';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(CreateProductTable::$tableName, function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('名称');
            $table->unsignedInteger('category_id')->comment('分类');
            $table->text('rtf_content')->nullable()->comment('详细介绍');
            $table->string('thumbnail')->comment('缩略图')->nullable();
            $table->double('price')->comment('原价');
            $table->double('deliver_cost')->comment('运费');

            // 拼团设置
            $table->integer('gb_count')->comment('人数底线');
            $table->double('gb_price')->comment('拼团价');
            $table->integer('gb_timeout')->comment('倒计时周期');

            // 库存
            $table->integer('remain')->comment('库存');
            $table->timestamps();

            //
            // 外键
            //

            // 分类
            $table->foreign('category_id')->references('id')
                ->on(CreateCategoryTable::$tableName)
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
        Schema::dropIfExists(CreateProductTable::$tableName);
    }
}
