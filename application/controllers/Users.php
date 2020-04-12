<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Users extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->model('user');
		$this->load->model('branch');

		$this->isLoggedIn = $this->session->userdata('isLoggedIn');
		$this->LOGIN_MAX_RETRY = 3;
	}

	public function index(){
		if($this->isLoggedIn && $this->session->userdata('status') == 'Active'){
			$data = array();

			if($this->session->userdata('success_msg')){
				$data['success_msg'] = $this->session->userdata('success_msg');
				$this->session->unset_userdata('success_msg');
			}
			if($this->session->userdata('error_msg')){
				$data['error_msg'] = $this->session->userdata('error_msg');
				$this->session->unset_userdata('error_msg');
			}

			if($this->input->post('submit_user')){
				$this->form_validation->set_rules('last_name', 'Last Name', 'required|trim');
				$this->form_validation->set_rules('first_name', 'First Name', 'required|trim');
				$this->form_validation->set_rules('branch_id', 'Branch', 'required|trim');
				$this->form_validation->set_rules('username', 'Username', 'required|trim');
				$this->form_validation->set_rules('password', 'Password', 'required|trim');
				$this->form_validation->set_rules('role', 'Role', 'required|trim');

				if($this->form_validation->run() == true){
					$con = array(
						'returnType' => 'count',
						'conditions' => array(
							'del' 	=> false,
							'username'	=> strtoupper($this->input->post('username'))
						)
					);

					$request = $this->user->getRows($con);
					if($request > 0){
						$data['error_msg'] = 'Username already exists';

					}else{
						$con = array(
							'returnType' => 'count',
							'conditions' => array(
								'del' 	=> false,
								'last_name'	=> strtoupper($this->input->post('last_name')),
								'first_name'	=> strtoupper($this->input->post('first_name'))
							)
						);
						$request = $this->user->getRows($con);
						if($request > 0){
							$data['error_msg'] = 'User already exists';

						}else{
							$user = array(
								'id'			=> uniqid('', true),
								'last_name'		=> strtoupper($this->input->post('last_name')),
								'first_name'	=> strtoupper($this->input->post('first_name')),
								'branch_id'		=> $this->input->post('branch_id'),
								'username'		=> strtoupper($this->input->post('username')),
								'password'		=> password_hash($this->input->post('password'), PASSWORD_DEFAULT),
								'role'			=> $this->input->post('role'),
								'status'		=> $this->config->item('USER_STATUS_ASSOC')['NEW'][0]
								);
							$this->user->insert($user);

							$this->session->set_flashdata('success_msg', 'User successfully added!');
							redirect(current_url());
						}
					}

				}else{
					$data['error_msg'] = 'Please fill all required fields.';
				}

			}else if($this->input->post('submit_edit')){
				$this->form_validation->set_rules('last_name', 'Last Name', 'required|trim');
				$this->form_validation->set_rules('first_name', 'First Name', 'required|trim');
				$this->form_validation->set_rules('branch_id', 'Branch', 'required|trim');
				$this->form_validation->set_rules('role', 'Role', 'required|trim');
				$this->form_validation->set_rules('status', 'Status', 'required|trim');

				if($this->form_validation->run() == true){
					$con = array(
						'returnType' => 'count',
						'conditions' => array(
							'del' 	=> false,
							'last_name'	=> strtoupper($this->input->post('last_name')),
							'first_name'	=> strtoupper($this->input->post('first_name'))
						),
						'not_in' => array(
							'id' => $this->input->post('id')
						)
					);
					$request = $this->user->getRows($con);
					if($request > 0){
						echo 'User already exists';
						exit();
					}else{
						$user = array(
							'last_name'		=> strtoupper($this->input->post('last_name')),
							'first_name'	=> strtoupper($this->input->post('first_name')),
							'branch_id'		=> $this->input->post('branch_id'),
							'role'			=> $this->input->post('role'),
							'status'		=> $this->input->post('status')
							);
						$this->user->update($this->input->post('id'), $user);

						echo 'OK';
						exit();
					}

				}else{
					$data['error_msg'] = 'Please fill all required fields.';
				}
			}

			$con = array(
				'returnType' => 'list',
				'conditions' => array(
					'del' => false
				)
			);

			$data['branches'] = $this->branch->getRows($con);
			$data['roles'] = $this->config->item('USER_ROLE');
			$data['status'] = $this->config->item('USER_STATUS');
			
			$this->load->view('users/index', $data);

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
			$this->form_validation->set_rules('username', 'username', 'required|trim');
			$this->form_validation->set_rules('password', 'password', 'required|trim');

			if($this->form_validation->run() == true){
				$con = array(
					'returnType' => 'single',
					'conditions' => array(
						'username' => strtoupper($this->input->post('username'))
					)
				);
				$checkLogin = $this->user->getRowsJoin($con)->row_array();
				if($checkLogin){
					if($checkLogin['STATUS'] === 'Locked'){
						$data['error_msg'] = 'User is locked.';

					}elseif($checkLogin['STATUS'] === 'Active' || $checkLogin['STATUS'] === 'New'){
						if(password_verify($this->input->post('password'), $checkLogin['PASSWORD'])){
							$loginUpdt = array(
								'retry_cnt' => 0,
								'last_login_dt' => date("Y-m-d H:i:s")
							);
							$this->user->update($checkLogin['ID'], $loginUpdt);
							$this->session->set_userdata('isLoggedIn', true);
							$this->session->set_userdata('username', $checkLogin['USERNAME']);
							$this->session->set_userdata('fullname', $checkLogin['FIRST_NAME'].' '.$checkLogin['LAST_NAME']);
							$this->session->set_userdata('branch_id', $checkLogin['BRANCH_ID']);
							$this->session->set_userdata('branch', $checkLogin['BRANCH_NAME']);
							$this->session->set_userdata('last_login_dt', $checkLogin['LAST_LOGIN_DT']);
							$this->session->set_userdata('user_role', $checkLogin['ROLE']);
							$this->session->set_userdata('status', $checkLogin['STATUS']);
							if($checkLogin['ROLE'] == 'CASHIER'){
								$this->session->set_userdata('user_role_dscp', 'Cashier');
							}else if($checkLogin['ROLE'] == 'SYS_ADMIN'){
								$this->session->set_userdata('user_role_dscp', 'System Administrator');
							}else if($checkLogin['ROLE'] == 'BRANCH_ADMIN'){
								$this->session->set_userdata('user_role_dscp', 'Branch Administrator');
							}

							
							if($checkLogin['ROLE'] == 'Cashier'){
								redirect('pos/dashboard');
							}else{
								if($checkLogin['STATUS'] !== 'Active'){
									redirect('users/chpass');
								}else{
									redirect('users/dashboard');
								}
							}
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

		$this->load->view('users/login', $data);
	}

	public function dashboard(){
		if($this->isLoggedIn && $this->session->userdata('status') == 'Active'){
			$data = array();

			if($this->session->userdata('success_msg')){
				$data['success_msg'] = $this->session->userdata('success_msg');
				$this->session->unset_userdata('success_msg');
			}
			if($this->session->userdata('error_msg')){
				$data['error_msg'] = $this->session->userdata('error_msg');
				$this->session->unset_userdata('error_msg');
			}

			$this->load->view('dashboard/dashboard', $data);

		}else{
			redirect('users/login');
		}
	}

	public function logout(){
		$this->session->unset_userdata('isLoggedIn');
		$this->session->unset_userdata('username');
		$this->session->sess_destroy();
		redirect('users/login/');
	}

	public function list(){
		if($this->isLoggedIn && $this->session->userdata('status') == 'Active'){
			// Datatables Variables
			$draw = intval($this->input->get("draw"));
			$start = intval($this->input->get("start"));
			$length = intval($this->input->get("length"));

			$con = array(
				'returnType' => 'list',
				'conditions' => array(
					'u.del' => false
				)
			);

			if($this->session->userdata('user_role') == 'Branch Administrator'){
				$con['conditions']['branch_id'] = $this->session->userdata('branch_id');
			}

			$user = $this->user->getRowsJoin($con);

			$data = array();
			
			foreach($user->result_array() as $r) {

			   $data[] = array(
			        $r['ID'],
			        $r['BRANCH_ID'],
			        $r['LAST_NAME'],
			        $r['FIRST_NAME'],
			        $r['BRANCH_NAME'],
			        $r['ROLE'],
			        $r['STATUS'],
			        $r['USERNAME'],
			        $r['LAST_LOGIN_DT']
			   );
			}

			$output = array(
			   "draw" => $draw,
			     "recordsTotal" => $user->num_rows(),
			     "recordsFiltered" => $user->num_rows(),
			     "data" => $data
			);
			echo json_encode($output);
			exit();
		}
    }

	public function chpass(){
		if($this->isLoggedIn){
			$data = array();

			if($this->session->userdata('success_msg')){
				$data['success_msg'] = $this->session->userdata('success_msg');
				$this->session->unset_userdata('success_msg');
			}
			if($this->session->userdata('error_msg')){
				$data['error_msg'] = $this->session->userdata('error_msg');
				$this->session->unset_userdata('error_msg');
			}

			if($this->input->post('submit')){
				$this->form_validation->set_rules('old_password', 'Old Password', 'required|trim');
				$this->form_validation->set_rules('new_password', 'New Password', 'required|trim');
				$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|trim');

				if($this->form_validation->run() == true){
					if($this->input->post('new_password') != $this->input->post('confirm_password')){
						$data['error_msg'] = 'New Password does not match Confirm Password';
					}else{
						$con = array(
							'returnType' => 'single',
							'conditions' => array(
								'del' 	=> false,
								'username'	=> $this->session->userdata('username')
							)
						);
						$user = $this->user->getRows($con);
						if(password_verify($this->input->post('old_password'), $user['PASSWORD'])){
							$userUpdt = array(
								'retry_cnt' => 0,
								'status' => 'Active',
								'password' => password_hash($this->input->post('new_password'), PASSWORD_DEFAULT)
							);
							$this->user->update($user['ID'], $userUpdt);

							$this->session->set_flashdata('success_msg', 'Password successfully updated!');
							if($this->session->userdata('status') !== 'Active'){
								$this->session->set_userdata('status', 'Active');
								redirect('users/dashboard');
							}else{
								redirect(current_url());
							}

						}else{
							$status = $user['STATUS'];
							$retry_cnt = $user['RETRY_CNT'];
							$retry_cnt += 1;
							if($retry_cnt >= $this->LOGIN_MAX_RETRY){
								$status = 'Locked';
								$retry_cnt = 0;
								$data['error_msg'] = 'You are locked due to multiple invalid password retries.';
							}else if($retry_cnt == $this->LOGIN_MAX_RETRY-1){
								$data['error_msg'] = 'Invalid password. You will be locked after 1 more invalid retry.';
							}else{
								$max_retry = $this->LOGIN_MAX_RETRY;
								$allowed = $max_retry - $retry_cnt;
								$data['error_msg'] = 'Invalid password. You will be locked after '. $allowed .' more invalid retries.';
							}
							$userUpdt = array(
								'retry_cnt' => $retry_cnt,
								'status' => $status
							);
							$this->user->update($user['ID'], $userUpdt);

							$this->session->set_flashdata('error_msg', $data['error_msg']);
							redirect(current_url());
						}
					}

				}else{
					$data['error_msg'] = 'Please fill all required fields.';
				}

			}
			
			if($this->session->userdata('status') !== 'Active'){
				$this->load->view('users/chpass_nomenu', $data);
			}else{
				$this->load->view('users/chpass', $data);
			}
			

		}else{
			redirect('users/login');
		}
	}
}