<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Stock_types extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->model('stock_type');

		$this->isLoggedIn = $this->session->userdata('isLoggedIn');
	}

	public function index(){
		if($this->isLoggedIn && $this->session->userdata('status') == $this->config->item('USER_STATUS_ASSOC')['ACTIVE'][0]){
			if(in_array('STOCK_TYPE', $this->config->item('USER_ROLE_ASSOC_MENU')[$this->session->userdata('user_role')])){
				$data = array();
				$data['success_msg'] = $this->session->flashdata('success_msg');

				if($this->session->userdata('success_msg')){
					$data['success_msg'] = $this->session->userdata('success_msg');
					$this->session->unset_userdata('success_msg');
				}
				if($this->session->userdata('error_msg')){
					$data['error_msg'] = $this->session->userdata('error_msg');
					$this->session->unset_userdata('error_msg');
				}

				if($this->input->post('submit_stock_type')){
					$this->form_validation->set_rules('stock_type', 'Stock Type', 'required|trim');

					if($this->form_validation->run() == true){
						$con = array(
							'returnType' => 'count',
							'conditions' => array(
								'del' => false,
								'stock_type' => strtoupper($this->input->post('stock_type'))
							)
						);
						$stockTypeCnt = $this->stock_type->getRows($con);
						if($stockTypeCnt > 0){
							$data['error_msg'] = 'Stock Type already exists';
						}else{
							$stock_type = array(
								'id'			=> uniqid('', true),
								'stock_type'	=> strtoupper($this->input->post('stock_type'))
								);
							$this->stock_type->insert($stock_type);
							
							$this->session->set_flashdata('success_msg', 'Stock Type successfully added!');
							redirect(current_url());
						}

					}else{
						$data['error_msg'] = 'Please fill all required fields.';
					}

				}else if($this->input->post('submit_delete')){
					$this->form_validation->set_rules('id', 'Stock Type', 'required|trim');

					if($this->form_validation->run() == true){
						if($this->stock_type->delete($this->input->post('id'))){
							echo 'OK';
							exit();
						}else{
							echo 'Could not delete Stock Type. ID does not exist.';
							exit();
						}
					}
				}

				$this->load->view('stock_types/index', $data);

			}else{
				$this->load->view('components/unauthorized');
			}
		}else{
			redirect('users/logout');
		}
	}


	public function list(){
		if($this->isLoggedIn && $this->session->userdata('status') == $this->config->item('USER_STATUS_ASSOC')['ACTIVE'][0] 
			&& in_array('STOCK_TYPE', $this->config->item('USER_ROLE_ASSOC_MENU')[$this->session->userdata('user_role')])){
			
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
			$list = $this->stock_type->getRows($con);

			$data = array();
			
			foreach($list->result_array() as $r) {
				$data[] = array(
					$r['ID'],
				    $r['STOCK_TYPE']
				);
			}

			$output = array(
			   "draw" => $draw,
			     "recordsTotal" => $list->num_rows(),
			     "recordsFiltered" => $list->num_rows(),
			     "data" => $data
			);
			echo json_encode($output);
			exit();

		}else{
			$this->load->view('components/unauthorized');
		}
     }



}