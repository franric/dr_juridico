<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReciboQuitacaoControlhesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recibo_quitacao_controlhes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contrato_id')->unsigned();
            $table->foreign('contrato_id')->references('id')->on('contratos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recibo_quitacao_controlhes');
    }
}
