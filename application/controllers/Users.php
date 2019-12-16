<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Users extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->model('user');

		$this->isLoggedIn = $this->session->userdata('isLoggedIn');
		$this->LOGIN_MAX_RETRY = 3;
	}

	public function index(){
		if($this->isLoggedIn){
			redirect('users/dashboard');
		}else{
			redirect('users/login');
		}
	}

	public function login(){
		$data = array();

		if($this->session->userdata('success_msg')){
			$data['success_msg'] = $this->session->userdata('success_msg');
			$this->session->unset_userdata('success_msg');
		}
		if($this->session->userdata('error_msg')){
			$data['error_msg'] = $this->session->userdata('error_msg');
			$this->session->unset_userdata('error_msg');
		}

		if($this->input->post('loginSubmit')){
			$this->form_validation->set_rules('username', 'Username', 'required|trim');
			$this->form_validation->set_rules('password', 'Password', 'required|trim');

			if($this->form_validation->run() == true){
				$con = array(
					'returnType' => 'single',
					'conditions' => array(
						'username' => strtoupper($this->input->post('username'))
					)
				);
				$checkLogin = $this->user->getRows($con);
				if($checkLogin){
					if($checkLogin['STATUS'] === 'Locked'){
						$data['error_msg'] = 'User is locked.';

					}elseif($checkLogin['STATUS'] === 'Active' || $checkLogin['STATUS'] === 'New'){
						if(password_verify($this->input->post('password'), $checkLogin['PASSWORD'])){
							$loginUpdt = array(
								'retry_cnt' => 0,
								'status' => 'Active',
								'last_login_dt' => date("Y-m-d H:i:s")
							);
							$this->session->set_userdata('isLoggedIn', true);
							$this->session->set_userdata('username', $checkLogin['USERNAME']);
							$this->session->set_userdata('branch_id', $checkLogin['BRANCH_ID']);
							redirect('users/dashboard');
						}else{
							$data['error_msg'] = 'Invalid login.';
							$status = $checkLogin['STATUS'];
							$retry_cnt = $checkLogin['RETRY_CNT'];
							$retry_cnt += 1;
							if($retry_cnt >= $this->LOGIN_MAX_RETRY){
								$status = 'Locked';
								$retry_cnt = 0;
								$data['error_msg'] = 'User is locked due to multiple invalid login.';
							}
							$loginUpdt = array(
								'retry_cnt' => $retry_cnt,
								'status' => $status
							);
							$this->user->update($checkLogin['ID'], $loginUpdt);
						}
					}
					
				}else{
					$data['error_msg'] = 'Invalid login.';
				}
			}else{
				$data['error_msg'] = 'Please fill all required fields.';
			}
		}

		$this->load->view('components/header', $data);
		$this->load->view('users/login', $data);
		$this->load->view('components/footer');
	}

	public function dashboard(){
		$data = array();
		$data['session_user'] = $this->session->userdata('username');
		$this->load->view('components/header', $data);
		$this->load->view('dashboard/dashboard', $data);
		$this->load->view('components/footer');
	}

	public function logout(){
		$this->session->unset_userdata('isLoggedIn');
		$this->session->unset_userdata('username');
		$this->session->sess_destroy();
		redirect('users/login/');
	}
}