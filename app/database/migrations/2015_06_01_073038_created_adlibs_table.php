<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatedAdlibsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
        Schema::create('adlibs', function(Blueprint $table) {
            $table->increments('id');
            $table->text('text');
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
        Schema::drop('adlibs');
    }

}
