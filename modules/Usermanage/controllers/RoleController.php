<?php

// uncomment this to use namespaced controller
//namespace Modules\Usermanage\Controllers;

class RoleController extends \BaseController
{
	private $model;


	public function __construct(Role $roles)
	{
		$this->model = $roles;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('usermanage::roles');
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
				'data'	  => ''
		);

		$this->model->fill(Input::all());
		if (!$this->model->validate()) {   
           $responce['message'] = 'Data gagal di simpan';
           return $responce;
        }

        $this->model->save();
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
			$responce['data'] = $this->model->find($id)->toArray();
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
	public function update($id)
	{	
		$responce = array(
				'success' => false,
				'message' => '',
				'data'	  => '',
		);
		$model = $this->model->find($id);
		$model->fill(Input::all());
		if (!$model->validate()) {   
           $responce['message'] = 'Gagal di simpan';
           return $responce;
        }
        $model->save();
        $responce['success'] = true;
        $responce['message'] = 'Berhasil di simpan';
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
      		$rows[] = ['id'=> $m->id, 'slug' => $m->slug, 'name' => $m->name]; 
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
        $validator = Validator::make(Input::all(), Role::$rules);
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