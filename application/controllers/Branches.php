<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Branches extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->model('branch');
		$this->load->model('user');

		$this->isLoggedIn = $this->session->userdata('isLoggedIn');
	}


	public function index(){
		if($this->isLoggedIn && $this->session->userdata('status') == $this->config->item('USER_STATUS_ASSOC')['ACTIVE'][0]){
			if(in_array('BRANCH', $this->config->item('USER_ROLE_ASSOC_MENU')[$this->session->userdata('user_role')])){
				$data = array();

				if($this->session->userdata('success_msg')){
					$data['success_msg'] = $this->session->userdata('success_msg');
					$this->session->unset_userdata('success_msg');
				}
				if($this->session->userdata('error_msg')){
					$data['error_msg'] = $this->session->userdata('error_msg');
					$this->session->unset_userdata('error_msg');
				}

				if($this->input->post('submit_branch')){
					$this->form_validation->set_rules('branch_name', 'Branch Name', 'required|trim');
					$this->form_validation->set_rules('address', 'Address', 'required|trim');
					$this->form_validation->set_rules('contact', 'Contact Details', 'required|trim');

					if($this->form_validation->run() == true){
						$con = array(
							'returnType' => 'count',
							'conditions' => array(
								'del' 	=> false,
								'branch_name'	=> strtoupper($this->input->post('branch_name'))
							)
						);

						$request = $this->branch->getRows($con);
						if($request > 0){
							$data['error_msg'] = 'Branch already exists';

						}else{
							$branch = array(
								'id'			=> uniqid('', true),
								'branch_name'	=> strtoupper($this->input->post('branch_name')),
								'address'	=> strtoupper($this->input->post('address')),
								'contact'	=> $this->input->post('contact')
								);
							$this->branch->insert($branch);

							$this->session->set_flashdata('success_msg', 'Branch successfully added!');
							redirect(current_url());
						}

					}else{
						$data['error_msg'] = 'Please fill all required fields.';
					}

				}else if($this->input->post('submit_delete')){
					$this->form_validation->set_rules('id', 'Branch', 'required|trim');

					if($this->form_validation->run() == true){
						$con = array(
							'returnType' => 'count',
							'conditions' => array(
								'del' 	=> false,
								'branch_id'	=> strtoupper($this->input->post('id'))
							)
						);

						$cnt = $this->user->getRows($con);
						if($cnt == 0){
							if($this->branch->delete($this->input->post('id'))){
								echo 'OK';
								exit();
							}else{
								echo 'Could not delete Branch. ID does not exist.';
								exit();
							}
						}else{
							echo 'Could not delete Branch.';
							exit();
						}

						
					}

				}else if($this->input->post('submit_edit')){
					$this->form_validation->set_rules('id', 'Branch', 'required|trim');
					$this->form_validation->set_rules('branch_name', 'Branch Name', 'required|trim');
					$this->form_validation->set_rules('address', 'Address', 'required|trim');
					$this->form_validation->set_rules('contact', 'Contact Details', 'required|trim');

					if($this->form_validation->run() == true){
						$con = array(
							'returnType' => 'count',
							'conditions' => array(
								'del'	=> false,
								'branch_name' => trim(strtoupper($this->input->post('branch_name')))
							),
							'not_in' => array(
								'id' => $this->input->post('id')
							)
						);
						$cnt = $this->branch->getRows($con);
						if($cnt > 0){
							echo 'Branch already exists';
							exit();
						}else{
							$branch_ = array(
								'branch_name'	=> strtoupper($this->input->post('branch_name')),
								'address'	=> strtoupper($this->input->post('address')),
								'contact'	=> $this->input->post('contact')
								);
							$this->branch->update($this->input->post('id'), $branch_);
							
							echo 'OK';
							exit();
						}

					}else{
						$data['error_msg'] = 'Please fill all required fields.';
					}
				}

				$this->load->view('branches/index', $data);

			}else{
				$this->load->view('components/unauthorized');
			}
		}else{
			redirect('users/logout');
		}
	}


	public function list(){
		if($this->isLoggedIn && $this->session->userdata('status') == $this->config->item('USER_STATUS_ASSOC')['ACTIVE'][0] 
		&& in_array('BRANCH', $this->config->item('USER_ROLE_ASSOC_MENU')[$this->session->userdata('user_role')])){
			
			// Datatables Variables
			$draw = intval($this->input->get("draw"));
			$start = intval($this->input->get("start"));
			$length = intval($this->input->get("length"));

			$con = array(
				'returnType' => 'list',
				'conditions' => array(
					'del' => false
				)
			);
			$branch = $this->branch->getRows($con);

			$data = array();
			
			foreach($branch->result_array() as $r) {

			   $data[] = array(
			        $r['ID'],
			        $r['BRANCH_NAME'],
			        $r['ADDRESS'],
			        $r['CONTACT']
			   );
			}

			$output = array(
			   "draw" => $draw,
			     "recordsTotal" => $branch->num_rows(),
			     "recordsFiltered" => $branch->num_rows(),
			     "data" => $data
			);
			echo json_encode($output);
			exit();
			
		}else{
			$this->load->view('components/unauthorized');
		}
     }

}