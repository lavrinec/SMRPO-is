<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColumnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('columns', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('board_id')->unsigned();
            $table->integer('parent_id')->unsigned()->nullable();
            $table->string('column_name');
            $table->text('description');
            $table->integer('order')->unsigned();
            $table->integer('WIP')->unsigned();
            $table->boolean('start_border');
            $table->boolean('end_border');
            $table->boolean('high_priority');
            $table->boolean('acceptance_testing');
            $table->text('meta')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('board_id')
                ->references('id')
                ->on('boards');

            $table->foreign('parent_id')
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
            $table->dropForeign('columns_board_id_foreign');
            $table->dropForeign('columns_parent_id_foreign');
        });

        Schema::dropIfExists('columns');
    }
}
