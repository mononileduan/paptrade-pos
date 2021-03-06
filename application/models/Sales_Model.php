<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Sales_model extends CI_Model {
	public function __construct(){
		$this->table = 'SALES';
	}

	public function getRows($params = array()){
		$this->db->select('*');
		$this->db->from($this->table);

		if(array_key_exists("conditions", $params)){
			foreach ($params['conditions'] as $key => $val) {
				$this->db->where($key, $val);
			}
		}

		if(array_key_exists("returnType", $params) && $params['returnType'] == 'count'){
			$result = $this->db->count_all_results();
		}else{
			if(array_key_exists("ID", $params) || $params['returnType'] == 'single'){
				if(!empty($params['ID'])){
					$this->db->where('ID', $params['ID']);
				}
				$query = $this->db->get();
				$result = $query->row_array();
			}else{
				$this->db->order_by('ID', 'desc');
				if(array_key_exists("start", $params) && array_key_exists("limit", $params)){
					$this->db->limit($params['limit'], $params['start']);
				}elseif(!array_key_exists("start", $params) && array_key_exists("limit", $params)){
					$this->db->limit($params['limit']);
				}

				$query = $this->db->get();
				//$result = ($query->num_rows() > 0) ? $query->result_array() : false;
				$result = $query;
			}
		}

		return $result;
	}

	public function getRowsJoin($params = array()){
		$sql = "SELECT ". 
			"SALES.ID as ID, ".
			"BRANCHES.BRANCH_NAME as BRANCH, ". 
			"BRANCHES.ADDRESS as BRANCH_ADDRESS, ". 
			"BRANCHES.CONTACT as BRANCH_CONTACT, ". 
			"SALES.ref_no as REF_NO, ". 
			"SALES.CREATED_DT as CREATED_DT, ". 
			"SALES.GRAND_TOTAL as GRAND_TOTAL, ". 
			"SALES.PAYMENT as PAYMENT, ".
			"concat(USERS.FIRST_NAME, ' ', USERS.LAST_NAME) as CREATED_BY ". 
			"from SALES, BRANCHES, USERS where USERS.USERNAME=SALES.CREATED_BY and BRANCHES.id=SALES.BRANCH_ID ";

		if(array_key_exists("conditions", $params)){
			foreach ($params['conditions'] as $key => $val) {
				if($key == 'tranDtFrom'){
					$sql .= " AND SALES.CREATED_DT >= '" . $val . "'";
				} else if($key == 'tranDtTo'){
					$sql .= " AND SALES.CREATED_DT <= '" . $val . "'";
				}else{
					$sql .= " AND " . $key . "='" . $val . "'";
				}
			}
		}
		
		if(array_key_exists("sort", $params)){
			$sql .= "ORDER BY ";
			foreach ($params['sort'] as $val) {
				$sql .= $val; 
			}
		}
		$result = $this->db->query($sql);
		return $result;

	}

	public function getTotalAmt($params = array()){
		$this->db->select_sum('GRAND_TOTAL');
		$this->db->from($this->table);

		if(!empty($params['ID'])){
			$this->db->where('ID', $params['ID']);
		}
		if(array_key_exists("conditions", $params)){
			foreach ($params['conditions'] as $key => $val) {
				if($key == 'tranDtFrom'){
					$this->db->where('CREATED_DT >=', $val);
				} else if($key == 'tranDtTo'){
					$this->db->where('CREATED_DT <=', $val);
				}else{
					$this->db->where($key, $val);
				}
			}
		}

		$query = $this->db->get();
		$result = $query->row_array();
		return $result;

	}

	public function getPosViewSales($params = array()){
		$sql = "SELECT ". 
			"SALES.ID as ID, ".
			"BRANCHES.BRANCH_NAME as BRANCH, ". 
			"SALES.ref_no as REF_NO, ". 
			"SALES.CREATED_DT as CREATED_DT, ". 
			"SALES.GRAND_TOTAL as GRAND_TOTAL, ". 
			"SALES.PAYMENT as PAYMENT, ".
			"concat(USERS.FIRST_NAME, ' ', USERS.LAST_NAME) as CREATED_BY ". 
			"from SALES, BRANCHES, USERS where USERS.USERNAME=SALES.CREATED_BY and BRANCHES.id=SALES.BRANCH_ID ";

		if(array_key_exists("conditions", $params)){
			foreach ($params['conditions'] as $key => $val) {
				$sql = $sql . " AND " . $key . "='" . $val . "'"; 
			}
		}
		$sql = $sql . " AND DATE_SUB(CURDATE(),INTERVAL 0 DAY) <= SALES.CREATED_DT "; 
		$result = $this->db->query($sql);
		return $result;

	}

	public function getSummary($params = array()){
		$sql = "SELECT COUNT(*) as CNT, sum(GRAND_TOTAL) as TOTAL FROM SALES WHERE DATE_SUB(CURDATE(),INTERVAL 0 DAY) <= CREATED_DT ";

		if(array_key_exists("conditions", $params)){
			foreach ($params['conditions'] as $key => $val) {
				$sql = $sql . " AND " . $key . "='" . $val . "'"; 
			}
		}
		$result = $this->db->query($sql);
		return $result;

	}

	public function getDashboardSummary($params = array()){
		$sql = "SELECT date_format(CREATED_DT, '%M %Y') as MONTH, COUNT(*) as CNT, sum(GRAND_TOTAL) as TOTAL FROM SALES WHERE DATE_SUB(CURDATE(),INTERVAL 6 MONTH) <= CREATED_DT  ";

		if(array_key_exists("conditions", $params)){
			foreach ($params['conditions'] as $key => $val) {
				$sql = $sql . " AND " . $key . "='" . $val . "'"; 
			}
		}
		$sql .= " group by date_format(CREATED_DT, '%M %Y') ORDER BY CREATED_DT desc";
		$result = $this->db->query($sql);
		return $result;

	}

	public function insert($data = array()){
		if(!empty($data)){
			if(!array_key_exists("created_by", $data)){
				$data['created_by'] = $this->session->userdata('username');
			}

			$insert = $this->db->insert($this->table, $data);

			return $insert ? $this->db->insert_id() : false;
		}

		return false;
	}

	public function update($id = FALSE, $data = array()){
		if($id && !empty($data)){

			$this->db->where('id', $id);
			$update = $this->db->update($this->table, $data);

			return $update ? $this->db->affected_rows() : false;
		}

		return false;
	}


}