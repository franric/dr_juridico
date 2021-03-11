<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePessoasTable.
 */
class CreatePessoasTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pessoas', function(Blueprint $table) {

            $table->increments('id');
            $table->integer('tipoPessoa');
            $table->string('nomeRazaoSocial', 100);
            $table->string('nacionalidade', 30)->nullable();
            $table->string('estadoCivil', 30)->nullable();
            $table->string('profissao', 50)->nullable();
            $table->string('rg', 10)->nullable();
            $table->string('cpfCnpj', 20)->unique();
            $table->string('ctps', 15)->nullable();
            $table->string('email', 50)->nullable();
            $table->dateTime('dataNascimento')->nullable();
            $table->string('orgExpedidor', 10)->nullable();
            $table->string('ufOrgExpedidor', 2)->nullable();
            $table->string('nire', 20)->nullable();
            $table->string('inscEstatual', 15)->nullable();
            $table->string('inscMunicipal', 15)->nullable();
            $table->string('logradouro', 50);
            $table->string('numero', 10);
            $table->string('complemento', 50)->nullable();
            $table->string('bairro', 30);
            $table->string('cep', 8)->nullable();
            $table->string('cidade', 30);
            $table->string('estado', 20);
            $table->string('telefone', 10)->nullable();
            $table->string('celUm', 11);
            $table->string('celDois', 11)->nullable();
            $table->string('celTres', 11)->nullable();
            $table->string('nomeRepresentante', 100)->nullable();
            $table->string('nacionalidadeRepresentante', 30)->nullable();
            $table->string('estadoCivilRepresentante', 30)->nullable();
            $table->string('profissaoRepresentante', 50)->nullable();
            $table->string('rgRepresentante', 10)->nullable();
            $table->string('cpfRepresentante', 15)->nullable();
            $table->string('ctpsRepresentante', 15)->nullable();
            $table->string('emailRepresentante', 50)->nullable();
            $table->dateTime('dataNascimentoRepresentante')->nullable();
            $table->string('orgExpedidorRepresentante', 10)->nullable();
            $table->string('ufOrgExpedidorRepresentante', 2)->nullable();
            $table->string('logradouroRepresentante', 50)->nullable();
            $table->string('numeroRepresentante', 10)->nullable();
            $table->string('complementoRepresentante', 50)->nullable();
            $table->string('bairroRepresentante', 30)->nullable();
            $table->string('cepRepresentante', 8)->nullable();
            $table->string('cidadeRepresentante', 30)->nullable();
            $table->string('estadoRepresentante', 20)->nullable();
            $table->integer('status')->default(1);

            //$table->softDeletes();
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
		Schema::drop('pessoas');
	}
}
