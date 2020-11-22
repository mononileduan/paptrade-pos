<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Warehouse_inventories extends CI_Controller {

	public function __construct(){
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->model('warehouse_inventory');
		$this->load->model('warehouse_inventory_hist');
		$this->load->model('item');

		$this->isLoggedIn = $this->session->userdata('isLoggedIn');
	}

	public function index(){
		if($this->isLoggedIn && $this->session->userdata('status') == $this->config->item('USER_STATUS_ASSOC')['ACTIVE'][0]){
			if(in_array('WH_INVENTORY', $this->config->item('USER_ROLE_ASSOC_MENU')[$this->session->userdata('user_role')])){
				$data = array();
				$data['success_msg'] = $this->session->flashdata('success_msg');

				if($this->session->userdata('success_msg')){
					$data['success_msg'] = $this->session->userdata('success_msg');
					$this->session->unset_userdata('success_msg');
				}
				if($this->session->userdata('error_msg')){
					$data['error_msg'] = $this->session->userdata('error_msg');
					$this->session->unset_userdata('error_msg');
				}

				if($this->input->post('submit_new_inventory')){
					$this->form_validation->set_rules('item_id', 'Item', 'required|trim');
					$this->form_validation->set_rules('init_qty', 'Initial Quantity', 'required|trim|is_natural');
					$this->form_validation->set_rules('crit_qty', 'Critical Quantity', 'required|trim|is_natural');

					if($this->form_validation->run() == true){
						$con = array(
							'returnType' => 'single',
							'conditions' => array(
								'i.del' => false,
								'i.id' => $this->input->post('item_id')
							)
						);
						$itemObj = $this->item->getRowsJoin($con)->row_array(); //check if item id exists in database
						if($itemObj){
							$con = array(
								'returnType' => 'count',
								'conditions' => array(
									'del' => false,
									'item_id' => $this->input->post('item_id')
								)
							);
							$inventoryCnt = $this->warehouse_inventory->getRows($con);
							if($inventoryCnt > 0){
								$data['error_msg'] = 'Item already exists';
							}else{
								$inventory_id = uniqid('', true);
								$inventory = array(
									'id'		=> $inventory_id,
									'item_id'	=> $this->input->post('item_id'),
									'current_qty' => $this->input->post('init_qty'),
									'available_qty' => $this->input->post('init_qty'),
									'critical_qty' => $this->input->post('crit_qty')
									);
								$this->warehouse_inventory->insert($inventory);

								$inventory_hist = array(
									'id'			=> uniqid('', true),
									'inventory_id'	=> $inventory_id,
									'item'			=> $itemObj['BRAND'].' '.$itemObj['DSCP'],
									'qty' 			=> $this->input->post('init_qty'),
									'qty_running'	=> $this->input->post('init_qty'),
									'movement' 		=> 'IN',
									'updated_by'	=> $this->session->userdata('username'),
									'updated_dt'	=> date('YmdHis'),
									'remarks'		=> 'Initial'
									);
								$this->warehouse_inventory_hist->insert($inventory_hist);
								
								$this->session->set_flashdata('success_msg', 'New Inventory successfully added!');
								redirect(current_url());
							}
						}else{
							$data['error_msg'] = 'Item does not exist';
						}

					}else{
						$data['error_msg'] = 'Please fill all required fields.';
					}
				
				}else if($this->input->post('submit_add')){
					$this->form_validation->set_rules('id', 'Inventory', 'required|trim');
					$this->form_validation->set_rules('adjust_qty', 'No. of Stocks to Add', 'required|trim|is_natural');

					if($this->form_validation->run() == true){
						$con = array(
							'returnType' => 'single',
							'conditions' => array(
								'inv.del' => false,
								'inv.id' => $this->input->post('id')
							)
						);
						$inventory = $this->warehouse_inventory->getRowsJoin($con)->row_array();
						$newVal = array(
							'available_qty'	=> $inventory['AVAILABLE_QTY'] + $this->input->post('adjust_qty'),
							'current_qty'	=> $inventory['CURRENT_QTY'] + $this->input->post('adjust_qty')
						);
						$this->warehouse_inventory->update($inventory['ID'], $newVal);

						$inventory_hist = array(
							'id'			=> uniqid('', true),
							'inventory_id'	=> $this->input->post('id'),
							'item'			=> $inventory['ITEM'],
							'qty' 			=> $this->input->post('adjust_qty'),
							'qty_running'	=> $inventory['CURRENT_QTY'] + $this->input->post('adjust_qty'),
							'movement' 		=> 'IN',
							'updated_by'	=> $this->session->userdata('username'),
							'updated_dt'	=> date('YmdHis'),
							'remarks'		=> 'Add'
							);
						$this->warehouse_inventory_hist->insert($inventory_hist);

						echo 'OK';
						exit();
					}
				}else if($this->input->post('submit_deduct')){
					$this->form_validation->set_rules('id', 'Inventory', 'required|trim');
					$this->form_validation->set_rules('adjust_qty', 'No. of Stocks to Deduct', 'required|trim|is_natural');

					if($this->form_validation->run() == true){
						$con = array(
							'returnType' => 'single',
							'conditions' => array(
								'inv.del' => false,
								'inv.id' => $this->input->post('id')
							)
						);
						$inventory = $this->warehouse_inventory->getRowsJoin($con)->row_array();
						$newVal = array(
							'available_qty'	=> $inventory['AVAILABLE_QTY'] - $this->input->post('adjust_qty'),
							'current_qty'	=> $inventory['CURRENT_QTY'] - $this->input->post('adjust_qty')
						);
						$this->warehouse_inventory->update($inventory['ID'], $newVal);

						$inventory_hist = array(
							'id'			=> uniqid('', true),
							'inventory_id'	=> $this->input->post('id'),
							'item'			=> $inventory['ITEM'],
							'qty' 			=> $this->input->post('adjust_qty'),
							'qty_running'	=> $inventory['CURRENT_QTY'] - $this->input->post('adjust_qty'),
							'movement' 		=> 'OUT',
							'updated_by'	=> $this->session->userdata('username'),
							'updated_dt'	=> date('YmdHis'),
							'remarks'		=> 'Deduct'
							);
						$this->warehouse_inventory_hist->insert($inventory_hist);

						echo 'OK';
						exit();
					}
				}else if($this->input->post('submit_edit')){
					$this->form_validation->set_rules('id', 'Inventory', 'required|trim');
					$this->form_validation->set_rules('crit_qty', 'Critical Quantity', 'required|trim|is_natural');

					if($this->form_validation->run() == true){
						$con = array(
							'returnType' => 'single',
							'conditions' => array(
								'del' => false,
								'id' => $this->input->post('id')
							)
						);
						$inventory = $this->warehouse_inventory->getRows($con);
						$newVal = array(
							'critical_qty'	=> $this->input->post('crit_qty')
						);
						$this->warehouse_inventory->update($inventory['ID'], $newVal);

						echo 'OK';
						exit();
					}
				}else if($this->input->post('submit_remove')){
					$this->form_validation->set_rules('id', 'Inventory', 'required|trim');

					if($this->form_validation->run() == true){
						$con = array(
							'returnType' => 'single',
							'conditions' => array(
								'inv.del' => false,
								'inv.id' => $this->input->post('id')
							)
						);
						$inventory = $this->warehouse_inventory->getRowsJoin($con)->row_array();
						$newVal = array(
							'status'	=> 'ARCHIVED'
						);
						$this->warehouse_inventory->update($inventory['ID'], $newVal);

						$inventory_hist = array(
							'id'			=> uniqid('', true),
							'inventory_id'	=> $this->input->post('id'),
							'item'			=> $inventory['ITEM'],
							'qty' 			=> $inventory['CURRENT_QTY'],
							'qty_running'	=> $inventory['CURRENT_QTY'],
							'movement' 		=> 'OUT',
							'updated_by'	=> $this->session->userdata('username'),
							'updated_dt'	=> date('YmdHis'),
							'remarks'		=> 'Archived'
							);
						$this->warehouse_inventory_hist->insert($inventory_hist);

						echo 'OK';
						exit();
					}
				}


				$con = array(
					'returnType' => 'list',
					'conditions' => array(
						'i.del' => false
					)
				);
				$data['items'] = $this->item->getRowsJoin($con);
				$data['item_id'] = $this->input->get('item_id');

				$this->load->view('warehouse_inventories/index', $data);
				
			}else{
				$this->load->view('components/unauthorized');
			}
		}else{
			redirect('users/logout');
		}
	}

	public function list(){
		if($this->isLoggedIn && $this->session->userdata('status') == $this->config->item('USER_STATUS_ASSOC')['ACTIVE'][0] 
			&& in_array('WH_INVENTORY', $this->config->item('USER_ROLE_ASSOC_MENU')[$this->session->userdata('user_role')])){

			// Datatables Variables
			$draw = intval($this->input->get("draw"));
			$start = intval($this->input->get("start"));
			$length = intval($this->input->get("length"));

			$con = array(
				'returnType' => 'list',
				'conditions' => array(
					'inv.status' => 'ACTIVE'
				));

			if($this->input->get('item_id') !== null && $this->input->get('item_id') !== ''){
				$con = array('conditions' => array(
						'item_id' => $this->input->get('item_id'),
						'inv.status' => 'ACTIVE'));
			}
			$inventoryList = $this->warehouse_inventory->getRowsJoin($con);

			$data = array();
			
			foreach($inventoryList->result_array() as $r) {

			   $data[] = array(
			   		$r['ID'],
			        $r['ITEM'],
			        $r['CATEGORY'],
			        $r['PRICE'],
			        $r['CURRENT_QTY'],
			        $r['AVAILABLE_QTY'],
			        $r['CRITICAL_QTY']
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

	public function lowstocks(){
		if($this->isLoggedIn && $this->session->userdata('status') == $this->config->item('USER_STATUS_ASSOC')['ACTIVE'][0] 
			&& in_array('WH_INVENTORY', $this->config->item('USER_ROLE_ASSOC_MENU')[$this->session->userdata('user_role')])){

			// Datatables Variables
			$draw = intval($this->input->get("draw"));
			$start = intval($this->input->get("start"));
			$length = intval($this->input->get("length"));

			$con = array('returnType' => 'list');

			$inventoryList = $this->warehouse_inventory->getLowStocks($con);

			$data = array();
			
			foreach($inventoryList->result_array() as $r) {

			   $data[] = array(
			   		$r['ID'],
			        $r['ITEM_ID'],
			        $r['ITEM'],
			        $r['CRITICAL_QTY'],
			        $r['CURRENT_QTY'],
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


    public function hist_list(){
    	if($this->isLoggedIn && $this->session->userdata('status') == $this->config->item('USER_STATUS_ASSOC')['ACTIVE'][0] 
			&& in_array('WH_INVENTORY', $this->config->item('USER_ROLE_ASSOC_MENU')[$this->session->userdata('user_role')])){

			// Datatables Variables
			$draw = intval($this->input->get("draw"));
			$start = intval($this->input->get("start"));
			$length = intval($this->input->get("length"));

			$con = array(
				'returnType' => 'list',
				'conditions' => array(
					'inv.inventory_id' => $this->input->get('inventory_id')
				)
			);
			$inventoryList = $this->warehouse_inventory_hist->getRowsJoin($con);

			$data = array();
			
			foreach($inventoryList->result_array() as $r) {

			   $data[] = array(
			   		$r['ID'],
			        $r['UPDATED_DT'],
			        $r['ITEM'],
			        $r['QTY'],
			        $r['QTY_RUNNING'],
			        $r['MOVEMENT'],
			        $r['UPDATED_BY'],
			        $r['REMARKS']
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

}
