<?php

Route::group(array('prefix'	=>	'usermanage'), function(){
	
	Route::get('/', 'UsermanageController@index');
	
});

Route::group(array('before' => 'auth'), function()
{	
	Route::group(array('prefix'	=>	'users'), function(){
		Route::get('info', array('as'=>'users.info', 'uses'=>'UserController@info'));
	});
	
	Route::get('api/users', array('as'=>'api.users', 'uses'=>'UserController@grid'));
	Route::get('api/users/getbyid', array('as'=>'api.users.getbyid', 'uses'=>'UserController@edit'));
	Route::get('api/users/validate', array('as'=>'api.users.validate', 'uses'=>'UserController@validateField'));
	Route::resource('users','UserController');

	Route::get('api/roles', array('as'=>'api.roles', 'uses'=>'RoleController@grid'));
	Route::get('api/roles/getbyid', array('as'=>'api.roles.getbyid', 'uses'=>'RoleController@edit'));
	Route::get('api/roles/validate', array('as'=>'api.roles.validate', 'uses'=>'RoleController@validateField'));
	Route::resource('roles','RoleController');
});