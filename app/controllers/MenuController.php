<?php
	
	/*
	|--------------------------------------------------------------------------
	| Menu Controller
	|--------------------------------------------------------------------------
	| Controller mecreate menu dan level menu 
	|
	| @author     Abdul Hafidz Anhsari
 	| @since      02/04/2014
 	| @version    0.1
 	| @category   Application
 	| @package    Default
	|
	*/

class MenuController extends \BaseController {

	private $menu;


	public function __construct(Menu $menus)
	{
		$this->menu = $menus;
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('menus.index');
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
		$success = false;
		$message = '';

		$input 	= Input::all();
		
		$this->menu->fill($input);
		
		if (!$this->menu->validate()) {
            // if not validate, return flaseh error message
           	return array(
                    'success'   => false,
                    'data'      => '',
                    'message'   => 'Gagal di tambahkan',
                    'code'      => 500
                );
        }

        // save jobtitle to database
        if ($this->menu->save()) {
        	return array(
                    'success'   => true,
                    'data'      => '',
                    'message'   => 'Berhasil di tambahkan',
                    'code'      => 200
                );
        }		
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
	public function edit($id=null)
	{	
		if(null == $id) $id = Input::get('id');

		return $this->menu->find($id);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id=null)
	{	
		$success = false;
		$message = '';

		if(null == $id) $id = Input::get('id');
		
		$menu = $this->menu->find($id);
		$menu->fill(Input::all());

		if (!$menu->validate()) {
            // if not validate, return flaseh error message
            $success = false;
        	$message = 'Menu gagal di ubah';
        }

        if($menu->save()){
        	$success = true;
        	$message = 'Menu berhasil di ubah';
        }

        return array(
                    'success'   => $success,
                    'data'      => '',
                    'message'   => $message,
                    'code'      => $success ? 200 : 500
                );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{	
		$success = false;
		$message = '';

		if($this->menu->find($id)->delete()) {
			$success = true;
			$message = 'Menu berhasil di hapus !';
		}
		return array(
                    'success'   => $success,
                    'data'      => '',
                    'message'   => $message,
                    'code'      => $success ? 200 : 500
                );
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

		$menus = $this->menu->orderBy($sort, $order);

		$count = $menus->count();

		if( $count > 0 ) {
        	$total_pages = ceil($count / $limit);
      	} else {
        	$total_pages = 0;
      	} 
      	if ($page > $total_pages) $page = $total_pages;
      	$start = $limit * $page - $limit; 
      	if($start < 0) $start = 0;

      	$rows = array();
      	foreach ( $menus->skip($start)->take($limit)->get() as $m) {
      		$rows[] = ['id'=> $m->id, 'title' => $m->title, 'url' => $m->url, 'role_id' => $m->role->name, 'parent' => $m->parent ]; 
      	}

      	$responce['total'] = $count;
      	$responce['rows'] = $rows;

		return $responce;	
	}

	/**
	 * Create menu tree
	 * 
	 * @param int $id method post
	 * @return array
	 */
	public function tree()
	{	
		$roles = array();

		foreach (Auth::user()->roles as $role) {
			array_push($roles,$role->id);
		}
		
		$id = Input::get('id', 0);

		$menu = $this->menu->where('parent','=', $id)->whereIn('role_id', $roles)->get();
		$result = array();

		foreach ($menu as $m) {
			
			$link = $m->title;

			if(! $this->_has_child( $m->id )){
				$link  = '<a ';
				$link .= 'href="#" ';
				$link .= 'onClick="loadContent(\''. $m->title .'\',\''. $m->url .'\')">';
				$link .= $m->title;
				$link .= '</a>';
			}

			$node = array();
			$node['id'] = $m->id;
		    $node['text'] = $link;
		    $node['state'] = $this->_has_child($m->id) ? 'closed' : 'open';
		    array_push($result,$node);
		}

		return $result;
	}

	/**
	 * Check Child Menu
	 * 
	 * @param int $id
	 * @return bolean
	 */
	private function _has_child($id)
	{	
		$child = $this->menu->where('parent','=',$id)->count();

	    return $child > 0 ? true : false;
	}
}