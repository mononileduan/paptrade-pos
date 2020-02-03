<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Sales_On_Hold_Dtls_Model extends CI_Model {
	public function __construct(){
		$this->table = 'sales_on_hold_dtls';
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
		"SALES_ON_HOLD_ID, ".
		"dtl.INVENTORY_ID as INVENTORY_ID, ".
		"ITEM_NAME, ".
		"UNIT_PRICE, ".
		"dtl.QUANTITY as QUANTITY, ".
		"SUB_TOTAL, ".
		"inv.QUANTITY as STOCKS ".
		"FROM sales_on_hold hold, sales_on_hold_dtls dtl, inventories_branch inv ".
		"WHERE dtl.SALES_ON_HOLD_ID=hold.id AND inv.INVENTORY_ID=dtl.INVENTORY_ID ";
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

	public function delete($data = array()){

		$delete = $this->db->delete($this->table, $data);

		return $delete ? $this->db->affected_rows() : false;
	}


}