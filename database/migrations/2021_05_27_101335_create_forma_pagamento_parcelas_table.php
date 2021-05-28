<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateFormaPagamentoParcelasTable.
 */
class CreateFormaPagamentoParcelasTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('forma_pagamento_parcelas', function(Blueprint $table) {

            $table->integer('parcela_id')->unsigned();
            $table->foreign('parcela_id')->references('id')->on('contas_recebers');

            $table->integer('forma_pagamento_id')->unsigned();
            $table->foreign('forma_pagamento_id')->references('id')->on('forma_pagamentos');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('forma_pagamento_parcelas');
	}
}
