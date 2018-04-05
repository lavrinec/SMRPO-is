<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCardIdToWipViolation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wip_violations', function($table) {
            $table->integer('card_id')->unsigned()->nullable();

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
        Schema::table('wip_violations', function(Blueprint $table) {
            $table->dropForeign('wip_violations_card_id_foreign');
        });
    }
}
