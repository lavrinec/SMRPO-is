<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNullableToCards extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cards', function($table) {
            $table->integer('user_id')->unsigned()->nullable()->change();
            $table->integer('order')->unsigned()->default(0)->change();
            $table->boolean('is_silver_bullet')->default(false)->change();
            $table->boolean('is_critical')->default(false)->change();
            $table->boolean('is_rejected')->default(false)->change();
            $table->date('deadline')->nullable()->change();
            $table->string('label')->default("")->change();
            $table->string('color')->default("")->change();
            $table->decimal('estimation')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
