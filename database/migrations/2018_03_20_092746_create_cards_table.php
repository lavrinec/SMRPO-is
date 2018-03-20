<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('column_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('move_reason_id')->unsigned();
            $table->string('card_name');
            $table->text('description');
            $table->integer('order')->unsigned();
            $table->boolean('is_silver_bullet');
            $table->boolean('is_critical');
            $table->boolean('is_rejected');
            $table->date('deadline');
            $table->string('label');
            $table->string('color');
            $table->decimal('estimation');
            $table->text('meta')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('column_id')
                ->references('id')
                ->on('columns');

            $table->foreign('move_reason_id')
                ->references('id')
                ->on('move_reasons');

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
        Schema::table('cards', function(Blueprint $table) {
            $table->dropForeign('cards_user_id_foreign');
            $table->dropForeign('cards_move_reason_id_foreign');
            $table->dropForeign('cards_column_id_foreign');
        });

        Schema::dropIfExists('cards');
    }
}
