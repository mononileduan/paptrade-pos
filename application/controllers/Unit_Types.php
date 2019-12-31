<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Unit_Types extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->model('unit_type');

		$this->isLoggedIn = $this->session->userdata('isLoggedIn');
	}

	public function index(){
		if($this->isLoggedIn){
			redirect('unit_types/view');
		}else{
			redirect('users/login');
		}
	}

	public function view(){
		$data = array();
		$data['session_user'] = $this->session->userdata('username');

		$footer_data = array();
		$footer_data['page_has_table'] = 'has_table';
		$footer_data['site_url'] = 'unit_types/unit_types_page';
		
		$this->load->view('components/header', $data);
		$this->load->view('unit_types/view', $data);
		$this->load->view('components/footer', $footer_data);
	}

	public function add(){
		$data = array();
		$data['session_user'] = $this->session->userdata('username');
		
		if($this->session->userdata('success_msg')){
			$data['success_msg'] = $this->session->userdata('success_msg');
			$this->session->unset_userdata('success_msg');
		}
		if($this->session->userdata('error_msg')){
			$data['error_msg'] = $this->session->userdata('error_msg');
			$this->session->unset_userdata('error_msg');
		}

		if($this->input->post('submit_unit_type')){
			$this->form_validation->set_rules('unit_type', 'Unit Type', 'required|trim');

			if($this->form_validation->run() == true){
				$con = array(
					'returnType' => 'count',
					'conditions' => array(
						'del' => false,
						'unit_type' => strtoupper($this->input->post('unit_type'))
					)
				);
				$unitTypeCnt = $this->unit_type->getRows($con);
				if($unitTypeCnt > 0){
					$data['error_msg'] = 'Unit Type already exists';
				}else{
					$unit_type = array(
						'id'		=> uniqid('', true),
						'unit_type'	=> strtoupper($this->input->post('unit_type'))
						);
					$this->unit_type->insert($unit_type);
					
					redirect(current_url());
				}

			}else{
				$data['error_msg'] = 'Please fill all required fields.';
			}
		}

		$this->load->view('components/header', $data);
		$this->load->view('unit_types/add', $data);
		$this->load->view('components/footer');
	}

	public function unit_types_page(){
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
		$unitTypeList = $this->unit_type->getRows($con);

		$data = array();
		
		foreach($unitTypeList->result_array() as $r) {

		   $data[] = array(
		        $r['UNIT_TYPE']
		   );
		}

		$output = array(
		   "draw" => $draw,
		     "recordsTotal" => $unitTypeList->num_rows(),
		     "recordsFiltered" => $unitTypeList->num_rows(),
		     "data" => $data
		);
		echo json_encode($output);
		exit();
     }

}