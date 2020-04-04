<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Items extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->model('item');
		$this->load->model('brand');
		$this->load->model('category');
		$this->load->model('stock_type');

		$this->isLoggedIn = $this->session->userdata('isLoggedIn');
	}

	public function index(){
		if($this->isLoggedIn){
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

			if($this->input->post('submit_item')){
				$this->form_validation->set_rules('brand_id', 'Brand', 'required|trim');
				$this->form_validation->set_rules('dscp', 'Description', 'required|trim');
				$this->form_validation->set_rules('category_id', 'Category', 'required|trim');
				$this->form_validation->set_rules('price', 'Price', 'required|trim|decimal');
				$this->form_validation->set_rules('critical_qty', 'Critical Quantity', 'required|trim|is_natural');
				$this->form_validation->set_rules('stock_type_id', 'Stock Type', 'required|trim');
				$this->form_validation->set_rules('stock_type_content', 'Stock Type Content', 'required|trim|is_natural');

				if($this->form_validation->run() == true){
					$con = array(
						'returnType' => 'count',
						'conditions' => array(
							'del'	=> false,
							'brand_id' => trim($this->input->post('brand_id')),
							'dscp' => trim(strtoupper($this->input->post('dscp')))
						)
					);
					$itemCnt = $this->item->getRows($con);
					if($itemCnt > 0){
						$data['error_msg'] = 'Item already exists';
					}else{
						$item_ = array(
							'id'					=> uniqid('', true),
							'brand_id'				=> trim($this->input->post('brand_id')),
							'dscp'					=> trim(strtoupper($this->input->post('dscp'))),
							'category_id'			=> trim($this->input->post('category_id')),
							'price'					=> $this->input->post('price'),
							'critical_qty'			=> $this->input->post('critical_qty'),
							'stock_type_id'			=> trim($this->input->post('stock_type_id')),
							'stock_type_content'	=> $this->input->post('stock_type_content')
							);
						$this->item->insert($item_);
						
						$this->session->set_flashdata('success_msg', 'Item successfully added!');
						redirect(current_url());
					}

				}else{
					$data['error_msg'] = 'Please fill all required fields.';
				}

			}else if($this->input->post('submit_delete')){
				$this->form_validation->set_rules('id', 'Item', 'required|trim');

				if($this->form_validation->run() == true){
					if($this->item->delete($this->input->post('id'))){
						echo 'OK';
						exit();
					}else{
						echo 'Could not delete Item. ID does not exist.';
						exit();
					}
				}
			}

			$con = array(
				'returnType' => 'list',
				'conditions' => array(
					'del' => false
				)
			);
			$data['brands'] = $this->brand->getRows($con);
			$data['categories'] = $this->category->getRows($con);
			$data['stock_types'] = $this->stock_type->getRows($con);
			
			$this->load->view('items/index', $data);

		}else{
			redirect('users/login');
		}
	}

	public function edit($id = null){
		if($this->isLoggedIn){
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

			if($this->input->post('submit_item_edit')){
				$this->form_validation->set_rules('id', 'Brand', 'required|trim');
				$this->form_validation->set_rules('brand_id', 'Brand', 'required|trim');
				$this->form_validation->set_rules('dscp', 'Description', 'required|trim');
				$this->form_validation->set_rules('category_id', 'Category', 'required|trim');
				$this->form_validation->set_rules('price', 'Price', 'required|trim|decimal');
				$this->form_validation->set_rules('critical_qty', 'Critical Quantity', 'required|trim|is_natural');
				$this->form_validation->set_rules('stock_type_id', 'Stock Type', 'required|trim');
				$this->form_validation->set_rules('stock_type_content', 'Stock Type Content', 'required|trim|is_natural');

				if($this->form_validation->run() == true){
					$con = array(
						'returnType' => 'count',
						'conditions' => array(
							'del'	=> false,
							'brand_id' => trim($this->input->post('brand_id')),
							'dscp' => trim(strtoupper($this->input->post('dscp')))
						),
						'not_in' => array(
							'id' => $this->input->post('id')
						)
					);
					$itemCnt = $this->item->getRows($con);
					if($itemCnt > 0){
						$data['error_msg'] = 'Item already exists';
					}else{
						$item_ = array(
							'brand_id'				=> trim($this->input->post('brand_id')),
							'dscp'					=> trim(strtoupper($this->input->post('dscp'))),
							'category_id'			=> trim($this->input->post('category_id')),
							'price'					=> $this->input->post('price'),
							'critical_qty'			=> $this->input->post('critical_qty'),
							'stock_type_id'			=> trim($this->input->post('stock_type_id')),
							'stock_type_content'	=> $this->input->post('stock_type_content')
							);
						$this->item->update($this->input->post('id'), $item_);
						
						$this->session->set_flashdata('success_msg', 'Item successfully updated!');
						redirect(current_url());
					}

				}else{
					$data['error_msg'] = 'Please fill all required fields.';
				}

			}

			$con = array(
				'returnType' => 'list',
				'conditions' => array(
					'del' => false
				)
			);
			$data['brands'] = $this->brand->getRows($con);
			$data['categories'] = $this->category->getRows($con);
			$data['stock_types'] = $this->stock_type->getRows($con);

			$con = array(
				'returnType' => 'single',
				'conditions' => array(
					'del' => false,
					'id' => $id
				)
			);
			$data['item'] = $this->item->getRows($con);
			
			$this->load->view('items/edit', $data);

		}else{
			redirect('users/login');
		}
	}

	

	public function list(){
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$con = array(
			'returnType' => 'list',
			'conditions' => array()
		);
		$itemsList = $this->item->getRowsJoin($con);

		$data = array();
		
		foreach($itemsList->result_array() as $r) {

		   $data[] = array(
		   		$r['ID'],
		        $r['BRAND'],
		        $r['DSCP'],
		        $r['CATEGORY'],
		        $r['PRICE'],
		        $r['CRITICAL_QTY'],
		        $r['STOCK_TYPE'],
		        $r['STOCK_TYPE_CONTENT']
		   );
		}

		$output = array(
		   "draw" => $draw,
		     "recordsTotal" => $itemsList->num_rows(),
		     "recordsFiltered" => $itemsList->num_rows(),
		     "data" => $data
		);
		echo json_encode($output);
		exit();
     }

}