<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Brands extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->model('brand');

		$this->isLoggedIn = $this->session->userdata('isLoggedIn');
	}

	public function index(){
		if($this->isLoggedIn && $this->session->userdata('status') == $this->config->item('USER_STATUS_ASSOC')['ACTIVE'][0]){
			if(in_array('USER', $this->config->item('USER_ROLE_ASSOC_MENU')[$this->session->userdata('user_role')])){
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

				if($this->input->post('submit_brand')){
					$this->form_validation->set_rules('brand', 'Brand', 'required|trim');

					if($this->form_validation->run() == true){
						$con = array(
							'returnType' => 'count',
							'conditions' => array(
								'del' => false,
								'brand' => strtoupper($this->input->post('brand'))
							)
						);

						$brandCnt = $this->brand->getRows($con);
						if($brandCnt > 0){
							$data['error_msg'] = 'Brand Name already exists';
						}else{
							$brand = array(
								'id'		=> uniqid('', true),
								'brand'		=> strtoupper($this->input->post('brand'))
								);
							$this->brand->insert($brand);

							$this->session->set_flashdata('success_msg', 'Brand successfully added!');
							redirect(current_url());
						}

					}else{
						$data['error_msg'] = 'Please fill all required fields.';
					}

				}else if($this->input->post('submit_delete')){
					$this->form_validation->set_rules('id', 'Brand', 'required|trim');

					if($this->form_validation->run() == true){
						if($this->brand->delete($this->input->post('id'))){
							echo 'OK';
							exit();
						}else{
							echo 'Could not delete Brand. ID does not exist.';
							exit();
						}
					}
				}

				$this->load->view('brands/index', $data);

			}else{
				$this->load->view('components/unauthorized');
			}
		}else{
			redirect('users/logout');
		}
	}


	public function list(){
		if($this->isLoggedIn && $this->session->userdata('status') == $this->config->item('USER_STATUS_ASSOC')['ACTIVE'][0] 
			&& in_array('BRAND', $this->config->item('USER_ROLE_ASSOC_MENU')[$this->session->userdata('user_role')])){

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
			$brandList = $this->brand->getRows($con);

			$data = array();
			
			foreach($brandList->result_array() as $r) {
				$data[] = array(
					$r['ID'],
				    $r['BRAND']
				);
			}

			$output = array(
			   "draw" => $draw,
			     "recordsTotal" => $brandList->num_rows(),
			     "recordsFiltered" => $brandList->num_rows(),
			     "data" => $data
			);
			echo json_encode($output);
			exit();
			
		}else{
			$this->load->view('components/unauthorized');
		}
     }

}