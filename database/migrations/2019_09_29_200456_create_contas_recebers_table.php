<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateContasRecebersTable.
 */
class CreateContasRecebersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contas_recebers', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('contrato_id')->unsigned();
            $table->foreign('contrato_id')->references('id')->on('contratos');
            $table->integer('tipoPagamento');
            $table->decimal('valorParcela', 10);
            $table->decimal('valorRecebido', 10)->nullable();
            $table->date('dataVencimento');
            $table->date('dataRecebimento')->nullable();
            $table->integer('numeroParcela');
            $table->integer('statusRecebimento');

            $table->timestamps();

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('contas_recebers');
	}
}
