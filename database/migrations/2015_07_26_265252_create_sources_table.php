<?php

use App\Source;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSourcesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sources', function(Blueprint $table)
		{	
			$table->increments('id');
			$table->string('name', 100)->unique();
			$table->timestamps();
		});
		factory(App\Source::class)->create(['id'=>1, 'name'=>'Data Entry']);
		factory(App\Source::class)->create(['id'=>2, 'name'=>'Resubs-VzW']);
		factory(App\Source::class)->create(['id'=>3, 'name'=>'Resubs-General']);
		factory(App\Source::class)->create(['id'=>4, 'name'=>'Escalations']);
		factory(App\Source::class)->create(['id'=>5, 'name'=>'QA Review']);

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sources');
	}

}
