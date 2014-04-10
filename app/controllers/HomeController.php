<?php
	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	| Default Controller after login 
	|
	| @author     Abdul Hafidz Anhsari
 	| @since      02/04/2014
 	| @version    0.1
 	| @category   Application
 	| @package    Default
	|
	*/

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	*/

	public function index()
	{
		return View::make('home');
	}

	public function dash()
	{
		return View::make('dash');
	}

}