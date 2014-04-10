<?php

class UserTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$user = User::create(array('first_name'=> 'Administrator', 'email'=>'admin@admin.com', 'username' => 'admin', 'password'=> Hash::make('admin'),'active'=>1));

		$user->roles()->attach(array(1));
	}

}