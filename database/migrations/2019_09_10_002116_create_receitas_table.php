<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateReceitasTable.
 */
class CreateReceitasTable extends Migration
{
	public function up()
	{
		Schema::create('receitas', function(Blueprint $table) {
			
			$table->increments('id');
            $table->string('descricao', 50)->unique();
            $table->decimal('valor');

            $table->timestamps();
            $table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('receitas');
	}
}
