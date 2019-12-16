<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Inventories_Branch extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->model('inventory_branch');
		$this->load->model('brand');
		$this->load->model('category');
		$this->load->model('unit_type');

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
		
		$this->load->view('components/header', $data);
		$this->load->view('inventories_branch/view', $data);
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

		if($this->input->post('submit_inventory_branch')){
			$this->form_validation->set_rules('category', 'Category', 'required|trim');
			$this->form_validation->set_rules('brand', 'Brand', 'required|trim');
			$this->form_validation->set_rules('item', 'Item', 'required|trim');
			$this->form_validation->set_rules('sku', 'SKU', 'required|trim');
			$this->form_validation->set_rules('unit_type', 'Unit Type', 'required|trim');
			$this->form_validation->set_rules('quantity', 'Quantity', 'required|trim');
			$this->form_validation->set_rules('selling_price', 'Selling Price', 'required|trim');
			$this->form_validation->set_rules('warehouse_po_ref_no', 'Warehouse PO Ref No', 'required|trim');

			if($this->form_validation->run() == true){
				$inventory = array(
					'id'					=> uniqid('', true),
					'category'				=> strtoupper($this->input->post('category')),
					'brand'					=> strtoupper($this->input->post('brand')),
					'item'					=> strtoupper($this->input->post('item')),
					'sku'					=> strtoupper($this->input->post('sku')),
					'unit_type'				=> strtoupper($this->input->post('unit_type')),
					'quantity'				=> $this->input->post('quantity'),
					'selling_price'			=> $this->input->post('selling_price'),
					'warehouse_po_ref_no'	=> strtoupper($this->input->post('warehouse_po_ref_no'))
					);
				$this->inventory_branch->insert($inventory);

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
		$data['brands'] = $this->brand->getRows($con);
		$data['unit_types'] = $this->unit_type->getRows($con);

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
				'del' => false
			)
		);
		$inventoryList = $this->inventory_branch->getRows($con);

		$data = array();
		
		foreach($inventoryList->result_array() as $r) {
		   $data[] = array(
		        $r['SKU'],
		        $r['ITEM'],
		        $r['BRAND'],
		        $r['CATEGORY'],
		        $r['UNIT_TYPE'],
		        $r['QUANTITY'],
		        $r['SELLING_PRICE'],
		        $r['WAREHOUSE_PO_REF_NO']
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