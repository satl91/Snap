<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Handles the administrative part of users.
*
* @package		SAAV
* @subpackage	Controllers
* @author		Mario Cuba <mario@mariocuba.net>
*/
class User extends EXT_Controller {
	public function __construct() {
		parent::__construct();

		// load notifications
		$this->_notifications();
	}

	public function index() {

	}

	public function add() {
		if ($this->input->post() != false) {
			$this->presenter->notification->create($this->_add(), 'toast');
		}

		$this->load->presenter('form');
		$this->data->title = 'Agregar Usuario';
	}

	public function companies() {
		$this->data->title = 'Compañías';
	}

	private function _add() {
		$this->load->library('form_validation');

		$firstname	= $this->input->post('firstname');
		$lastname	= $this->input->post('lastname');
		$email		= $this->input->post('email');
		$username	= $this->input->post('username');
		$password	= $this->input->post('password');
		$company	= $this->input->post('company');

		$this->form_validation->set_rules('firstname', 'Nombres', 'required');
		$this->form_validation->set_rules('lastname', 'Apellidos', 'required');
		$this->form_validation->set_rules('email', 'Correo electrónico', 'required');
		$this->form_validation->set_rules('username', 'Nombre de Usuario', 'required');
		$this->form_validation->set_rules('password', 'Contraseña', 'required');
		$this->form_validation->set_rules('company', 'Compañía', 'required');

		// all fields required
		if (!$this->form_validation->run()) {
			return $this->notification->required;
		}

		$this->form_validation->set_rules('email', 'Correo electrónico', 'valid_email');

		// invalid email
		if (!$this->form_validation->run()) {
			return $this->notification->invalidEmail;
		}

		// load the user model, since we'll need it from now on
		$this->load->model('saav_user');

		// username exists
		if ($this->saav_user->match($username, 'username')) {
			return $this->notification->userExists;
		}

		// email exists
		if ($this->saav_user->match($email, 'email')) {
			return $this->notification->emailExists;
		}

		// all good - insert and notify
		$user = array(
			'username'	=> $username,
			'password'	=> hash('sha256', $password),
			'firstname'	=> $firstname,
			'lastname'	=> $lastname,
			'email'		=> $email,
		);

		// user inserted
		if (!$this->saav_user->insert($user)) {
			return $this->notificaton->insertError;
		}

		// insert the company
		$id = $this->saav_user->data('id')->username($username)->get()->id;
		$this->load->model('saav_company_user');

		$company = array(
			'user_id'		=> $id,
			'company_id'	=> $company
		);

		if (!$this->saav_company_user->insert($company)) {
			return $this->notification->insertError;
		}

		// insert the role (by default, client)
		$this->load->model('saav_role_assignment');

		$role = array(
			'role_id'	=> 3,
			'user_id'	=> $id
		);

		if (!$this->saav_role_assignment->insert($role)) {
			return $this->notification->insertError;
		}

		// all good - no values to show again
		$this->form_validation->reset_validation();

		// notify
		return $this->notification->success;

	}

	private function _notifications() {
		$this->notification = new StdClass;
		$this->notification->required = array(
				'status'	=> 'required',
				'message'	=> 'Todos los campos son requeridos',
				'type'		=> 'warning'
			);

		$this->notification->invalidEmail = array(
				'status'	=> 'invalid_email',
				'message'	=> 'Dirección de correo electrónico inválida',
				'type'		=> 'warning'
			);

		$this->notification->userExists = array(
				'status'	=> 'username_exists',
				'message'	=> 'Nombre de usuario ya existe',
				'type'		=> 'warning'
			);

		$this->notification->emailExists = array(
				'status'	=> 'email_exists',
				'message'	=> 'Dirección de correo ya existe',
				'type'		=> 'warning'
			);

		$this->notification->insertError = array(
				'status'	=> 'insert_error',
				'message'	=> 'Error al insertar usuario',
				'type'		=> 'error'
			);

		$this->notification->success = array(
			'status'	=> 'success',
			'message'	=> 'Usuario agregado',
			'type'		=> 'success'
		);
	}
}

/* End of file user.php */
/* Location: ./application/controllers/admin/user.php */