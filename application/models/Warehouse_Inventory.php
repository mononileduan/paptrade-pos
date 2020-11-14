<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Warehouse_Inventory extends CI_Model {
	public function __construct(){
		$this->table = 'WAREHOUSE_INVENTORY';
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
			"inv.id as ID, ".
			"inv.item_id as ITEM_ID, ".
			"concat(b.BRAND, ' ', i.DSCP) as ITEM, ". 
			"c.category as CATEGORY, ".
			"i.price as PRICE, ".
			"inv.CURRENT_QTY as CURRENT_QTY, ".
			"inv.AVAILABLE_QTY as AVAILABLE_QTY, ".
			"inv.CRITICAL_QTY as CRITICAL_QTY, ".
			"i.CRITICAL_QTY as ITEM_CRIT_QTY ".
			"FROM WAREHOUSE_INVENTORY inv, ITEMS i, BRANDS b, CATEGORIES c ".
			"WHERE i.id=inv.item_id and b.id=i.brand_id and c.id=i.category_id and inv.del=false and i.del=false ";

		if(array_key_exists("conditions", $params)){
			foreach ($params['conditions'] as $key => $val) {
				$sql = $sql . " AND " . $key . "='" . $val . "'"; 
			}
		}

		$sql = $sql . " ORDER BY ITEM ";
		$result = $this->db->query($sql);
		return $result;

	}

	public function getLowStocks($params = array()){
		$sql = "SELECT ". 
			"inv.id as ID, ".
			"inv.item_id as ITEM_ID, ".
			"concat(b.BRAND, ' ', i.DSCP) as ITEM, ". 
			"c.category as CATEGORY, ".
			"i.price as PRICE, ".
			"inv.CURRENT_QTY as CURRENT_QTY, ".
			"inv.AVAILABLE_QTY as AVAILABLE_QTY, ".
			"inv.CRITICAL_QTY as CRITICAL_QTY, ".
			"i.CRITICAL_QTY as ITEM_CRIT_QTY ".
			"FROM WAREHOUSE_INVENTORY inv, ITEMS i, BRANDS b, CATEGORIES c ".
			"WHERE i.id=inv.item_id and b.id=i.brand_id and c.id=i.category_id and inv.del=false and i.del=false ".
			"and inv.AVAILABLE_QTY <= inv.CRITICAL_QTY ";

		if(array_key_exists("conditions", $params)){
			foreach ($params['conditions'] as $key => $val) {
				$sql = $sql . " AND " . $key . "='" . $val . "'"; 
			}
		}
		$sql = $sql . " ORDER BY ITEM ";
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
}

?>