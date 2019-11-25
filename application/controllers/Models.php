<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Models extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->model('model');
		$this->load->model('brand');

		$this->isLoggedIn = $this->session->userdata('isLoggedIn');
	}

	public function index(){
		if($this->isLoggedIn){
			redirect('models/view');
		}else{
			redirect('users/login');
		}
	}

	public function view(){
		$data = array();
		$data['session_user'] = $this->session->userdata('username');
		
		$this->load->view('components/header', $data);
		$this->load->view('models/view', $data);
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

		if($this->input->post('submit_model')){
			$this->form_validation->set_rules('model', 'Model', 'required|trim');
			$this->form_validation->set_rules('brand', 'Brand', 'required|trim');

			if($this->form_validation->run() == true){
				$model = array(
					'id'		=> uniqid('', true),
					'model'		=> strtoupper($this->input->post('model')),
					'brand'		=> strtoupper($this->input->post('brand'))
					);
				$this->model->insert($model);

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
		$data['brands'] = $this->brand->getRows($con);

		$this->load->view('components/header', $data);
		$this->load->view('models/add', $data);
		$this->load->view('components/footer');
	}

	public function models_page(){
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
		$modelList = $this->model->getRows($con);

		$data = array();
		
		foreach($modelList->result_array() as $r) {
		   $data[] = array(
		        $r['MODEL'],
		        $r['BRAND']
		   );
		}

		$output = array(
		   "draw" => $draw,
		     "recordsTotal" => $modelList->num_rows(),
		     "recordsFiltered" => $modelList->num_rows(),
		     "data" => $data
		);
		echo json_encode($output);
		exit();
     }

}