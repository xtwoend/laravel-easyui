<?php

class MenuTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Menu::create(array('id'=> 1, 'title' => 'User Manager', 'url'=> '#', 'role_id' => 1, 'parent' => 0));
		Menu::create(array('id'=> 2, 'title' => 'Users', 'url'=> 'users', 'role_id' => 1, 'parent' => 1));
		Menu::create(array('id'=> 3, 'title' => 'Role', 'url'=> 'roles', 'role_id' => 1, 'parent' => 1));
		Menu::create(array('id'=> 4, 'title' => 'Setting', 'url'=> '#', 'role_id' => 1, 'parent' => 0));
		Menu::create(array('id'=> 5, 'title' => 'Menu Manager', 'url'=> 'menu', 'role_id' => 1, 'parent' => 4));
	}

}