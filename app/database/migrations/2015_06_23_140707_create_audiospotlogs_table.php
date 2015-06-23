<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAudiospotlogsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
        Schema::create('audiospotlogs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('audiospot_id');

            $table->foreign('audiospot_id')
            ->references('id')->on('audiospots')
            ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('audiospotlogs');
    }

}
