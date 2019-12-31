<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Suppliers extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->model('supplier');

		$this->isLoggedIn = $this->session->userdata('isLoggedIn');
	}

	public function index(){
		if($this->isLoggedIn){
			redirect('suppliers/view');
		}else{
			redirect('users/login');
		}
	}

	public function view(){
		$data = array();
		$data['session_user'] = $this->session->userdata('username');

		$footer_data = array();
		$footer_data['page_has_table'] = 'has_table';
		$footer_data['site_url'] = 'suppliers/suppliers_page';
		$footer_data['has_export_buttons'] = 'enabled';
		
		$this->load->view('components/header', $data);
		$this->load->view('suppliers/view', $data);
		$this->load->view('components/footer', $footer_data);
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

		if($this->input->post('submit_supplier')){
			$this->form_validation->set_rules('supplier_name', 'Supplier Name', 'required|trim');
			$this->form_validation->set_rules('contact_person', 'Contact Person', 'required|trim');
			$this->form_validation->set_rules('address', 'Address', 'required|trim');
			$this->form_validation->set_rules('contact_no', 'Contact No', 'required|trim|numeric');
			$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
			$this->form_validation->set_rules('website', 'Website', 'required|trim|valid_url');
			$this->form_validation->set_rules('notes', 'Notes', 'trim');

			if($this->form_validation->run() == true){
				$con = array(
					'returnType' => 'count',
					'conditions' => array(
						'del' => false,
						'supplier_name' => strtoupper($this->input->post('supplier_name'))
					)
				);

				$supplierCnt = $this->supplier->getRows($con);
				if($supplierCnt > 0){
					$data['error_msg'] = 'Supplier already exists';
				}else{
					$supplier = array(
						'id'      			=> uniqid('', true),
						'supplier_name'		=> strtoupper($this->input->post('supplier_name')),
						'contact_person'	=> $this->input->post('contact_person'),
						'address'			=> $this->input->post('address'),
						'contact_no'		=> $this->input->post('contact_no'),
						'email'				=> $this->input->post('email'),
						'website'			=> $this->input->post('website'),
						'notes'				=> $this->input->post('notes')
						);
					$this->supplier->insert($supplier);

					redirect(current_url());
				}

			}else{
				$data['error_msg'] = 'Please fill all required fields.';
			}
		}

		$this->load->view('components/header', $data);
		$this->load->view('suppliers/add', $data);
		$this->load->view('components/footer');
	}

	public function suppliers_page(){
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

		$con = array(
			'returnType' => 'list',
			'conditions' => array(
				'del' => false
			)
		);
		$supplierList = $this->supplier->getRows($con);

		$data = array();
		
		foreach($supplierList->result_array() as $r) {

		   $data[] = array(
		        $r['SUPPLIER_NAME'],
		        $r['CONTACT_PERSON'],
		        $r['ADDRESS'],
		        $r['CONTACT_NO'],
		        $r['EMAIL'],
		        $r['WEBSITE'],
		        $r['NOTES']
		   );
		}

		$output = array(
		   "draw" => $draw,
		     "recordsTotal" => $supplierList->num_rows(),
		     "recordsFiltered" => $supplierList->num_rows(),
		     "data" => $data
		);
		echo json_encode($output);
		exit();
     }

}