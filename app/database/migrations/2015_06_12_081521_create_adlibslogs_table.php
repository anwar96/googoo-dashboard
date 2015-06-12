<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAdlibslogsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('adlibslogs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('adlibs_id');

            $table->foreign('adlibs_id')
            ->references('id')->on('adlibs')
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
        Schema::drop('adlibslogs');
    }

}
