<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Inventories_Branch extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->model('inventory_branch');
		$this->load->model('category');

		$this->isLoggedIn = $this->session->userdata('isLoggedIn');
	}

	public function index(){
		if($this->isLoggedIn){
			redirect('inventories_branch/view');
		}else{
			redirect('users/login');
		}
	}

	public function view(){
		$data = array();
		$data['session_user'] = $this->session->userdata('username');

		$footer_data = array();
		$footer_data['page_has_table'] = 'has_table';
		$footer_data['site_url'] = 'inventories_branch/inventories_branch_page';
		$footer_data['has_export_buttons'] = 'enabled';
		$footer_data['right_align_columns'] = array(-1, -2);
		
		$this->load->view('components/header', $data);
		$this->load->view('inventories_branch/view', $data);
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
			$this->form_validation->set_rules('category', 'Category', 'required|trim');
			$this->form_validation->set_rules('item_id', 'Item', 'required|trim');
			$this->form_validation->set_rules('quantity', 'Quantity', 'required|trim');
			$this->form_validation->set_rules('selling_price', 'Selling Price', 'required|trim');

			if($this->form_validation->run() == true){
				$con = array(
					'returnType' => 'single',
					'conditions' => array(
						'del' 	=> false,
						'branch_id'	=> $this->session->userdata('branch_id'),
						'item_id'	=> strtoupper($this->input->post('item_id'))
					)
				);

				$inventory = $this->inventory_branch->getRows($con);
				if($inventory){
					$quantity = $inventory['QUANTITY'];
					$newVal = array('quantity' => $quantity + $this->input->post('quantity'));
					$this->inventory_branch->update($inventory['ID'], $newVal);

					redirect(current_url());

				}else{
					$inventory = array(
						'id'					=> uniqid('', true),
						'branch_id'				=> $this->session->userdata('branch_id'),
						'item_id'				=> strtoupper($this->input->post('item_id')),
						'quantity'				=> $this->input->post('quantity'),
						'selling_price'			=> $this->input->post('selling_price')
						);
					$this->inventory_branch->insert($inventory);

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
		$this->load->view('inventories_branch/add', $data);
		$this->load->view('components/footer');
	}

	public function inventories_branch_page(){
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$con = array(
			'returnType' => 'list',
			'conditions' => array(
				'inv.del' => false,
				'branch_id' => $this->session->userdata('branch_id')
			)
		);
		$inventoryList = $this->inventory_branch->getRowsJoin($con);

		$data = array();
		
		foreach($inventoryList->result_array() as $r) {
		   $data[] = array(
		        $r['ITEM'],
		        $r['CATEGORY'],
		        $r['QUANTITY'],
		        $r['SELLING_PRICE']
		   );
		}

		$output = array(
		   "draw" => $draw,
		     "recordsTotal" => $inventoryList->num_rows(),
		     "recordsFiltered" => $inventoryList->num_rows(),
		     "data" => $data
		);
		echo json_encode($output);
		exit();
     }

}