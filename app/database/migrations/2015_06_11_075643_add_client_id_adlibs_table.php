<?php

use Illuminate\Database\Migrations\Migration;

class AddClientIdAdlibsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('adlibs', function ($table) {
            $table->unsignedInteger('client_id');

            $table->foreign('client_id')
            ->references('id')->on('clients')
            ->onDelete('cascade');
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
