<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('group_id')->unsigned()->nullable();
            $table->integer('board_id')->unsigned()->nullable();
            $table->string('board_name');
            $table->text('description');
            $table->string('buyer_name');
            $table->integer('lane_number')->unsigned();
            $table->date('start_date');
            $table->date('end_date');
            $table->text('meta')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('group_id')
                ->references('id')
                ->on('groups');

            $table->foreign('board_id')
                ->references('id')
                ->on('boards');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function(Blueprint $table) {
            $table->dropForeign('projects_board_id_foreign');
            $table->dropForeign('projects_group_id_foreign');
        });

        Schema::dropIfExists('projects');
    }
}
