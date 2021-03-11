<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateContratosTable.
 */
class CreateContratosTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contratos', function(Blueprint $table) {

            $table->increments('id');
            $table->integer('numContrato');
            $table->string('objetoContrato', 100);
            $table->string('valorExteContrato', 155);
            $table->string('valorExteEntContrato', 155);
            $table->string('comarcaCidadeContrato', 30);
            $table->string('comarcaEstadoContrato', 30);
            $table->datetime('dataVencContrato');
            $table->decimal('valorContrato', 10);
            $table->decimal('valorEntradaContrato', 10);
            $table->integer('numParcelaContrato');
            $table->integer('statusContrato');
            $table->datetime('dataBaixaContrato')->nullable();

            $table->timestamps();
			$table->softDeletes();

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('contratos');
	}
}
