<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('card_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('task_name');
            $table->text('description');
            $table->boolean('is_finished');
            $table->integer('order')->unsigned();
            $table->decimal('estimation');
            $table->text('meta')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('card_id')
                ->references('id')
                ->on('cards');

            $table->foreign('user_id')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function(Blueprint $table) {
            $table->dropForeign('tasks_user_id_foreign');
            $table->dropForeign('tasks_card_id_foreign');
        });
        Schema::dropIfExists('tasks');
    }
}
