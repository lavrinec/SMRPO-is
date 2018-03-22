<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('moves', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('old_column_id')->unsigned();
            $table->integer('new_column_id')->unsigned();
            $table->integer('card_id')->unsigned();
            $table->integer('old_order')->unsigned();
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

            $table->foreign('card_id')
                ->references('id')
                ->on('cards');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('moves', function(Blueprint $table) {
            $table->dropForeign('moves_user_id_foreign');
            $table->dropForeign('moves_old_column_id_foreign');
            $table->dropForeign('moves_new_column_id_foreign');
            $table->dropForeign('moves_card_id_foreign');
        });
        Schema::dropIfExists('moves');
    }
}
