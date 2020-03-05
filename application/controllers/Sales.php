<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Sales extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->model('sales_model');
		$this->load->model('sales_dtls_model');
		$this->load->model('inventory_branch');
		$this->load->model('sales_on_hold_model');
		$this->load->model('sales_on_hold_dtls_model');

		$this->isLoggedIn = $this->session->userdata('isLoggedIn');
	}

	public function index(){
		if($this->isLoggedIn){
			redirect('sales/view');
		}else{
			redirect('users/login');
		}
	}

	public function view(){
		$data = array();
		$data['session_user'] = $this->session->userdata('username');

		$footer_data = array();
		$footer_data['page_has_table'] = 'has_table';
		$footer_data['site_url'] = 'sales/sales_page';
		$footer_data['view_dtl'] = true;
		$footer_data['view_dtl_url'] = '/sales_dtl/view/';
		$footer_data['right_align_columns'] = array(-3);
		
		$this->load->view('components/header', $data);
		$this->load->view('sales/view', $data);
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

		if($this->input->post('process_sales')){
			$ref_no = date('YmdHis');
			$id = uniqid('', true);
			
			$sales = array(
				'id' => $id,
				'ref_no' => $ref_no,
				'branch_id' => $this->session->userdata('branch_id'),
				'grand_total' => $this->input->post('grand_total')
			);

			$insert_id = $this->sales_model->insert($sales);

			if(!$insert_id){

				foreach($this->input->post('sales') as $item) {
					$con = array(
						'returnType' => 'single',
						'conditions' => array(
							'del' => false,
							'inventory_id' => $item['inventory_id']
						)
					);

					$inventory = $this->inventory_branch->getRows($con);

					if($inventory){
						$quantity = $inventory['QUANTITY'];
						$newVal = array(
							'quantity'		=> $quantity - $item['quantity']
						);
						$this->inventory_branch->update($inventory['ID'], $newVal);
						
						$sales_dtl = array(
							'id'		=> uniqid('', true),
							'sales_id' => $id,
							'inventories_branch_id' => $inventory['ID'],
							'unit_price' => $item['unit_price'],
							'quantity' => $item['quantity']
						);

						$this->sales_dtls_model->insert($sales_dtl);
					}else{
						$data['error_msg'] = 'Failed to save.';
					}
				 
				}

				if($this->input->post('sales_on_hold_id')){
					$deleted = $this->sales_on_hold_dtls_model->delete(array('sales_on_hold_id' => $this->input->post('sales_on_hold_id')));
					$deleted = $this->sales_on_hold_model->delete(array('id' => $this->input->post('sales_on_hold_id')));
				}

				echo $ref_no;
				exit();

			}else{
				$data['error_msg'] = 'Failed to save Purchase Order.';
			}
		}

		$this->load->view('pos/dashboard', $data);
	}


	public function sales_page(){
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$con = array(
			'returnType' => 'list',
			'conditions' => array(
				'sales.del' => false,
				'sales.branch_id' => $this->session->userdata('branch_id')
			)
		);
		$salesList = $this->sales_model->getRowsJoin($con);

		$data = array();
		
		foreach($salesList->result_array() as $r) {

		   $data[] = array(
		        $r['REF_NO'],
		        $r['CREATED_DT'],
		        $r['GRAND_TOTAL'],
		        $r['CREATED_BY']
		   );
		}

		$output = array(
		   "draw" => $draw,
		     "recordsTotal" => $salesList->num_rows(),
		     "recordsFiltered" => $salesList->num_rows(),
		     "data" => $data
		);
		echo json_encode($output);
		exit();
     }


}