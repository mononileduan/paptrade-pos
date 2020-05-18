<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class POS extends CI_Controller {

	public function __construct(){
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->model('user');
		$this->load->model('sales_model');

		$this->isLoggedIn = $this->session->userdata('isLoggedIn');
		$this->LOGIN_MAX_RETRY = 3;
	}

	public function index(){
		if($this->isLoggedIn && $this->session->userdata('status') == $this->config->item('USER_STATUS_ASSOC')['ACTIVE'][0]){
			if(in_array('POS', $this->config->item('USER_ROLE_ASSOC_MENU')[$this->session->userdata('user_role')])){
					$data = array();
					
					$con = array(
						'conditions' => array(
							'branch_id' => $this->session->userdata('branch_id')
						)
					);
					$result = $this->sales_model->getSummary($con)->row_array();
					$data['daily_sales_cnt'] = $result['CNT'];
					$data['daily_total_sales'] = $result['TOTAL'];

					$this->load->view('pos/index', $data);
			}else{
				$this->load->view('components/unauthorized');
			}
		}else{
			redirect('users/logout');
		}
	}

}
