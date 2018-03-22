<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersGroupsRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_groups_roles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('users_group_id')->unsigned();
            $table->integer('role_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('users_group_id')
                ->references('id')
                ->on('users_groups');

            $table->foreign('role_id')
                ->references('id')
                ->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_groups_roles', function(Blueprint $table) {
            $table->dropForeign('users_groups_roles_users_group_id_foreign');
            $table->dropForeign('users_groups_roles_role_id_foreign');
        });
        Schema::dropIfExists('users_groups_roles');
    }
}
