<?php

defined('BASEPATH') or exit('No direct script access allowed');


class Auth extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Auth_Model' , 'Auth');
		header("Content-Type: application/json");

		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding, X-Requested-With, Authorization, X-API-KEY");
	}

	public function authenticate()
	{
		$stream = json_decode($this->input->raw_input_stream, true);
		$username = $stream['username'] ?? $this->input->post('username');
		$password = $stream['password'] ?? $this->input->post('password');

		$login = $this->Auth->doLogin($username, $password);

		if ($login) {
			// Load session library for login
			$this->load->library('session');
			
			$user_id = is_object($login) ? ($login->id ?? null) : ($login['id'] ?? null);
			$session_data = [
				'user_id' => $user_id,
				'username' => $username,
				'logged_in' => TRUE
			];
			$this->session->set_userdata($session_data);
			$session_id = $this->session->session_id;

			$response = [
				'status' => true,
				'message' => 'Login successful',
				'session_id' => $session_id,
				'data' => $login
			];
			$status_code = 200;
		} else {
			$response = [
				'status' => false,
				'message' => 'Invalid username or password',
				'data' => []
			];
			$status_code = 401;
		}

		// Output clean JSON native response
		$this->output
			->set_status_header($status_code)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES))
			->_display();
		exit;
	}


}
