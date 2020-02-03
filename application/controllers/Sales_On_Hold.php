<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Sales_On_Hold extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->model('sales_on_hold_model');
		$this->load->model('sales_on_hold_dtls_model');

		$this->isLoggedIn = $this->session->userdata('isLoggedIn');
	}

	public function index(){
		if($this->isLoggedIn){
			redirect('sales_on_hold/view');
		}else{
			redirect('users/login');
		}
	}

	public function view(){
		$data = array();
		$data['session_user'] = $this->session->userdata('username');

		$footer_data = array();
		$footer_data['page_has_table'] = 'has_table';
		$footer_data['site_url'] = 'sales_on_hold/sales_on_hold_page';
		$footer_data['view_dtl'] = true;
		$footer_data['view_dtl_url'] = '/sales_on_hold_dtls/view/';
		$footer_data['right_align_columns'] = array(-3);
		
		$this->load->view('components/header', $data);
		$this->load->view('sales_on_hold/view', $data);
		$this->load->view('components/footer', $footer_data);
	}

	public function add(){
		$data = array();
		$data['session_user'] = $this->session->userdata('username');
		
		if($this->input->post('save_sales_on_hold')){
			$con = array(
				'returnType' => 'count',
				'conditions' => array(
					'del' => false,
					'branch_id' => $this->session->userdata('branch_id'),
					'cust_name' => $this->input->post('customer_name')
				)
			);
			$salesCnt = $this->sales_on_hold_model->getRows($con);
			if($salesCnt > 0){
				echo $this->input->post('customer_name').' already exists';
			}else{
				$id = uniqid('', true);
				$sales = array(
					'id' => $id,
					'branch_id' => $this->session->userdata('branch_id'),
					'cust_name' => $this->input->post('customer_name'),
					'grand_total' => $this->input->post('grand_total')
				);

				$insert_id = $this->sales_on_hold_model->insert($sales);

				if(!$insert_id){

					foreach($this->input->post('sales') as $item) {
							
						$sales_dtl = array(
							'id'		=> uniqid('', true),
							'sales_on_hold_id' => $id,
							'inventory_id' => $item['inventory_id'],
							'item_name' => $item['item'],
							'unit_price' => $item['unit_price'],
							'quantity' => $item['quantity'],
							'sub_total' => $item['subtotal']
						);

						$this->sales_on_hold_dtls_model->insert($sales_dtl);
					 
					}
					echo 'OK';
					exit();

				}else{
					$data['error_msg'] = 'Failed to save Purchase Order.';
				}
			}
		}
	}


	public function sales_on_hold_page(){
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$con = array(
			'returnType' => 'list',
			'conditions' => array(
				'del' => false,
				'branch_id' => $this->session->userdata('branch_id')
			)
		);
		$salesList = $this->sales_on_hold_model->getRows($con);

		$data = array();
		
		foreach($salesList->result_array() as $r) {

		   $data[] = array(
		        $r['CUST_NAME'],
		        $r['GRAND_TOTAL'],
		        $r['CREATED_BY'],
		        $r['CREATED_DT']
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