<?php 

// uncomment this to use namespaced migration
//namespace Modules\usermanage\Database\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		\Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 50);
			$table->string('username', 50);
			$table->string('email', 50);
			$table->string('password', 255);
			$table->datetime('last_login');
			$table->integer('active');
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
		\Schema::drop('users');
	}

}
