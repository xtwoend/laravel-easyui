<?php
use Xtwoend\Database\BaseModel;

class Menu extends BaseModel {

	public static $rules = [
		'title' 	=> 'required|unique:menus,title,:id',
		//'url'		=> 'required|unique:menus,url,:id',
		'role_id'	=> 'required|exists:roles,id',
	];

	// Don't forget to fill this array
	protected $fillable = ['title','url','role_id','parent'];

	protected $guarded  = [];

	public function role()
    {
        return $this->belongsTo('Role','role_id');
    }
}