<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Purchase_Orders extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->model('purchase_order');
		$this->load->model('purchase_order_dtl');
		$this->load->model('supplier');
		$this->load->model('model');

		$this->isLoggedIn = $this->session->userdata('isLoggedIn');
	}

	public function index(){
		if($this->isLoggedIn){
			redirect('purchase_orders/view');
		}else{
			redirect('users/login');
		}
	}

	public function view(){
		$data = array();
		$data['session_user'] = $this->session->userdata('username');

		$footer_data = array();
		$footer_data['page_has_table'] = 'has_table';
		$footer_data['site_url'] = 'purchase_orders/purchase_orders_page';
		
		$this->load->view('components/header', $data);
		$this->load->view('purchase_orders/view', $data);
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

		
		if($this->input->post('submit_purchase_order')){
			$this->form_validation->set_rules('supplier_id', 'Supplier', 'required|trim');
			$this->form_validation->set_rules('expected_dt', 'Expected Date', 'required|trim');
			$this->form_validation->set_rules('input_hidden_po_items', 'Items', 'required|trim');

			if($this->form_validation->run() == true){
				$po_items = array();
				$po_items = json_decode($this->input->post('input_hidden_po_items'));

				$ref_no = 'PO-' . date('YmdHis');
				$id = uniqid('', true);
				
				$po = array(
					'id'		=> $id,
					'ref_no' => $ref_no,
					'status' => 'PENDING',
					'ordered_dt' => date('Y-m-d'),
					'expected_dt' => date('Y-m-d', strtotime($this->input->post('expected_dt'))),
					'ordered_by' => $this->session->userdata('username'),
					'supplier_id' => $this->input->post('supplier_id'),
					'notes' => $this->input->post('notes')
				);

				$insert_id = $this->purchase_order->insert($po);

				if(!$insert_id){
					foreach($po_items as $item) {
						$po_dtl = array(
							'id'		=> uniqid('', true),
							'purchase_order_id' => $id,
							'model_id' => $item->model_id,
							'quantity' => $item->quantity,
							'unit_price' => $item->unit_price
						);

						$this->purchase_order_dtl->insert($po_dtl);
					 
					}

					redirect(current_url());

				}else{
					$data['error_msg'] = 'Failed to save Purchase Order.';
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
		$data['suppliers'] = $this->supplier->getRows($con);
		$data['models'] = $this->model->getRows($con);

		$this->load->view('components/header', $data);
		$this->load->view('purchase_orders/add', $data);
		$this->load->view('components/footer');
	}


	public function purchase_orders_page(){
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$con = array(
			'returnType' => 'list',
			'conditions' => array(
				'po.del' => false
			)
		);
		$purchaseOrderList = $this->purchase_order->getRowsJoin($con);

		$data = array();
		
		foreach($purchaseOrderList->result_array() as $r) {

		   $data[] = array(
		        $r['REF_NO'],
		        $r['SUPPLIER_NAME'],
		        $r['ORDERED_DT'],
		        $r['ORDERED_BY'],
		        $r['EXPECTED_DT'],
		        $r['STATUS']
		   );
		}

		$output = array(
		   "draw" => $draw,
		     "recordsTotal" => $purchaseOrderList->num_rows(),
		     "recordsFiltered" => $purchaseOrderList->num_rows(),
		     "data" => $data
		);
		echo json_encode($output);
		exit();
     }


}