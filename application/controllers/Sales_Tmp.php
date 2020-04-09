<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Sales_Tmp extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->model('sales_temp');
		$this->load->model('sales_temp_dtls');

		$this->isLoggedIn = $this->session->userdata('isLoggedIn');
	}

	public function index(){
		if($this->isLoggedIn){


		}else{
			redirect('users/login');
		}
	}

	public function add(){
		if($this->input->post('save_sales_temp')){
			$con = array(
				'returnType' => 'count',
				'conditions' => array(
					'del' => false,
					'branch_id' => $this->session->userdata('branch_id'),
					'cust_name' => strtoupper($this->input->post('cust_name'))
				)
			);
			$tmpCnt = $this->sales_temp->getRows($con);
			if($tmpCnt > 0){
				echo strtoupper($this->input->post('cust_name')).' already exists';
			}else{
				$id = uniqid('', true);
				$salesTmp = array(
					'id' => $id,
					'branch_id' => $this->session->userdata('branch_id'),
					'cust_name' => strtoupper($this->input->post('cust_name')),
					'item_cnt' => $this->input->post('item_cnt')
				);

				$insert_id = $this->sales_temp->insert($salesTmp);

				if(!$insert_id){

					foreach($this->input->post('sales') as $item) {
							
						$sales_tmp_dtl = array(
							'id'		=> uniqid('', true),
							'sales_temp_id' => $id,
							'branch_inventory_id' => $item['inventory_id'],
							'quantity' => $item['quantity']
						);

						$this->sales_temp_dtls->insert($sales_tmp_dtl);
					 
					}
					echo 'OK';
					exit();

				}else{
					echo 'Failed to save transaction';
					exit();
				}
			}
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
		$list = $this->sales_temp->getRowsJoin($con);

		$data = array();
		
		foreach($list->result_array() as $r) {
			$data[] = array(
				$r['ID'],
				$r['BRANCH'],
			    $r['CUST_NAME'],
			    $r['ITEM_CNT'],
			    $r['CREATED_BY'],
			    $r['CREATED_DT']

			);
		}

		$output = array(
		   "draw" => $draw,
		     "recordsTotal" => $list->num_rows(),
		     "recordsFiltered" => $list->num_rows(),
		     "data" => $data
		);
		echo json_encode($output);
		exit();
     }


     public function details(){
		$data = array();
     	$id = $this->input->get('id', TRUE);

     	$con = array(
			'returnType' => 'count',
			'conditions' => array(
				'id' => $id
			)
		);
		$cnt = $this->sales_temp->getRows($con);


		if($cnt > 0){
			$con = array(
				'returnType' => 'list',
				'conditions' => array(
					'sales_temp_id' => $id
				)
			);
			$pos_list = $this->sales_temp_dtls->getRowsJoin($con);
			
			$data = $pos_list->result();
		}

		echo json_encode($data);
		exit();
    }

}