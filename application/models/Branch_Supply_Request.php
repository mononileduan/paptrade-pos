<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Branch_Supply_Request extends CI_Model {
	public function __construct(){
		$this->table = 'branch_supply_requests';
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
		"req.ID as ID, ".
		"concat(b.BRAND, ' - ', m.MODEL) as ITEM, ".
		"req.DSCP as DSCP, ".
		"c.CATEGORY as CATEGORY, ".
		"req.QUANTITY as QUANTITY, ".
		"br.BRANCH_NAME as BRANCH, ".
		"req.STATUS as STATUS, ".
		"req.CREATED_BY as CREATED_BY, ".
		"req.CREATED_DT as CREATED_DT ".
		"FROM branch_supply_requests req, models m, brands b, categories c, branches br ".
		"where m.id=req.item_id AND b.id=m.brand_id AND c.id=m.category_id AND br.id=req.branch_id ";
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

?>