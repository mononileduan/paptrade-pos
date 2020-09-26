<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Supply_Request extends CI_Model {
	
	public function __construct(){
		$this->table = 'supply_requests';
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
				$this->db->order_by('REF_NO', 'desc');
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
			"sr.ID as ID, ". 
			"sr.REF_NO as REF_NO, ". 
			"b.BRANCH_NAME as BRANCH, ". 
			"concat(br.BRAND, ' ', i.DSCP) as ITEM, ". 
			"sr.ITEM_ID as ITEM_ID, ". 
			"sr.QTY as QTY, ". 
			"concat(rqu.FIRST_NAME, ' ', rqu.LAST_NAME) as REQUESTED_BY, ". 
			"sr.REQUESTED_DT as REQUESTED_DT, ". 
			"sr.STATUS as STATUS, ". 
			"sr.APPROVED_QTY as APPROVED_QTY"; 
			
			if(array_key_exists("status", $params)){
				if($params['status'] == 'APPROVED'){
					$sql .= ", concat(apu.FIRST_NAME, ' ', apu.LAST_NAME) as PROCESSED_BY, ". 
					"sr.PROCESSED_DT as PROCESSED_DT";
				}else if($params['status'] == 'RECEIVED'){
					$sql .= ", concat(apu.FIRST_NAME, ' ', apu.LAST_NAME) as PROCESSED_BY, ". 
					"sr.PROCESSED_DT as PROCESSED_DT, ". 
					"concat(ru.FIRST_NAME, ' ', ru.LAST_NAME) as RECEIVED_BY, ". 
					"sr.RECEIVED_DT as RECEIVED_DT";
				}
			}
			
			$sql .= " FROM supply_requests sr, brands br, items i, branches b, users rqu";

			if(array_key_exists("status", $params)){
				if($params['status'] == 'APPROVED'){
					$sql .= ", users apu";
				}else if($params['status'] == 'RECEIVED'){
					$sql .= ", users apu, ".
					"users ru";
				}
			}
			
			$sql .= " WHERE sr.del=false AND i.id=sr.item_id AND br.id=i.brand_id AND b.id=sr.branch_id AND rqu.username=sr.requested_by ";
			
			if(array_key_exists("status", $params)){
				if($params['status'] == 'APPROVED'){
					$sql .= "AND apu.username=sr.processed_by ";
				}else if($params['status'] == 'RECEIVED'){
					$sql .= "AND apu.username=sr.processed_by ".
					"AND ru.username=sr.received_by ";
				}
			}

		if(array_key_exists("conditions", $params)){
			foreach ($params['conditions'] as $key => $val) {
				$sql = $sql . " AND " . $key . "='" . $val . "'"; 
			}
		}
		$sql = $sql . " ORDER BY REF_NO DESC";
		$result = $this->db->query($sql);
		return $result;

	}


	public function getWhDashboardData($params = array()){
		$sql = "SELECT ". 
			"sr.ID as ID, ". 
			"sr.REF_NO as REF_NO, ". 
			"b.BRANCH_NAME as BRANCH, ". 
			"sum(sr.QTY) as QTY, ". 
			"concat(rqu.FIRST_NAME, ' ', rqu.LAST_NAME) as REQUESTED_BY, ". 
			"sr.STATUS as STATUS "; 
						
		$sql .= " FROM supply_requests sr, brands br, items i, branches b, users rqu";
		
		$sql .= " WHERE sr.del=false AND i.id=sr.item_id AND br.id=i.brand_id AND b.id=sr.branch_id AND rqu.username=sr.requested_by AND sr.STATUS='NEW'";
			
		$sql .= " GROUP BY sr.REF_NO, sr.BRANCH_ID, REQUESTED_BY ";

		$sql = $sql . " ORDER BY REF_NO DESC";
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

	public function delete($id = FALSE){
		if($id){

			$this->db->where('id', $id);
			$delete = $this->db->delete($this->table);

			return $delete ? $this->db->affected_rows() : false;
		}

		return false;
	}

}