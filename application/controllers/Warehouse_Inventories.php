<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Warehouse_Inventories extends CI_Controller {

	public function __construct(){
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->model('warehouse_inventory');
		$this->load->model('item');

		$this->isLoggedIn = $this->session->userdata('isLoggedIn');
	}

	public function index(){
		if($this->isLoggedIn){
			$data = array();
			$data['session_user'] = $this->session->userdata('username');

			$action_cust  = '<a class=\'action-add\' data-mode=\'modal\'><i class=\'fas fa-plus\'></i></a> &nbsp;&nbsp;';
			$action_cust .= '<a class=\'action-deduct\' data-mode=\'modal\'><i class=\'fas fa-minus\'></i></a> &nbsp;&nbsp;';
			$action_cust .= '<a class=\'action-edit\' data-mode=\'modal\'><i class=\'fas fa-edit\'></i></a>';

			$footer_data = array();
			$footer_data['has_table'] = 'has_table';
			$footer_data['site_url'] = 'warehouse_inventories/inventory_list';
			$footer_data['view_url'] = '';
			$footer_data['action'] = '';
			$footer_data['action_cust'] = $action_cust;
			$footer_data['right_align_cols'] = array(-2, -3, -4);
			$footer_data['success_msg'] = $this->session->flashdata('success_msg');

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
						'returnType' => 'count',
						'conditions' => array(
							'del' => false,
							'id' => strtoupper($this->input->post('item_id'))
						)
					);
					$itemCnt = $this->item->getRows($con); //check if item id exists in database
					if($itemCnt > 0){
						$con = array(
							'returnType' => 'count',
							'conditions' => array(
								'del' => false,
								'item_id' => strtoupper($this->input->post('item_id'))
							)
						);
						$inventoryCnt = $this->warehouse_inventory->getRows($con);
						if($inventoryCnt > 0){
							$data['error_msg'] = 'Item already exists';
						}else{
							$inventory = array(
								'id'		=> uniqid('', true),
								'item_id'	=> strtoupper($this->input->post('item_id')),
								'current_qty' => $this->input->post('init_qty'),
								'available_qty' => $this->input->post('init_qty'),
								'critical_qty' => $this->input->post('crit_qty')
								);
							$this->warehouse_inventory->insert($inventory);
							
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
							'del' => false,
							'id' => strtoupper($this->input->post('id'))
						)
					);
					$inventory = $this->warehouse_inventory->getRows($con);
					$newVal = array(
						'available_qty'	=> $inventory['AVAILABLE_QTY'] + $this->input->post('adjust_qty'),
						'current_qty'	=> $inventory['CURRENT_QTY'] + $this->input->post('adjust_qty')
					);
					$this->warehouse_inventory->update($inventory['ID'], $newVal);

					echo 'OK';
					exit();
				}
			}else if($this->input->post('submit_deduct')){
				$this->form_validation->set_rules('id', 'Inventory', 'required|trim');
				$this->form_validation->set_rules('adjust_qty', 'No. of Stocks to Add', 'required|trim|is_natural');

				if($this->form_validation->run() == true){
					$con = array(
						'returnType' => 'single',
						'conditions' => array(
							'del' => false,
							'id' => strtoupper($this->input->post('id'))
						)
					);
					$inventory = $this->warehouse_inventory->getRows($con);
					$newVal = array(
						'available_qty'	=> $inventory['AVAILABLE_QTY'] - $this->input->post('adjust_qty'),
						'current_qty'	=> $inventory['CURRENT_QTY'] - $this->input->post('adjust_qty')
					);
					$this->warehouse_inventory->update($inventory['ID'], $newVal);

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

			if(isset($data['error_msg'])){
				$footer_data['error_msg'] = $data['error_msg'];
			}

			$this->load->view('components/header', $data);
			$this->load->view('warehouse_inventories/index', $data);
			$this->load->view('components/footer_modal', $footer_data);
		}else{
			redirect('users/login');
		}
	}

	public function inventory_list(){
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$con = array(
			'returnType' => 'list',
			'conditions' => array()
		);
		$inventoryList = $this->warehouse_inventory->getRowsJoin($con);

		$data = array();
		
		foreach($inventoryList->result_array() as $r) {

		   $data[] = array(
		   		$r['ID'],
		        $r['ITEM'],
		        $r['CATEGORY'],
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
    }

}
