<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Suppliers extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->model('supplier');

		$this->isLoggedIn = $this->session->userdata('isLoggedIn');
	}

	public function index(){
		if($this->isLoggedIn){
			redirect('suppliers/view');
		}else{
			redirect('users/login');
		}
	}

	public function view(){
		$data = array();
		$data['session_user'] = $this->session->userdata('username');
		$this->load->view('components/header', $data);
		$this->load->view('suppliers/view', $data);
		$this->load->view('components/footer');
	}

}