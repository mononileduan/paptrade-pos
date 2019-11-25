<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Brands extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->model('brand');
		$this->load->model('category');

		$this->isLoggedIn = $this->session->userdata('isLoggedIn');
	}

	public function index(){
		if($this->isLoggedIn){
			redirect('brands/view');
		}else{
			redirect('users/login');
		}
	}

	public function view(){
		$data = array();
		$data['session_user'] = $this->session->userdata('username');
		
		$this->load->view('components/header', $data);
		$this->load->view('brands/view', $data);
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

		if($this->input->post('submit_brand')){
			$this->form_validation->set_rules('category', 'Category', 'required|trim');
			$this->form_validation->set_rules('brand', 'Brand', 'required|trim');

			if($this->form_validation->run() == true){
				$brand = array(
					'id'		=> uniqid('', true),
					'category'	=> strtoupper($this->input->post('category')),
					'brand'		=> strtoupper($this->input->post('brand'))
					);
				$this->brand->insert($brand);

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
		$data['categories'] = $this->category->getRows($con);

		$this->load->view('components/header', $data);
		$this->load->view('brands/add', $data);
		$this->load->view('components/footer');
	}

	public function brands_page(){
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
		        $r['BRAND'],
		        $r['CATEGORY']
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
     }

}