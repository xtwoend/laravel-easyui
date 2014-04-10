<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::group(array('before' => 'guest'), function()
{
	Route::resource('auth', 'AuthController');
});



Route::group(array('before' => 'auth'), function()
{
	Route::get('/', 'HomeController@index');
	Route::get('logout', array('as'=>'logout', 'uses'=>'AuthController@logout'));

	/* Dash Route */
	Route::get('dash', array('as'=>'dash', 'uses'=>'HomeController@dash'));

	/* menu manage */
	Route::resource('menu', 'MenuController');
	Route::post('api/menu/tree', array('as'=>'api.menu.tree', 'uses'=>'MenuController@tree'));
	Route::get('api/menus', array('as'=>'api.menus', 'uses'=>'MenuController@grid'));
	Route::post('api/menu/store', array('as'=>'api.menu.store', 'uses'=>'MenuController@store'));
	Route::get('api/menu/getbyid', array('as'=>'api.menu.getbyid', 'uses'=>'MenuController@edit'));	
	Route::put('api/menu/update', array('as'=>'api.menu.update', 'uses'=>'MenuController@update'));

	/* Docs Reader */
	Route::get('docs/{chapter?}', array('as'=>'docs', 'uses'=>'DocsController@read'));
});


