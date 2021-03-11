<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateReciboControlesTable.
 */
class CreateReciboControlesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('recibo_controles', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('contas_receber_id')->unsigned();
            $table->foreign('contas_receber_id')->references('id')->on('contas_recebers');

            $table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('recibo_controles');
	}
}
