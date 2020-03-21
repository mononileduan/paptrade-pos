<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Item extends CI_Model {
	public function __construct(){
		$this->table = 'items';
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
			"i.id as ID, ".
			"b.brand as BRAND, ".
			"i.dscp as DSCP, ".
			"c.category as CATEGORY, ".
			"CRITICAL_QTY, ".
			"s.stock_type as STOCK_TYPE, ".
			"STOCK_TYPE_CONTENT ".
			"FROM items i, brands b, categories c, stock_types s ".
			"WHERE b.id=i.brand_id AND c.id=i.category_id AND s.id=i.stock_type_id and i.del=false ";

		if(array_key_exists("conditions", $params)){
			foreach ($params['conditions'] as $key => $val) {
				$sql = $sql . " AND " . $key . "='" . $val . "'"; 
			}
		}
		$sql = $sql . "ORDER BY b.brand, i.dscp ";
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