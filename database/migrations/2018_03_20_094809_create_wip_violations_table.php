<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWipViolationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wip_violations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('old_column_id')->unsigned();
            $table->integer('new_column_id')->unsigned();
            $table->string('reason');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->foreign('old_column_id')
                ->references('id')
                ->on('columns');

            $table->foreign('new_column_id')
                ->references('id')
                ->on('columns');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wip_violations', function(Blueprint $table) {
            $table->dropForeign('wip_violations_user_id_foreign');
            $table->dropForeign('wip_violations_old_column_id_foreign');
            $table->dropForeign('wip_violations_new_column_id_foreign');
        });
        Schema::dropIfExists('wip_violations');
    }
}
