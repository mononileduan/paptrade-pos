<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Branch_Inventory_Hist extends CI_Model {
	public function __construct(){
		$this->table = 'branch_inventory_hist';
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
				$this->db->order_by('UPDATED_DT', 'desc');
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
			"inv.id as ID, ".
			"inv.inventory_id as INVENTORY_ID, ".
			"b.branch_name as BRANCH, ".
			"inv.ITEM as ITEM, ". 
			"inv.QTY as QTY, ".
			"inv.QTY_RUNNING as QTY_RUNNING, ".
			"inv.MOVEMENT as MOVEMENT, ".
			"concat(u.FIRST_NAME, ' ', u.LAST_NAME) as UPDATED_BY, ". 
			"inv.UPDATED_DT as UPDATED_DT, ". 
			"inv.REMARKS as REMARKS ". 
			"FROM branch_inventory_hist inv, users u, branches b ".
			"WHERE u.username=inv.updated_by and b.id=inv.branch_id and inv.del=false ";

		if(array_key_exists("conditions", $params)){
			foreach ($params['conditions'] as $key => $val) {
				$sql = $sql . " AND " . $key . "='" . $val . "'"; 
			}
		}
		$sql = $sql . " ORDER BY UPDATED_DT desc ";
		$result = $this->db->query($sql);
		return $result;

	}

	public function insert($data = array()){
		if(!empty($data)){

			$insert = $this->db->insert($this->table, $data);

			return $insert ? $this->db->insert_id() : false;
		}

		return false;
	}
}

?>