<?php

/**
* User model
*
* @package		SAAV
* @subpackage	Models
* @author		Mario Cuba <mario@mariocuba.net>
*/
class User extends Eloquent {
	public static $timestamps = true;

	/** 
	* An user can belong to different departments, and 
	* a department can have a lot of users
	*/
	public function department() {
		return $this->has_many_and_belongs_to('Department', 'department_members');
	}

	/**
	* An user can have many messages in tickets
	*/
	public function messages() {
		return $this->has_many('Message');
	}
}