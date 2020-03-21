<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Supply_Requests extends CI_Controller {

	public function __construct(){
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->model('supply_request');
		$this->load->model('item');

		$this->isLoggedIn = $this->session->userdata('isLoggedIn');
	}

	public function index(){
		if($this->isLoggedIn){
			if($this->session->userdata('user_role') == 'Branch Administrator'){
				redirect('supply_requests/branch_view');
			}else if($this->session->userdata('user_role') == 'System Administrator'){
				redirect('supply_requests/warehouse_view');
			}else{

			}
			
		}else{
			redirect('users/login');
		}
	}

	public function branch_view(){
		$data = array();
		$data['session_user'] = $this->session->userdata('username');

		$footer_data = array();
		$footer_data['page_has_table'] = 'has_table';
		$footer_data['site_url'] = 'supply_requests/branch_view_list';
		$footer_data['right_align_cols'] = array();
		
		$this->load->view('components/header', $data);
		$this->load->view('supply_requests/branch_view', $data);
		$this->load->view('components/footer_modal', $footer_data);
	}

	public function branch_view_list(){
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
		        //$r['BRANCH'],
		        $r['ITEM'],
		        $r['QTY'],
		        $r['REQUESTED_BY'],
		        $r['REQUESTED_DT'],
		        $r['STATUS']
		        //$r['ASSIGNEE'],
		        //$r['APPROVED_BY'],
		        //$r['APPROVED_DT'],
		        //$r['APPROVED_QTY'],
		        //$r['RECEIVED_BY'],
		        //$r['RECEIVED_DT']
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

	public function add(){
		$data = array();
		$data['session_user'] = $this->session->userdata('username');

		$footer_data = array();
		$footer_data['page_has_table'] = '';
		$footer_data['site_url'] = '';
		$footer_data['right_align_cols'] = array();

		$con = array(
			'returnType' => 'list',
			'conditions' => array(
				'i.del' => false
			)
		);
		$data['items'] = $this->item->getRowsJoin($con);
		
		$this->load->view('components/header', $data);
		$this->load->view('supply_requests/add', $data);
		$this->load->view('components/footer_modal', $footer_data);
	}

	public function process_add(){
		if($this->input->post('process_requests')){
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
	}





	public function warehouse_view(){
		$data = array();
		$data['session_user'] = $this->session->userdata('username');

		$footer_data = array();
		$footer_data['page_has_table'] = 'has_table';
		$footer_data['site_url'] = 'supply_requests/warehouse_view_list';
		$footer_data['right_align_cols'] = array(-4);
		
		$this->load->view('components/header', $data);
		$this->load->view('supply_requests/warehouse_view', $data);
		$this->load->view('components/footer_modal', $footer_data);
	}

}