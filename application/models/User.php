<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class User extends CI_Model {

	public function __construct(){
		$this->table = 'USERS';
	}

	public function getRows($params = array()){
		$this->db->select('*');
		$this->db->from($this->table);

		if(array_key_exists("conditions", $params)){
			foreach ($params['conditions'] as $key => $val) {
				$this->db->where($key, $val);
			}
		}

		if(array_key_exists("not_in", $params)){
			foreach ($params['not_in'] as $key => $val) {
				$this->db->where_not_in($key, $val);
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
				$result = ($query->num_rows() > 0) ? $query->result_array() : false;
			}
		}

		return $result;
	}


	public function getRowsJoin($params = array()){
		$sql = "SELECT ". 
			"u.id as ID, ". 
			"u.username as USERNAME, ". 
			"u.password as PASSWORD, ". 
			"u.branch_id as BRANCH_ID, ". 
			"b.branch_name as BRANCH_NAME, ". 
			"u.role as ROLE, ". 
			"u.status as STATUS, ". 
			"u.last_login_dt as LAST_LOGIN_DT, ".
			"u.last_name as LAST_NAME, ".
			"u.first_name as FIRST_NAME, ".
			"u.retry_cnt as RETRY_CNT ".
			"FROM USERS u, BRANCHES b ". 
			"WHERE b.id=u.branch_id ";

		if(array_key_exists("conditions", $params)){
			foreach ($params['conditions'] as $key => $val) {
				$sql = $sql . " AND " . $key . "='" . $val . "'"; 
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