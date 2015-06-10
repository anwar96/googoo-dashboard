<?php

use Illuminate\Database\Migrations\Migration;

class AddTypeColumnAdlibsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('adlibs', function ($table) {
            $table->enum('type', array('event', 'genre'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
    }

}
