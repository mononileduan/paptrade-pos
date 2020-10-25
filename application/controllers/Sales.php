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
		$this->load->model('branch');
		$this->load->model('user');

		$this->isLoggedIn = $this->session->userdata('isLoggedIn');
	}

	public function index(){
		if($this->isLoggedIn && $this->session->userdata('status') == $this->config->item('USER_STATUS_ASSOC')['ACTIVE'][0]){
			if(in_array('SALES', $this->config->item('USER_ROLE_ASSOC_MENU')[$this->session->userdata('user_role')])){

				$con = array(
					'returnType' => 'list',
					'conditions' => array(
						'del' => false
					)
				);

				$data['branches'] = $this->branch->getRows($con);

				if($this->config->item('USER_ROLE_ASSOC')[$this->session->userdata('user_role')][0] == 'BRANCH_USER'){
					$con = array(
						'returnType' => 'list',
						'conditions' => array(
							'u.del' => false,
							'branch_id' => $this->session->userdata('branch_id')
						),
						'sort' => array('b.branch_name')
					);
					$data['cashiers'] = $this->user->getRowsJoin($con);
				}else{
					$con = array(
						'returnType' => 'list',
						'conditions' => array(
							'u.del' => false
						),
						'sort' => array('b.branch_name')
					);
					$data['cashiers'] = $this->user->getRowsJoin($con);
				}

				$con = array(
					'returnType' => 'list',
					'conditions' => array(
					)
				);
				$data['total_sales'] = $this->sales_model->getTotalAmt($con)['GRAND_TOTAL'];

				$this->load->view('sales/index', $data);
	
			}else{
				$this->load->view('components/unauthorized');
			}
		}else{
			redirect('users/logout');
		}
	}


	public function add(){
		if($this->isLoggedIn && $this->session->userdata('status') == $this->config->item('USER_STATUS_ASSOC')['ACTIVE'][0] 
			&& in_array('POS', $this->config->item('USER_ROLE_ASSOC_MENU')[$this->session->userdata('user_role')])){
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


						$txn = $this->sales_model->getRowsJoin(array('conditions' => array('sales.id' => $id)))->row_array();
						$response = array(
							"ref_no" => $txn['REF_NO'],
							"txn_dt" => $txn['CREATED_DT'],
							"cashier" => $txn['CREATED_BY']
						);
						echo json_encode($response);
						exit();

					}else{
						$data['error_msg'] = 'Failed to save Sales Order.';
						echo '';
						exit();
					}
				}

				$this->load->view('pos/index', $data);

		}else{
			$this->load->view('components/unauthorized');
		}
	}


	public function list(){
		if($this->isLoggedIn && $this->session->userdata('status') == $this->config->item('USER_STATUS_ASSOC')['ACTIVE'][0] 
			&& in_array('SALES', $this->config->item('USER_ROLE_ASSOC_MENU')[$this->session->userdata('user_role')])){

			// Datatables Variables
			$draw = intval($this->input->get("draw"));
			$start = intval($this->input->get("start"));
			$length = intval($this->input->get("length"));

			$con = array(
				'returnType' => 'list',
				'conditions' => array(
					'sales.del' => false
				)
			);

			if($this->input->get("branchId") !== null){
				$con['conditions']['sales.branch_id'] = $this->input->get("branchId");
			}
			if($this->input->get("refno") !== null){
				$con['conditions']['sales.ref_no'] = $this->input->get("refno");
			}
			if($this->input->get("tranDtFrom") !== null){
				$con['conditions']['tranDtFrom'] = $this->input->get("tranDtFrom") . ' 00:00:00';
			}
			if($this->input->get("tranDtTo") !== null){
				$con['conditions']['tranDtTo'] = $this->input->get("tranDtTo") . ' 23:59:59';
			}
			if($this->input->get("tranAmt") !== null){
				$con['conditions']['sales.GRAND_TOTAL'] = $this->input->get("tranAmt");
			}
			if($this->input->get("cashier") !== null){
				$con['conditions']['sales.CREATED_BY'] = $this->input->get("cashier");
			}

			$salesList = $this->sales_model->getRowsJoin($con);

			$data = array();
			
			foreach($salesList->result_array() as $r) {

			   $data[] = array(
			        $r['ID'],
			        $r['BRANCH'],
			        $r['CREATED_DT'],
			        $r['REF_NO'],
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

		}else{
			$this->load->view('components/unauthorized');
		}
    }


	public function list_totalamt(){
		if($this->isLoggedIn && $this->session->userdata('status') == $this->config->item('USER_STATUS_ASSOC')['ACTIVE'][0] 
			&& in_array('SALES', $this->config->item('USER_ROLE_ASSOC_MENU')[$this->session->userdata('user_role')])){

			$con = array(
				'returnType' => 'list',
				'conditions' => array(
				)
			);

			if($this->input->get("branchId") !== null){
				$con['conditions']['branch_id'] = $this->input->get("branchId");
			}
			if($this->input->get("refno") !== null){
				$con['conditions']['ref_no'] = $this->input->get("refno");
			}
			if($this->input->get("tranDtFrom") !== null){
				$con['conditions']['tranDtFrom'] = $this->input->get("tranDtFrom") . ' 00:00:00';
			}
			if($this->input->get("tranDtTo") !== null){
				$con['conditions']['tranDtTo'] = $this->input->get("tranDtTo") . ' 23:59:59';
			}
			if($this->input->get("tranAmt") !== null){
				$con['conditions']['GRAND_TOTAL'] = $this->input->get("tranAmt");
			}
			if($this->input->get("cashier") !== null){
				$con['conditions']['CREATED_BY'] = $this->input->get("cashier");
			}

			$salesTotal = $this->sales_model->getTotalAmt($con);
			echo json_encode($salesTotal);
			exit();

		}else{
			$this->load->view('components/unauthorized');
		}
    }


	public function pos_list(){
		if($this->isLoggedIn && $this->session->userdata('status') == $this->config->item('USER_STATUS_ASSOC')['ACTIVE'][0] 
			&& in_array('POS', $this->config->item('USER_ROLE_ASSOC_MENU')[$this->session->userdata('user_role')])){

			// Datatables Variables
			$draw = intval($this->input->get("draw"));
			$start = intval($this->input->get("start"));
			$length = intval($this->input->get("length"));

			$con = array(
				'returnType' => 'list',
				'conditions' => array(
					'sales.del' => false,
					'sales.branch_id' => $this->session->userdata('branch_id'),
					'sales.created_by' => $this->session->userdata('username')
				)
			);
			$salesList = $this->sales_model->getPosViewSales($con);

			$data = array();
			
			foreach($salesList->result_array() as $r) {

			   $data[] = array(
			        $r['ID'],
			        $r['REF_NO'],
			        $r['GRAND_TOTAL'],
			        $r['PAYMENT'],
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

		}else{
			$this->load->view('components/unauthorized');
		}
    }


	public function dtls_list(){
		if($this->isLoggedIn && $this->session->userdata('status') == $this->config->item('USER_STATUS_ASSOC')['ACTIVE'][0] 
			&& in_array('POS', $this->config->item('USER_ROLE_ASSOC_MENU')[$this->session->userdata('user_role')])){

			// Datatables Variables
			$draw = intval($this->input->get("draw"));
			$start = intval($this->input->get("start"));
			$length = intval($this->input->get("length"));

    		$con = array(
				'conditions' => array(
					'dtl.sales_id' => $this->input->get("id")
				)
			);
			$salesList = $this->sales_dtls_model->getRowsJoin($con);

			$data = array();
			
			foreach($salesList->result_array() as $r) {

			   $data[] = array(
			        $r['ITEM'],
			        $r['UNIT_PRICE'],
			        $r['QUANTITY'],
			        $r['SUB_TOTAL']
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

		}else{
			$this->load->view('components/unauthorized');
		}
    }


    public function details($id = null){
    	if($this->isLoggedIn && $this->session->userdata('status') == $this->config->item('USER_STATUS_ASSOC')['ACTIVE'][0]){
			if(in_array('SALES', $this->config->item('USER_ROLE_ASSOC_MENU')[$this->session->userdata('user_role')])
				|| in_array('POS', $this->config->item('USER_ROLE_ASSOC_MENU')[$this->session->userdata('user_role')])){
	    		$data = array();

	    		$con = array(
					'returnType' => 'single',
					'conditions' => array(
						'sales.id' => $this->input->get("id")
					)
				);
	    		$data['hdr'] = $this->sales_model->getRowsJoin($con)->row_array();

	    		$con = array(
					'conditions' => array(
						'dtl.sales_id' => $this->input->get("id")
					)
				);
	    		$data['dtl'] = $this->sales_dtls_model->getRowsJoin($con);

				$this->load->view('sales/details', $data);

			}else{
				$this->load->view('components/unauthorized');
			}
		}else{
			redirect('users/logout');
		}
    }

}