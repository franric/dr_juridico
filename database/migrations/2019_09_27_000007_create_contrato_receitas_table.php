<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateContratoReceitasTable.
 */
class CreateContratoReceitasTable extends Migration
{

	public function up()
	{
		Schema::create('contrato_receitas', function(Blueprint $table) {

            $table->integer('contrato_id')->unsigned();
            $table->foreign('contrato_id')->references('id')->on('contratos');

            $table->integer('receita_id')->unsigned();
            $table->foreign('receita_id')->references('id')->on('receitas');

            $table->decimal('valorReceita');

		});
	}

	public function down()
	{
		Schema::drop('contrato_receitas');
	}
}
