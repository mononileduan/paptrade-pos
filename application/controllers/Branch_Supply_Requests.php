<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Branch_Supply_Requests extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->model('branch_supply_request');
		$this->load->model('category');

		$this->isLoggedIn = $this->session->userdata('isLoggedIn');
	}

	public function index(){
		if($this->isLoggedIn){
			redirect('branch_supply_requests/view');
		}else{
			redirect('users/login');
		}
	}

	public function view(){
		$data = array();
		$data['session_user'] = $this->session->userdata('username');

		$footer_data = array();
		$footer_data['page_has_table'] = 'has_table';
		$footer_data['site_url'] = 'branch_supply_requests/branch_supply_requests_page';
		$footer_data['right_align_columns'] = array(-4);
		
		$this->load->view('components/header', $data);
		$this->load->view('branch_supply_requests/view', $data);
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

		if($this->input->post('submit_inventory_branch')){
			$this->form_validation->set_rules('category_id', 'Category', 'required|trim');
			$this->form_validation->set_rules('item_id', 'Item', 'required|trim');
			$this->form_validation->set_rules('quantity', 'Quantity', 'required|trim');
			$this->form_validation->set_rules('dscp', 'Description', 'required|trim');

			if($this->form_validation->run() == true){
				$con = array(
					'returnType' => 'count',
					'conditions' => array(
						'del' 	=> false,
						'branch_id'	=> $this->session->userdata('branch_id'),
						'item_id'	=> strtoupper($this->input->post('item_id')),
						'status'	=> 'PENDING'
					)
				);

				$request = $this->branch_supply_request->getRows($con);
				if($request > 0){
					$data['error_msg'] = 'There is still pending request for this item';

				}else{
					$supply_request = array(
						'id'			=> uniqid('', true),
						'branch_id'		=> $this->session->userdata('branch_id'),
						'item_id'		=> strtoupper($this->input->post('item_id')),
						'quantity'		=> $this->input->post('quantity'),
						'dscp'			=> strtoupper($this->input->post('dscp')),
						'status'		=> 'PENDING'
						);
					$this->branch_supply_request->insert($supply_request);

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
		$data['categories'] = $this->category->getRows($con);

		$this->load->view('components/header', $data);
		$this->load->view('branch_supply_requests/add', $data);
		$this->load->view('components/footer');
	}


	public function branch_supply_requests_page(){
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$con = array(
			'returnType' => 'list',
			'conditions' => array(
				'req.del' => false
			)
		);
		$supply_request = $this->branch_supply_request->getRowsJoin($con);

		$data = array();
		
		foreach($supply_request->result_array() as $r) {

		   $data[] = array(
		        $r['ITEM'],
		        $r['DSCP'],
		        $r['CATEGORY'],
		        $r['QUANTITY'],
		        $r['STATUS'],
		        $r['CREATED_BY'],
		        $r['CREATED_DT']
		   );
		}

		$output = array(
		   "draw" => $draw,
		     "recordsTotal" => $supply_request->num_rows(),
		     "recordsFiltered" => $supply_request->num_rows(),
		     "data" => $data
		);
		echo json_encode($output);
		exit();
     }


}