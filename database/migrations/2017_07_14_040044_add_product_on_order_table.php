<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProductOnOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(CreateOrderTable::$tableName, function (Blueprint $table) {
            $table->unsignedInteger('product_id')->comment('商品');
            $table->unsignedInteger('spec_id')->nullable()->comment('规格');

            // 外键
            $table->foreign('product_id')->references('id')
                ->on(CreateProductTable::$tableName)
                ->onUpdate('cascade')
                ->onDelete('cascade');

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

        Schema::table(CreateOrderTable::$tableName, function (Blueprint $table) {
            $table->dropForeign('orders_product_id_foreign');
            $table->dropForeign('orders_spec_id_foreign');
            $table->dropColumn('product_id');
            $table->dropColumn('spec_id');
        });
    }
}
