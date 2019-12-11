<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Measures extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->model('measure');

		$this->isLoggedIn = $this->session->userdata('isLoggedIn');
	}

	public function index(){
		if($this->isLoggedIn){
			redirect('measures/view');
		}else{
			redirect('users/login');
		}
	}

	public function view(){
		$data = array();
		$data['session_user'] = $this->session->userdata('username');
		
		$this->load->view('components/header', $data);
		$this->load->view('measures/view', $data);
		$this->load->view('components/footer');
	}

	public function add(){
		$data = array();
		
		if($this->session->userdata('success_msg')){
			$data['success_msg'] = $this->session->userdata('success_msg');
			$this->session->unset_userdata('success_msg');
		}
		if($this->session->userdata('error_msg')){
			$data['error_msg'] = $this->session->userdata('error_msg');
			$this->session->unset_userdata('error_msg');
		}

		if($this->input->post('submit_measure')){
			$this->form_validation->set_rules('measure', 'Unit of Measure', 'required|trim');

			if($this->form_validation->run() == true){
				$measure = array(
					'id'		=> uniqid('', true),
					'unit_of_measure'	=> strtoupper($this->input->post('measure'))
					);
				$this->measure->insert($measure);

			}else{
				$data['error_msg'] = 'Please fill all required fields.';
			}
		}

		$this->load->view('components/header', $data);
		$this->load->view('measures/add', $data);
		$this->load->view('components/footer');
	}

	public function measures_page(){
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
		$measureList = $this->measure->getRows($con);

		$data = array();
		
		foreach($measureList->result_array() as $r) {

		   $data[] = array(
		        $r['UNIT_OF_MEASURE']
		   );
		}

		$output = array(
		   "draw" => $draw,
		     "recordsTotal" => $measureList->num_rows(),
		     "recordsFiltered" => $measureList->num_rows(),
		     "data" => $data
		);
		echo json_encode($output);
		exit();
     }

}