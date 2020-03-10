<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Stock_Types extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->model('stock_type');

		$this->isLoggedIn = $this->session->userdata('isLoggedIn');
	}

	public function index(){
		if($this->isLoggedIn){
			$data = array();
			$data['session_user'] = $this->session->userdata('username');

			$footer_data = array();
			$footer_data['has_table'] = 'has_table';
			$footer_data['site_url'] = 'stock_types/stock_types_page';
			$footer_data['action'] = 'delete';
			$footer_data['right_align_cols'] = array();

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
						
						$data['success_msg'] = 'Stock Type successfully added!';
					}

				}else{
					$data['error_msg'] = 'Please fill all required fields.';
				}
			}

			$this->load->view('components/header', $data);
			$this->load->view('stock_types/view', $data);
			$this->load->view('components/footer_modal', $footer_data);

		}else{
			redirect('users/login');
		}
	}

	

	public function stock_types_page(){
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
		$stockTypeList = $this->stock_type->getRows($con);

		$data = array();
		
		foreach($stockTypeList->result_array() as $r) {

		   $data[] = array(
		   		$r['ID'],
		        $r['STOCK_TYPE']
		   );
		}

		$output = array(
		   "draw" => $draw,
		     "recordsTotal" => $stockTypeList->num_rows(),
		     "recordsFiltered" => $stockTypeList->num_rows(),
		     "data" => $data
		);
		echo json_encode($output);
		exit();
     }

}