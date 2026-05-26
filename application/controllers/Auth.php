<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');


class Auth extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Api_model');
        header("Content-Type: application/json");

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding, X-Requested-With, Authorization, X-API-KEY");
    }

    public function authenticate(){

        	$username = $this->input->post('username');
        	$password = $this->input->post('password');
    
        	$login = $this->Api_model->doLogin($username, $password);
    
        	if($login){
        		$this->response([
        			'status' => true,
        			'message' => 'Login successful',
        			'data' => $login
        		], REST_Controller::HTTP_OK);
        	} else {
        		$this->response([
        			'status' => false,
        			'message' => 'Invalid username or password'
        		], REST_Controller::HTTP_UNAUTHORIZED);
        	}
    }
}
