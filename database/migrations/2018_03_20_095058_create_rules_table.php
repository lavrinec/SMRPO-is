<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rules', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('old_column_id')->unsigned();
            $table->integer('new_column_id')->unsigned();
            $table->integer('role_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('old_column_id')
                ->references('id')
                ->on('columns');

            $table->foreign('new_column_id')
                ->references('id')
                ->on('columns');

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
        Schema::table('rules', function(Blueprint $table) {
            $table->dropForeign('rules_old_column_id_foreign');
            $table->dropForeign('rules_new_column_id_foreign');
            $table->dropForeign('rules_role_id_foreign');
        });
        Schema::dropIfExists('rules');
    }
}
