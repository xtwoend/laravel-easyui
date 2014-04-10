<?php
	/*
	|--------------------------------------------------------------------------
	| Auth Controller
	|--------------------------------------------------------------------------
	| Controller untuk login dan logout serta update password 
	|
	| @author     Abdul Hafidz Anhsari
 	| @since      02/04/2014
 	| @version    0.1
 	| @category   Application
 	| @package    Default
 	| @subpackage Controller
	|
	*/

class AuthController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('auth.login');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$user = [
				'username' 	=> Input::get('username'),
				'password'	=> Input::get('password')
		];
		
		if (Auth::attempt($user, Input::get('remember', false)))  {
        	
        	$user = Auth::user();
        	$user->last_login = date('Y-m-d H:i:s');
        	$user->save();
        	return Redirect::to('/');
        }

        return Redirect::to('auth')->with('error-message', 'gagal login');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	/**
	 * Logout System
	 * remove session user
	 *
	 */

	public function logout()
	{
		Auth::logout();
		return Redirect::to('auth');
	}

}