<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Sales_On_Hold_Dtls extends CI_Controller {

	public function __construct(){
		parent::__construct();

		$this->load->model('sales_on_hold_model');
		$this->load->model('sales_on_hold_dtls_model');
	
		$this->isLoggedIn = $this->session->userdata('isLoggedIn');
	}

	public function index(){
		if($this->isLoggedIn){
			redirect('sales_on_hold_dtls/view');
		}else{
			redirect('users/login');
		}
	}


	public function sales_on_hold_dtls_page($customer_name = null){
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$con = array(
				'returnType' => 'list'
			);

		if($customer_name){
			$con = array(
				'returnType' => 'list',
				'conditions' => array(
					'hold.cust_name' => $customer_name
				)
			);
		}
		$salesList = $this->sales_on_hold_dtls_model->getRowsJoin($con);

		$data = array();
		
		foreach($salesList->result_array() as $r) {

		   $data[] = array(
		        $r['INVENTORY_ID'],
		        $r['ITEM_NAME'],
		        $r['UNIT_PRICE'],
		        $r['QUANTITY'],
		        $r['SUB_TOTAL'],
		        $r['STOCKS'],
		        $r['SALES_ON_HOLD_ID']
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
