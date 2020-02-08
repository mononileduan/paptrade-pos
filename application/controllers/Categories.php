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
			redirect('categories/view');
		}else{
			redirect('users/login');
		}
	}

	public function view(){
		$data = array();
		$data['session_user'] = $this->session->userdata('username');

		$footer_data = array();
		$footer_data['page_has_table'] = 'has_table';
		$footer_data['site_url'] = 'categories/categories_page';
		
		$this->load->view('components/header', $data);
		$this->load->view('categories/view', $data);
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

					redirect(current_url());
				}

			}else{
				$data['error_msg'] = 'Please fill all required fields.';
			}
		}

		$this->load->view('components/header', $data);
		$this->load->view('categories/add', $data);
		$this->load->view('components/footer');
	}

	public function categories_page(){
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
		$categoryList = $this->category->getRows($con);

		$data = array();
		
		foreach($categoryList->result_array() as $r) {

		   $data[] = array(
		      
		        $r['CATEGORY']
		   );
		}

		$output = array(
		   "draw" => $draw,
		     "recordsTotal" => $categoryList->num_rows(),
		     "recordsFiltered" => $categoryList->num_rows(),
		     "data" => $data
		);
		echo json_encode($output);
		exit();
     }

}