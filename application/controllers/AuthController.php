<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AuthController extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->model('CrudModel', "crud");
		// $this->class->yourfnc();



	}

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *        
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */




	public function validate_route($route)
	{
		if (isset($route)) {
			$this->load->view('./modules/admin_dashboard');
			return;
		}
		if ($route == "crud") {
			$this->load->view('./modules/admin_dashboard');
		}
	}



	public function redirect()
	{

		// ## With Model ####
		// $result['data']=$this->CrudModel->display_record();

		// ## Without Model ####
		$route = $this->uri->segment(1);
		$result['data'] = $this->db->select('*')
			->from('payment_transaction')
			->get()->result_array();
		$result['route'] = $route;
		$this->load->view('index', $result);
	}



	
}