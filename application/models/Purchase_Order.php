<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Purchase_Order extends CI_Model {
	public function __construct(){
		$this->table = 'purchase_orders';
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
		"po.ID, ".
		"po.REF_NO as REF_NO, ".
		"sup.SUPPLIER_NAME as SUPPLIER_NAME, ".
		"DATE_FORMAT(po.ORDERED_DT,'%m/%d/%Y') as ORDERED_DT, ".
		"CONCAT(usr.FIRST_NAME, ' ', usr.LAST_NAME) as ORDERED_BY, ".
		"DATE_FORMAT(po.EXPECTED_DT,'%m/%d/%Y') as EXPECTED_DT, ".
		"po.STATUS as STATUS ".
		"FROM Purchase_Orders po, Suppliers sup, User_ usr WHERE sup.id=po.supplier_id AND usr.username=po.ordered_by";
		if(array_key_exists("conditions", $params)){
			foreach ($params['conditions'] as $key => $val) {
				$sql = $sql . " AND " . $key . "='" . $val . "'"; 
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