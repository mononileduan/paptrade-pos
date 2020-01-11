<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Purchase_Orders_Dtl extends CI_Controller {

	public function __construct(){
		parent::__construct();

		$this->load->model('purchase_order');
		$this->load->model('purchase_order_dtl');
	
		$this->isLoggedIn = $this->session->userdata('isLoggedIn');
	}

	public function index(){
		if($this->isLoggedIn){
			redirect('purchase_orders_dtl/view');
		}else{
			redirect('users/login');
		}
	}

	public function view($refno = null){
		$data = array();
		$data['session_user'] = $this->session->userdata('username');

		$con = array(
			'returnType' => 'single',
			'conditions' => array(
				'po.del' => false,
				'po.REF_NO' => $refno
			)
		);
		$data['po'] = $this->purchase_order->getRowsJoin($con)->row_array();

		$con = array(
			'returnType' => 'list',
			'conditions' => array(
				'po_dtl.del' => false,
				'PURCHASE_ORDER_ID' => $data['po']['ID']
			)
		);
		$data['po_items'] = $this->purchase_order_dtl->getRowsJoin($con);

		$footer_data = array();
		$footer_data['page_has_table'] = 'no_table';
		$footer_data['site_url'] = '';
		
		$this->load->view('components/header', $data);
		$this->load->view('purchase_orders_dtl/view', $data);
		$this->load->view('components/footer', $footer_data);
	}

}
