<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Branches extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->model('branch');

		$this->isLoggedIn = $this->session->userdata('isLoggedIn');
	}

	public function index(){
		if($this->isLoggedIn){
			redirect('branches/view');
		}else{
			redirect('users/login');
		}
	}

	public function view(){
		$data = array();
		$data['session_user'] = $this->session->userdata('username');

		$footer_data = array();
		$footer_data['page_has_table'] = 'has_table';
		$footer_data['site_url'] = 'branches/branches_page';
		
		$this->load->view('components/header', $data);
		$this->load->view('branches/view', $data);
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

		if($this->input->post('submit_branch')){
			$this->form_validation->set_rules('branch_name', 'Branch Name', 'required|trim');

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
						'branch_name'	=> strtoupper($this->input->post('branch_name'))
						);
					$this->branch->insert($branch);

					redirect(current_url());
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

		$this->load->view('components/header', $data);
		$this->load->view('branches/add', $data);
		$this->load->view('components/footer');
	}


	public function branches_page(){
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
		        $r['BRANCH_NAME']
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
     }

}