<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Models extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->model('model');
		$this->load->model('brand');
		$this->load->model('category');

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

		$footer_data = array();
		$footer_data['page_has_table'] = 'has_table';
		$footer_data['site_url'] = 'models/models_page';
		
		$this->load->view('components/header', $data);
		$this->load->view('models/view', $data);
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

		if($this->input->post('submit_model')){
			$this->form_validation->set_rules('model', 'Model', 'required|trim');
			$this->form_validation->set_rules('brand_id', 'Brand', 'required|trim');
			$this->form_validation->set_rules('category_id', 'Category', 'required|trim');

			if($this->form_validation->run() == true){
				$con = array(
					'returnType' => 'count',
					'conditions' => array(
						'del' 	=> false,
						'model'	=> strtoupper($this->input->post('model')),
						'brand_id' => strtoupper($this->input->post('brand_id'))
					)
				);

				$modelCnt = $this->model->getRows($con);
				if($modelCnt > 0){
					$data['error_msg'] = 'Model already exists';
				}else{
					$model = array(
						'id'		=> uniqid('', true),
						'model'		=> strtoupper($this->input->post('model')),
						'brand_id'		=> strtoupper($this->input->post('brand_id')),
						'category_id' => strtoupper($this->input->post('category_id'))
						);
					$this->model->insert($model);

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
		$data['brands'] = $this->brand->getRows($con);
		$data['categories'] = $this->category->getRows($con);

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
				'm.del' => false
			)
		);
		$modelList = $this->model->getRowsJoin($con);

		$data = array();
		
		foreach($modelList->result_array() as $r) {
		   $data[] = array(
		        $r['BRAND'],
		        $r['MODEL'],
		        $r['CATEGORY']
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

	public function get_by_category(){
		$category = $this->input->get('id',TRUE);
		$con = array(
			'returnType' => 'list',
			'conditions' => array(
				'del' => false,
				'category' => $category
			)
		);
		$modelList = $this->model->getRows($con);

		$data = $modelList->result();
		
		echo json_encode($data);
		exit();
	}

}