<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateHistoricosTable.
 */
class CreateHistoricosTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('historicos', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('contrato_id')->unsigned()->nullable();
            $table->foreign('contrato_id')->references('id')->on('contratos');
            $table->text('historico');

            $table->timestamps();
		});
	}


	public function down()
	{
		Schema::drop('historicos');
	}
}
