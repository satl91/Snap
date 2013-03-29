<?php

/**
* Ticket model
*
* @package		SAAV
* @subpackage	Controllers
* @author		Mario Cuba <mario@mariocuba.net>
*/
class Ticket extends Eloquent {
	public static $timestamps = true;

	public function messages() {
		return $this->has_many('Message');
	}
}