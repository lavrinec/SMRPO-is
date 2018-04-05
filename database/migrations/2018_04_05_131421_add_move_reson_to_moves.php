<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoveResonToMoves extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('moves', function($table) {
            $table->integer('move_reason_id')->unsigned()->nullable();

            $table->foreign('move_reason_id')
                ->references('id')
                ->on('move_reasons');
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
            $table->dropForeign('moves_move_reason_id_foreign');
        });
    }
}
