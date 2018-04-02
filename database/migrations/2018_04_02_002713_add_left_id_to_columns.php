<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLeftIdToColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('columns', function($table) {
            $table->integer('left_id')->unsigned()->nullable();

            $table->foreign('left_id')
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
        Schema::table('columns', function(Blueprint $table) {
            $table->dropForeign('columns_left_id_foreign');
            $table->dropColumn('left_id');
        });
    }
}
