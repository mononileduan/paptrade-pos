<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Supply_Requests extends CI_Controller {

	public function __construct(){
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->model('supply_request');
		$this->load->model('warehouse_inventory');
		$this->load->model('branch_inventory');

		$this->isLoggedIn = $this->session->userdata('isLoggedIn');
	}

	public function index(){
		if($this->isLoggedIn){
			if($this->session->userdata('user_role') == 'Branch Administrator'){
				redirect('supply_requests/branch_view');
			}else if($this->session->userdata('user_role') == 'System Administrator'){
				redirect('supply_requests/warehouse_view');
			}else{
				redirect('users/dashboard');
			}
			
		}else{
			redirect('users/login');
		}
	}

	public function branch(){
		$data = array();
		$data['success_msg'] = $this->session->flashdata('success_msg');
		
		$this->load->view('supply_requests/branch', $data);
	}

	public function branch_list(){
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$con = array(
			'returnType' => 'list',
			'conditions' => array(
				'sr.branch_id' => $this->session->userdata('branch_id')
			)
		);
		$srequestList = $this->supply_request->getRowsJoin($con);

		$data = array();
		
		foreach($srequestList->result_array() as $r) {

		   $data[] = array(
		   		$r['ID'],
		        $r['ITEM'],
		        $r['QTY'],
		        $r['REQUESTED_BY'],
		        $r['REQUESTED_DT'],
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
    }


	public function receive($id = null){
		if($this->isLoggedIn){
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
						$wh_item = $this->warehouse_inventory->getRows($con); //get item from warehouse inventory
						if($wh_item){
							if($wh_item['CURRENT_QTY'] >= $this->input->post('approved_qty')){
								$newVal = array(
									'current_qty'	=> $wh_item['CURRENT_QTY'] - $this->input->post('approved_qty')
								);
								$this->warehouse_inventory->update($wh_item['ID'], $newVal);


								$br_item = $this->branch_inventory->getRows($con); //get item from branch inventory
								if($br_item){ //update
									$newVal = array(
										'qty'	=> $br_item['QTY'] + $this->input->post('approved_qty')
									);
									$this->branch_inventory->update($br_item['ID'], $newVal);
								}else{ //insert
									$inventory = array(
										'id'		=> uniqid('', true),
										'branch_id'	=> $this->session->userdata('branch_id'),
										'item_id'	=> $this->input->post('item_id'),
										'qty'		=> $this->input->post('init_qty'),
										'critical_qty' => $this->input->post('crit_qty')
									);
									$this->branch_inventory->insert($inventory);
								}


								$newVal = array(
									'received_by'	=> $this->session->userdata('username'),
									'received_dt'	=> date('YmdHis'),
									'status'		=> 'RECEIVED'
								);
								$this->supply_request->update($request['ID'], $newVal); //update supply request

								$this->session->set_flashdata('success_msg', 'Request successfully received!');
								redirect('supply_requests/branch_view');

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

			$footer_data = array();
			$footer_data['page_has_table'] = '';
			$footer_data['site_url'] = '';
			$footer_data['view_url'] = '';
			$footer_data['back_url'] = 'supply_requests/branch_view';
			$footer_data['right_align_cols'] = array();
			$footer_data['action'] = '';
			$footer_data['success_msg'] = $this->session->flashdata('success_msg');
			if(isset($data['error_msg'])){
				$footer_data['error_msg'] = $data['error_msg'];
			}

			$con = array(
				'returnType' => 'single',
				'conditions' => array(
					'del' => false,
					'id' => $id
				));
			$statusObj= $this->supply_request->getRows($con);

			$con = array(
				'returnType' => 'single',
				'conditions' => array(
					'sr.del' => false,
					'sr.id' => $id
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
			
			$this->load->view('components/header', $data);
			$this->load->view('supply_requests/receive', $data);
			$this->load->view('components/footer_modal', $footer_data);

		}else{
			redirect('users/login');
		}
	}


	public function add(){
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
		
		$this->load->view('supply_requests/add', $data);
	}





	public function warehouse_view(){
		$data = array();
		$data['session_user'] = $this->session->userdata('username');

		$footer_data = array();
		$footer_data['page_has_table'] = 'has_table';
		$footer_data['site_url'] = 'supply_requests/warehouse_view_list';
		$footer_data['view_url'] = 'supply_requests/approve/';
		$footer_data['right_align_cols'] = array();
		$footer_data['action'] = 'view';
		$footer_data['success_msg'] = $this->session->flashdata('success_msg');
		if(isset($data['error_msg'])){
			$footer_data['error_msg'] = $data['error_msg'];
		}

		
		$this->load->view('components/header', $data);
		$this->load->view('supply_requests/warehouse_view', $data);
		$this->load->view('components/footer_modal', $footer_data);
	}

	public function warehouse_view_list(){
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$con = array(
			'returnType' => 'list',
			'conditions' => array(
				'sr.status' => 'NEW'
			)
		);
		$srequestList = $this->supply_request->getRowsJoin($con);

		$data = array();
		
		foreach($srequestList->result_array() as $r) {

		   $data[] = array(
		   		$r['ID'],
		        $r['ITEM'],
		        $r['QTY'],
		        $r['BRANCH'],
		        $r['REQUESTED_BY'],
		        $r['REQUESTED_DT'],
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
    }


	public function approve($id = null){
		if($this->isLoggedIn){
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
								redirect('supply_requests/warehouse_view');

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

			$footer_data = array();
			$footer_data['page_has_table'] = '';
			$footer_data['site_url'] = '';
			$footer_data['view_url'] = '';
			$footer_data['back_url'] = 'supply_requests/warehouse_view';
			$footer_data['right_align_cols'] = array();
			$footer_data['action'] = '';
			$footer_data['success_msg'] = $this->session->flashdata('success_msg');
			if(isset($data['error_msg'])){
				$footer_data['error_msg'] = $data['error_msg'];
			}

			$con = array(
				'returnType' => 'single',
				'conditions' => array(
					'sr.del' => false,
					'sr.id' => $id
				)
			);
			$data['req'] = $this->supply_request->getRowsJoin($con)->row_array();

			$con = array(
				'returnType' => 'single',
				'conditions' => array(
					'inv.item_id' => $data['req']['ITEM_ID']
				)
			);
			$data['wh_item'] = $this->warehouse_inventory->getRowsJoin($con)->row_array();
			
			$this->load->view('components/header', $data);
			$this->load->view('supply_requests/approve', $data);
			$this->load->view('components/footer_modal', $footer_data);

		}else{
			redirect('users/login');
		}
	}

}