<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Sales extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->model('sales_model');
		$this->load->model('sales_dtls_model');
		$this->load->model('branch_inventory');
		$this->load->model('branch_inventory_hist');
		$this->load->model('sales_temp');
		$this->load->model('sales_temp_dtls');

		$this->isLoggedIn = $this->session->userdata('isLoggedIn');
	}

	public function index(){
		if($this->isLoggedIn){

			$this->load->view('sales/index');
	
		}else{
			redirect('users/login');
		}
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
				'grand_total' => $this->input->post('grand_total'),
				'payment' => $this->input->post('payment')
			);

			$insert_id = $this->sales_model->insert($sales);

			if(!$insert_id){

				foreach($this->input->post('sales') as $item) {
					$con = array(
						'returnType' => 'single',
						'conditions' => array(
							'inv.del' => false,
							'inv.id' => $item['inventory_id']
						)
					);
					$inventory = $this->branch_inventory->getRowsJoin($con)->row_array();

					if($inventory){
						$quantity = $inventory['QTY'];
						$newVal = array(
							'qty'		=> $quantity - $item['quantity']
						);
						$this->branch_inventory->update($inventory['ID'], $newVal);

						$branch_inventory_hist = array(
							'id'			=> uniqid('', true),
							'branch_id'		=> $this->session->userdata('branch_id'),
							'inventory_id'	=> $inventory['ID'],
							'item'			=> $inventory['ITEM'],
							'qty' 			=> $item['quantity'],
							'qty_running'	=> $quantity - $item['quantity'],
							'movement' 		=> 'OUT',
							'updated_by'	=> $this->session->userdata('username'),
							'updated_dt'	=> date('YmdHis'),
							'remarks'		=> 'Sales '.$ref_no
							);
						$this->branch_inventory_hist->insert($branch_inventory_hist);
						
						$sales_dtl = array(
							'id'		=> uniqid('', true),
							'sales_id' => $id,
							'branch_inventory_id' => $inventory['ID'],
							'unit_price' => $item['unit_price'],
							'quantity' => $item['quantity']
						);
						$this->sales_dtls_model->insert($sales_dtl);


						$con = array( 'conditions' => array( 'sales_temp_id' => $this->input->post('sales_temp_id') ) );
						$this->sales_temp_dtls->delete($con);
						$this->sales_temp->delete($this->input->post('sales_temp_id'));

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
				$data['error_msg'] = 'Failed to save Sales Order.';
				echo '';
				exit();
			}
		}

		$this->load->view('pos/index', $data);
	}


	public function list(){
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
		        $r['ID'],
		        $r['BRANCH'],
		        $r['CREATED_DT'],
		        $r['REF_NO'],
		        $r['GRAND_TOTAL'],
		        $r['PAYMENT'],
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


     public function details($id = null){
    	if($this->isLoggedIn){
    		$data = array();

    		$con = array(
				'returnType' => 'single',
				'conditions' => array(
					'sales.id' => $id
				)
			);
    		$data['hdr'] = $this->sales_model->getRowsJoin($con)->row_array();

    		$con = array(
				'conditions' => array(
					'dtl.sales_id' => $id
				)
			);
    		$data['dtl'] = $this->sales_dtls_model->getRowsJoin($con);

			$this->load->view('sales/details', $data);
			
    	}else{
			redirect('users/login');
		}
    }

}