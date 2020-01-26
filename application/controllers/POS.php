<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class POS extends CI_Controller {

	public function __construct(){
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->model('user');

		$this->isLoggedIn = $this->session->userdata('isLoggedIn');
		$this->LOGIN_MAX_RETRY = 3;
	}

	public function index(){
		if($this->isLoggedIn){
			redirect('pos/dashboard');
		}else{
			redirect('users/login');
		}
	}

	public function dashboard(){
		$data = array();
		$data['session_user'] = $this->session->userdata('username');
		
		$this->load->view('pos/dashboard', $data);
		
	}

}
