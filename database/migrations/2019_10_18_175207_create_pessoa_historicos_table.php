<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePessoaHistoricosTable.
 */
class CreatePessoaHistoricosTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pessoa_historicos', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('pessoa_id')->unsigned();
            $table->foreign('pessoa_id')->references('id')->on('pessoas');
            $table->integer('historico_id')->unsigned();
            $table->foreign('historico_id')->references('id')->on('historicos')->onDelete('cascade');
		});
	}

	public function down()
	{
		Schema::drop('pessoa_historicos');
	}
}
