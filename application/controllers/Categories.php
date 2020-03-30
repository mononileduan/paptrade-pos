<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Categories extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->model('category');

		$this->isLoggedIn = $this->session->userdata('isLoggedIn');
	}

	public function index(){
		if($this->isLoggedIn){
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

			if($this->input->post('submit_category')){
				$this->form_validation->set_rules('category', 'Category', 'required|trim');

				if($this->form_validation->run() == true){
					$con = array(
						'returnType' => 'count',
						'conditions' => array(
							'del' => false,
							'category' => strtoupper($this->input->post('category'))
						)
					);

					$categoryCnt = $this->category->getRows($con);
					if($categoryCnt > 0){
						$data['error_msg'] = 'Category already exists';
					}else{
						$category = array(
							'id'		=> uniqid('', true),
							'category'	=> strtoupper($this->input->post('category'))
							);
						$this->category->insert($category);

						$this->session->set_flashdata('success_msg', 'Category successfully added!');
						redirect(current_url());
					}

				}else{
					$data['error_msg'] = 'Please fill all required fields.';
				}

			}else if($this->input->post('submit_delete')){
				$this->form_validation->set_rules('id', 'Category', 'required|trim');

				if($this->form_validation->run() == true){
					if($this->category->delete($this->input->post('id'))){
						echo 'OK';
						exit();
					}else{
						echo 'Could not delete Category. ID does not exist.';
						exit();
					}
				}
			}

			$this->load->view('categories/index', $data);

		}else{
			redirect('users/login');
		}
	}


	public function list(){
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
		$list = $this->category->getRows($con);

		$data = array();
		
		foreach($list->result_array() as $r) {
			$data[] = array(
				$r['ID'],
			    $r['CATEGORY']
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
     }



}