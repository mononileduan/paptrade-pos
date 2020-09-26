<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Supply_Requests extends CI_Controller {

	public function __construct(){
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->model('supply_request');
		$this->load->model('warehouse_inventory');
		$this->load->model('warehouse_inventory_hist');
		$this->load->model('branch_inventory');
		$this->load->model('branch_inventory_hist');

		$this->isLoggedIn = $this->session->userdata('isLoggedIn');
	}

	public function index(){
		if($this->isLoggedIn && $this->session->userdata('status') == $this->config->item('USER_STATUS_ASSOC')['ACTIVE'][0]){
			redirect('users/dashboard');
			
		}else{
			redirect('users/logout');
		}
	}

	public function view(){
		if($this->isLoggedIn && $this->session->userdata('status') == $this->config->item('USER_STATUS_ASSOC')['ACTIVE'][0]){
			if(in_array('WH_SUPPLY_REQUEST', $this->config->item('USER_ROLE_ASSOC_MENU')[$this->session->userdata('user_role')])
			|| in_array('BR_SUPPLY_REQUEST', $this->config->item('USER_ROLE_ASSOC_MENU')[$this->session->userdata('user_role')])){
				
				$con = array(
					'returnType' => 'single',
					'conditions' => array(
						'del' => false,
						'id' => $this->input->get('id')
					));
				$statusObj= $this->supply_request->getRows($con);

				$con = array(
					'returnType' => 'single',
					'conditions' => array(
						'sr.del' => false,
						'sr.id' => $this->input->get('id')
					),
					'status' => $statusObj['STATUS']
				);
				$data['req'] = $this->supply_request->getRowsJoin($con)->row_array();
				$data['return_page'] = $this->input->get('return');
				$this->load->view('supply_requests/view', $data);

			}else{
				$this->load->view('components/unauthorized');
			}
		}else{
			redirect('users/logout');
		}
	}





	public function branch(){
		if($this->isLoggedIn && $this->session->userdata('status') == $this->config->item('USER_STATUS_ASSOC')['ACTIVE'][0]){
			if(in_array('BR_SUPPLY_REQUEST', $this->config->item('USER_ROLE_ASSOC_MENU')[$this->session->userdata('user_role')])){
				$data = array();
				$data['success_msg'] = $this->session->flashdata('success_msg');

				if($this->input->post('submit_delete')){
					$this->form_validation->set_rules('id', 'Supply Request', 'required|trim');

					if($this->form_validation->run() == true){
						if($this->supply_request->delete($this->input->post('id'))){
							echo 'OK';
							exit();
						}else{
							echo 'Could not delete Supply Request. ID does not exist.';
							exit();
						}					
					}
				}
				
				$this->load->view('supply_requests/branch', $data);

			}else{
				$this->load->view('components/unauthorized');
			}
		}else{
			redirect('users/logout');
		}
	}

	public function branch_list(){
		if($this->isLoggedIn && $this->session->userdata('status') == $this->config->item('USER_STATUS_ASSOC')['ACTIVE'][0] 
			&& in_array('BR_SUPPLY_REQUEST', $this->config->item('USER_ROLE_ASSOC_MENU')[$this->session->userdata('user_role')])){
			// Datatables Variables
			$draw = intval($this->input->get("draw"));
			$start = intval($this->input->get("start"));
			$length = intval($this->input->get("length"));

			$con = array(
				'returnType' => 'list',
				'conditions' => array()
			);
			if($this->session->userdata('user_role') != $this->config->item('USER_ROLE_ASSOC')['SYS_ADMIN'][0]){
				$con = array(
					'returnType' => 'list',
					'conditions' => array(
						'sr.branch_id' => $this->session->userdata('branch_id')
					)
				);
			}
			$srequestList = $this->supply_request->getRowsJoin($con);

			$data = array();
			
			foreach($srequestList->result_array() as $r) {

			   $data[] = array(
			   		$r['ID'],
			        $r['REQUESTED_DT'],
			        $r['ITEM'],
			        $r['QTY'],
			        $r['BRANCH'],
			        $r['REQUESTED_BY'],
			        $r['STATUS']
			   );
			}

			$output = array(
			   "draw" => $draw,
			     "recordsTotal" => $srequestList->num_rows(),
			     "recordsFiltered" => $srequestList->num_rows(),
			     "data" => $data
			);
			echo json_encode($output);
			exit();
		}else{
			$this->load->view('components/unauthorized');
		}
    }


	public function receive(){
		if($this->isLoggedIn && $this->session->userdata('status') == $this->config->item('USER_STATUS_ASSOC')['ACTIVE'][0]){
			if(in_array('BR_SUPPLY_REQUEST', $this->config->item('USER_ROLE_ASSOC_MENU')[$this->session->userdata('user_role')])){
				$data = array();
				$data['session_user'] = $this->session->userdata('username');

				if($this->input->post('submit_receive_request')){
					$this->form_validation->set_rules('id', 'ID', 'required|trim');
					$this->form_validation->set_rules('approved_qty', 'Approved Quantity', 'required|trim|is_natural');

					if($this->form_validation->run() == true){
						$con = array(
							'returnType' => 'single',
							'conditions' => array(
								'del' 	=> false,
								'id'	=> $this->input->post('id'),
								'status' => 'APPROVED'
							)
						);
						$request = $this->supply_request->getRows($con);

						if($request){
							$con = array(
								'returnType' => 'single',
								'conditions' => array(
									'item_id' => $request['ITEM_ID']
								)
							);
							$wh_item = $this->warehouse_inventory->getRowsJoin($con)->row_array(); //get item from warehouse inventory
							if($wh_item){
								if($wh_item['CURRENT_QTY'] >= $this->input->post('approved_qty')){
									$newVal = array(
										'current_qty'	=> $wh_item['CURRENT_QTY'] - $this->input->post('approved_qty')
									);
									$this->warehouse_inventory->update($wh_item['ID'], $newVal);


									$inventory_hist = array(
										'id'			=> uniqid('', true),
										'inventory_id'	=> $wh_item['ID'],
										'item'			=> $wh_item['ITEM'],
										'qty' 			=> $this->input->post('approved_qty'),
										'qty_running'	=> $wh_item['CURRENT_QTY'] - $this->input->post('approved_qty'),
										'movement' 		=> 'OUT',
										'updated_by'	=> $this->session->userdata('username'),
										'updated_dt'	=> date('YmdHis'),
										'remarks'		=> 'Supply Request of '.$this->input->post('branch')
										);
									$this->warehouse_inventory_hist->insert($inventory_hist);

									$con = array(
										'returnType' => 'single',
										'conditions' => array(
											'item_id' => $request['ITEM_ID'],
											'branch_id' => $request['BRANCH_ID']
										)
									);
									$br_item = $this->branch_inventory->getRowsJoin($con)->row_array(); //get item from branch inventory
									if($br_item){ //update
										$newVal = array(
											'qty'	=> $br_item['QTY'] + $this->input->post('approved_qty')
										);
										$this->branch_inventory->update($br_item['ID'], $newVal);

										$branch_inventory_hist = array(
											'id'			=> uniqid('', true),
											'branch_id'		=> $this->session->userdata('branch_id'),
											'inventory_id'	=> $br_item['ID'],
											'item'			=> $br_item['ITEM'],
											'qty' 			=> $this->input->post('approved_qty'),
											'qty_running'	=> $br_item['QTY'] + $this->input->post('approved_qty'),
											'movement' 		=> 'IN',
											'updated_by'	=> $this->session->userdata('username'),
											'updated_dt'	=> date('YmdHis'),
											'remarks'		=> 'Add from Supply Request'
											);
										$this->branch_inventory_hist->insert($branch_inventory_hist);

									}else{ //insert
										$branch_inv_id = uniqid('', true);
										$inventory = array(
											'id'		=> $branch_inv_id,
											'branch_id'	=> $this->session->userdata('branch_id'),
											'item_id'	=> $wh_item['ITEM_ID'],
											'qty'		=> $this->input->post('approved_qty'),
											'critical_qty' => $wh_item['ITEM_CRIT_QTY']
										);
										$this->branch_inventory->insert($inventory);

										$branch_inventory_hist = array(
											'id'			=> uniqid('', true),
											'branch_id'		=> $this->session->userdata('branch_id'),
											'inventory_id'	=> $branch_inv_id,
											'item'			=> $wh_item['ITEM'],
											'qty' 			=> $this->input->post('approved_qty'),
											'qty_running'	=> $this->input->post('approved_qty'),
											'movement' 		=> 'IN',
											'updated_by'	=> $this->session->userdata('username'),
											'updated_dt'	=> date('YmdHis'),
											'remarks'		=> 'Initial from Supply Request'
											);
										$this->branch_inventory_hist->insert($branch_inventory_hist);
									}


									$newVal = array(
										'received_by'	=> $this->session->userdata('username'),
										'received_dt'	=> date('YmdHis'),
										'status'		=> 'RECEIVED'
									);
									$this->supply_request->update($request['ID'], $newVal); //update supply request

									$this->session->set_flashdata('success_msg', 'Request successfully received!');
									redirect('supply_requests/branch');

								}else{
									$data['error_msg'] = 'Insufficient warehouse stocks';
								}
							}else{
								$data['error_msg'] = 'Could not find item from warehouse inventory';
							}
						}else{
							$data['error_msg'] = 'Could not find request';
						}
					}else{
						$data['error_msg'] = 'Please fill all required fields.';
					}
				}

				$con = array(
					'returnType' => 'single',
					'conditions' => array(
						'del' => false,
						'id' => $this->input->get('id')
					));
				$statusObj= $this->supply_request->getRows($con);

				$con = array(
					'returnType' => 'single',
					'conditions' => array(
						'sr.del' => false,
						'sr.id' => $this->input->get('id')
					),
					'status' => $statusObj['STATUS']
				);
				$data['req'] = $this->supply_request->getRowsJoin($con)->row_array();
				
				$this->load->view('supply_requests/receive', $data);

			}else{
				$this->load->view('components/unauthorized');
			}
		}else{
			redirect('users/logout');
		}
	}


	public function add(){
		if($this->isLoggedIn && $this->session->userdata('status') == $this->config->item('USER_STATUS_ASSOC')['ACTIVE'][0]){
			if(in_array('BR_SUPPLY_REQUEST', $this->config->item('USER_ROLE_ASSOC_MENU')[$this->session->userdata('user_role')])){

				$data = array();
				$data['success_msg'] = $this->session->flashdata('success_msg');


				if($this->input->post('submit_requests')){
					foreach($this->input->post('requests') as $item) {
						$req = array(
							'id'		=> uniqid('', true),
							'item_id'	=> $item['item_id'],
							'qty'		=> $item['quantity'],
							'requested_by'	=> $this->session->userdata('username'),
							'branch_id' => $this->session->userdata('branch_id'),
							'status'	=> 'NEW'
						);
						$this->supply_request->insert($req);			 
					}
					echo 'OK';
					exit();
				}

				$con = array(
					'returnType' => 'list',
					'conditions' => array()
				);
				$data['items'] = $this->warehouse_inventory->getRowsJoin($con);
				$data['item_id'] = $this->input->get('item_id');
				
				$this->load->view('supply_requests/add', $data);

			}else{
				$this->load->view('components/unauthorized');
			}
		}else{
			redirect('users/logout');
		}
	}


	public function wh_item_list(){
		if($this->isLoggedIn && $this->session->userdata('status') == $this->config->item('USER_STATUS_ASSOC')['ACTIVE'][0] 
			&& in_array('BR_SUPPLY_REQUEST', $this->config->item('USER_ROLE_ASSOC_MENU')[$this->session->userdata('user_role')])){

			// Datatables Variables
			$draw = intval($this->input->get("draw"));
			$start = intval($this->input->get("start"));
			$length = intval($this->input->get("length"));

			$con = array();

			if($this->input->get('item_id') !== null && $this->input->get('item_id') !== ''){
				$con = array('conditions' => array('item_id' => $this->input->get('item_id')));
			}
			$inventoryList = $this->warehouse_inventory->getRowsJoin($con);

			$data = array();
			
			foreach($inventoryList->result_array() as $r) {

			   $data[] = array(
			   		$r['ID'],
			   		$r['ITEM_ID'],
			        $r['ITEM'],
			        $r['CATEGORY'],
			        $r['AVAILABLE_QTY']
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

		}else{
			$this->load->view('components/unauthorized');
		}
    }


	public function warehouse(){
		if($this->isLoggedIn && $this->session->userdata('status') == $this->config->item('USER_STATUS_ASSOC')['ACTIVE'][0]){
			if(in_array('WH_SUPPLY_REQUEST', $this->config->item('USER_ROLE_ASSOC_MENU')[$this->session->userdata('user_role')])){
				$data = array();
				$data['success_msg'] = $this->session->flashdata('success_msg');

				$data['id'] = $this->input->get('id');
				
				$this->load->view('supply_requests/warehouse', $data);

			}else{
				$this->load->view('components/unauthorized');
			}
		}else{
			redirect('users/logout');
		}
	}

	public function warehouse_list(){
		if($this->isLoggedIn && $this->session->userdata('status') == $this->config->item('USER_STATUS_ASSOC')['ACTIVE'][0] 
			&& in_array('WH_SUPPLY_REQUEST', $this->config->item('USER_ROLE_ASSOC_MENU')[$this->session->userdata('user_role')])){
			// Datatables Variables
			$draw = intval($this->input->get("draw"));
			$start = intval($this->input->get("start"));
			$length = intval($this->input->get("length"));

			$array_cond = array();

			if($this->input->get('status') !== null){
				$array_cond['sr.status'] = $this->input->get('status');
			}

			if($this->input->get('id') !== null && $this->input->get('id') !== ''){
				$array_cond['sr.id'] = $this->input->get('id');
			}

			$con = array('conditions' => $array_cond);

			$srequestList = $this->supply_request->getRowsJoin($con);

			$data = array();
			
			foreach($srequestList->result_array() as $r) {

			   $data[] = array(
			   		$r['ID'],
			        $r['REQUESTED_DT'],
			        $r['ITEM'],
			        $r['QTY'],
			        $r['BRANCH'],
			        $r['REQUESTED_BY'],
			        $r['STATUS']
			   );
			}

			$output = array(
			   "draw" => $draw,
			     "recordsTotal" => $srequestList->num_rows(),
			     "recordsFiltered" => $srequestList->num_rows(),
			     "data" => $data
			);
			echo json_encode($output);
			exit();
		}else{
			$this->load->view('components/unauthorized');
		}
    }


	public function approve(){
		if($this->isLoggedIn && $this->session->userdata('status') == $this->config->item('USER_STATUS_ASSOC')['ACTIVE'][0]){
			if(in_array('WH_SUPPLY_REQUEST', $this->config->item('USER_ROLE_ASSOC_MENU')[$this->session->userdata('user_role')])){
				$data = array();
				$data['session_user'] = $this->session->userdata('username');

				if($this->input->post('submit_approve_request')){
					$this->form_validation->set_rules('id', 'ID', 'required|trim');
					$this->form_validation->set_rules('approved_qty', 'Approved Quantity', 'required|trim|is_natural');

					if($this->form_validation->run() == true){
						$con = array(
							'returnType' => 'single',
							'conditions' => array(
								'del' 	=> false,
								'id'	=> $this->input->post('id'),
								'status' => 'NEW'
							)
						);
						$request = $this->supply_request->getRows($con);

						if($request){
							$con = array(
								'returnType' => 'single',
								'conditions' => array(
									'item_id' => $request['ITEM_ID']
								)
							);
							$wh_item = $this->warehouse_inventory->getRows($con); //get item from warehouse inventory
							if($wh_item){
								if($wh_item['AVAILABLE_QTY'] >= $this->input->post('approved_qty')){
									$newVal = array(
										'available_qty'	=> $wh_item['AVAILABLE_QTY'] - $this->input->post('approved_qty')
									);
									$this->warehouse_inventory->update($wh_item['ID'], $newVal);


									$newVal = array(
										'approved_qty'	=> $this->input->post('approved_qty'),
										'processed_by'	=> $this->session->userdata('username'),
										'processed_dt'	=> date('YmdHis'),
										'status'		=> 'APPROVED'
									);
									$this->supply_request->update($request['ID'], $newVal); //update supply request

									$this->session->set_flashdata('success_msg', 'Request successfully approved!');
									redirect('supply_requests/warehouse');

								}else{
									$data['error_msg'] = 'Insufficient warehouse stocks';
								}
							}else{
								$data['error_msg'] = 'Could not find item from warehouse inventory';
							}
						}else{
							$data['error_msg'] = 'Could not find request';
						}
					}else{
						$data['error_msg'] = 'Please fill all required fields.';
					}
				}

				$con = array(
					'returnType' => 'single',
					'conditions' => array(
						'del' => false,
						'id' => $this->input->get('id')
					));
				$statusObj= $this->supply_request->getRows($con);

				$con = array(
					'returnType' => 'single',
					'conditions' => array(
						'sr.del' => false,
						'sr.id' => $this->input->get('id')
					),
					'status' => $statusObj['STATUS']
				);
				$data['req'] = $this->supply_request->getRowsJoin($con)->row_array();

				$con = array(
					'returnType' => 'single',
					'conditions' => array(
						'inv.item_id' => $data['req']['ITEM_ID']
					)
				);
				$data['wh_item'] = $this->warehouse_inventory->getRowsJoin($con)->row_array();
				
				$this->load->view('supply_requests/approve', $data);
				
			}else{
				$this->load->view('components/unauthorized');
			}
		}else{
			redirect('users/logout');
		}
	}

}