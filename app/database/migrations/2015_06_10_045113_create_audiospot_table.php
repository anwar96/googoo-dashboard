<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAudiospotTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('audiospots', function (Blueprint $table) {
            $table->increments('id');
            $table->text('text');
            $table->enum('type', array('event', 'genre'));
            $table->string('genre');
            $table->enum('status', array('active', 'nonactive'));
            $table->integer('count');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('audiospots');
    }

}
