<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Inventories extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->model('inventory');
		$this->load->model('brand');
		$this->load->model('category');
		$this->load->model('unit_type');

		$this->isLoggedIn = $this->session->userdata('isLoggedIn');
	}

	public function index(){
		if($this->isLoggedIn){
			redirect('inventories/view');
		}else{
			redirect('users/login');
		}
	}

	public function view(){
		$data = array();
		$data['session_user'] = $this->session->userdata('username');

		$footer_data = array();
		$footer_data['page_has_table'] = 'has_table';
		$footer_data['site_url'] = 'inventories/inventories_page';
		$footer_data['has_export_buttons'] = 'enabled';
		$footer_data['right_align_columns'] = array(-2, -3, -5);
		
		$this->load->view('components/header', $data);
		$this->load->view('inventories/view', $data);
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

		if($this->input->post('submit_inventory')){
			$this->form_validation->set_rules('category', 'Category', 'required|trim');
			$this->form_validation->set_rules('item_id', 'Item', 'required|trim');
			$this->form_validation->set_rules('sku', 'SKU', 'required|trim');
			$this->form_validation->set_rules('unit_type', 'Unit Type', 'required|trim');
			$this->form_validation->set_rules('quantity', 'Quantity', 'required|trim|numeric');
			$this->form_validation->set_rules('buying_price', 'Buying Price', 'required|trim');
			$this->form_validation->set_rules('selling_price', 'Selling Price', 'required|trim');
			$this->form_validation->set_rules('po_ref_no', 'PO Ref No', 'required|trim');

			if($this->form_validation->run() == true){
				$con = array(
					'returnType' => 'count',
					'conditions' => array(
						'del' 	=> false,
						'sku'	=> strtoupper($this->input->post('sku'))
					)
				);

				$inventoryCnt = $this->inventory->getRows($con);
				if($inventoryCnt > 0){
					$data['error_msg'] = 'SKU ' .strtoupper($this->input->post('sku')). ' already exists';
				}else{
					$inventory = array(
						'id'			=> uniqid('', true),
						'item_id'		=> strtoupper($this->input->post('item_id')),
						'sku'			=> strtoupper($this->input->post('sku')),
						'unit_type'		=> strtoupper($this->input->post('unit_type')),
						'quantity'		=> $this->input->post('quantity'),
						'buying_price'	=> $this->input->post('buying_price'),
						'selling_price'	=> $this->input->post('selling_price'),
						'po_ref_no'		=> strtoupper($this->input->post('po_ref_no'))
						);
					$this->inventory->insert($inventory);

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
		$data['brands'] = $this->brand->getRows($con);
		$data['unit_types'] = $this->unit_type->getRows($con);

		$this->load->view('components/header', $data);
		$this->load->view('inventories/add', $data);
		$this->load->view('components/footer');
	}

	public function inventories_page(){
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$con = array(
			'returnType' => 'list',
			'conditions' => array(
				'inv.del' => false
			)
		);
		$inventoryList = $this->inventory->getRowsJoin($con);

		$data = array();
		
		foreach($inventoryList->result_array() as $r) {
		   $data[] = array(
		        $r['SKU'],
		        $r['ITEM'],
		        $r['CATEGORY'],
		        $r['QUANTITY'],
		        $r['UNIT_TYPE'],
		        $r['BUYING_PRICE'],
		        $r['SELLING_PRICE'],
		        $r['PO_REF_NO']
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