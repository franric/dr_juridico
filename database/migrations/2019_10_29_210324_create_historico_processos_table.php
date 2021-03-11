<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateHistoricoProcessosTable.
 */
class CreateHistoricoProcessosTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('historico_processos', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('contrato_id')->unsigned();
            $table->foreign('contrato_id')->references('id')->on('contratos')->onDelete('cascade');
            $table->string('titulo', 100)->nullable();
            $table->string('tarefa', 100)->nullable();
            $table->date('dataTarefa')->nullable();
            $table->time('horaTarefa')->nullable();
            $table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('historico_processos');
	}
}
