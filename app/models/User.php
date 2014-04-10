<?php

use Xtwoend\Database\BaseModel;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends BaseModel implements UserInterface, RemindableInterface {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * Role user 
	 *
	 */
	
	public static $rules = [
		'username' 	=> 'required|unique:users,username,:id',
		'password'	=> 'required',
		'email'		=> 'required|unique:users,email,:id',
	];

	/**
	 * The attributes fillable from the model's JSON form.
	 *
	 * @var array
	 */

	protected $fillable = ['first_name','last_name','username','email','pool_id','active','password'];
	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password'];

	/**
	 * Get the roles user.
	 *
	 * @return mixed
	 */
	public function roles()
    {
        return $this->belongsToMany('Role', 'user_roles', 'user_id', 'role_id');
    }

    /**
	 * Get the Pool user.
	 *
	 * @return mixed
	 */
	public function pool()
    {
       	return $this->belongsTo('Pool');
    }

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

}