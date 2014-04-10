<?php

use Xtwoend\Database\BaseModel;

class Role extends BaseModel
{
	/**
	 * Rule Role 
	 *
	 */
	
	public static $rules = [
		'slug' 	=> 'required|unique:roles,slug,:id',
		'name'	=> 'required',
	];

	/**
	 * The attributes fillable from the model's JSON form.
	 *
	 * @var array
	 */

	protected $fillable = ['slug','name'];
	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [];


	public function users()
    {
        return $this->belongsToMany('User', 'user_roles', 'user_id', 'role_id');
    }
}