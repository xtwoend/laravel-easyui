<?php

class RoleTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Role::create(array('name' => 'Adminstrator', 'slug'=> 'administrator'));
	}

}