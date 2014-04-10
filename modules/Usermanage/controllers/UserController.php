<?php

// uncomment this to use namespaced controller
//namespace Modules\Usermanage\Controllers;

class UserController extends \BaseController
{	

	private $model;


	public function __construct(User $users)
	{
		$this->model = $users;
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('usermanage::users');
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
		$responce = array(
				'success' => false,
				'message' => '',
				'data'	  => '',
		);

		$input 	= Input::all();
		$input['password'] 	=  Hash::make($input['password']);
		$input['active']	=  (Input::get('active',false))? 1: 0;

		$this->model->fill($input);
		if (!$this->model->validate()) {
           	$responce['message'] = 'Data gagal di simpan';
           	return $responce;
        }

        if($this->model->save()){
        	if(Input::get('roles', false)){
	        	$this->model->roles()->detach();
	        	$this->model->roles()->attach($input['roles']);
	        }
        }        

        $responce['success'] = true;
        $responce['message'] = 'Data berhasil di simpan';
        return $responce;
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
	public function edit($id = null)
	{	
		$responce = array(
				'success' => false,
				'message' => '',
				'data'	  => '',
		);
		
		if(null == $id) $id = Input::get('id');
		if($this->model->find($id)){
			$roles = array();
			foreach ($this->model->find($id)->roles as $role) {
				array_push($roles,$role->slug);
			}
			$responce['data'] = array('user'=>$this->model->find($id)->toArray(), 'roles'=> $roles);
			$responce['success'] = true;
			$responce['message'] = 'data found!';
		}
		return $responce;
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id=null)
	{
		$responce = array(
				'success' => false,
				'message' => 'data gagal di rubah',
				'data'	  => '',
		);
		
		if(null == $id) $id = Input::get('id');
		$input = Input::all();
		$input['active']	=  (Input::get('active',false))? 1: 0;
		if(! Input::get('password', false)){
			unset($input['password']);
		}else{
			$input['password'] = Hash::make($input['password']);
		}

		$model = $this->model->find($id);
		$model->fill($input);
		if($model->save()){
			if(Input::get('roles', false)){
				$model->roles()->detach();
		        $model->roles()->attach($input['roles']);  
		    }
			$responce['success'] = true;
			$responce['message'] = 'data berhasil di ubah';
		}
		return $responce;
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$responce = array(
				'success' => false,
				'message' => '',
				'data'	  => '',
		);

		if($this->model->find($id)->delete()) {
			$responce['success'] = true;
			$responce['message'] = 'removed!';
			return $responce;
		}
		$responce['message'] = 'remove failed!';
		return $responce; 
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  
	 * @return Response
	 */
	public function info()
	{
		$user = Auth::user();

		return View::make('usermanage::info',array('user'=>$user));
	}


	/**
	 * Menu to Grid data
	 * 
	 * @param int , [ rows, page]
	 * @return json
	 */
	
	public function grid()
	{
		$page = Input::get('page', 1);
		$limit = Input::get('rows', 10);
		
		$sort = Input::get('sort', 'id');
		$order = Input::get('order', 'asc');

		$model = $this->model->orderBy($sort, $order);

		$count = $model->count();

		if( $count > 0 ) {
        	$total_pages = ceil($count / $limit);
      	} else {
        	$total_pages = 0;
      	} 
      	if ($page > $total_pages) $page = $total_pages;
      	$start = $limit * $page - $limit; 
      	if($start < 0) $start = 0;

      	$rows = array();
      	foreach ( $model->skip($start)->take($limit)->get() as $m) {
      		$rows[] = ['id'=> $m->id, 'first_name' => $m->first_name .' '.$m->last_name , 'username' => $m->username,'email' => $m->email, 'last_login' => $m->last_login, 'active' => ($m->active)?'<i class="fa fa-check-square"></i>':'<i class="fa fa-times-circle"></i>' ]; 
      	}

      	$responce['total'] = $count;
      	$responce['rows'] = $rows;

		return $responce;	
	}

	/**
     * API for model field frontend validation
     * @return json
     */
    public function validateField() {
        // get field to validate
        $field = key(Input::query());

        // create validator
        $validator = Validator::make(Input::all(), User::$rules);
        $messages = $validator->messages();
        if ($messages->has($field))
        {
            // return error message
            //return json_encode(array("error"=>$messages->first($field)));
        	return Response::make(array("error"=>$messages->first($field)), 404);
        } 

        return Response::make(array(),200);
    }

}