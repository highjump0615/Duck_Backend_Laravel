<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRoleToUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(CreateUsersTable::$tableName, function (Blueprint $table) {
        $table->unsignedInteger('role_id')->comment('角色');

        // 外键
        $table->foreign('role_id')->references('id')
            ->on(CreateRoleTable::$tableName)
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
        Schema::table(CreateUsersTable::$tableName, function (Blueprint $table) {
            $table->dropForeign(CreateOrderTable::$tableName.'_role_id_foreign');
            $table->dropColumn('role_id');
        });
    }
}
