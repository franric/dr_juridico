<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateProcuracaosTable.
 */
class CreateProcuracaosTable extends Migration
{
	
	public function up()
	{
		Schema::create('procuracaos', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('pessoa_id')->unsigned();
            $table->foreign('pessoa_id')->references('id')->on('pessoas')->onDelete('cascade');
            $table->integer('tipo');
            $table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('procuracaos');
	}
}
