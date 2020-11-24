<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Technicals extends CI_Controller {
	
	public function __construct(){
		parent::__construct();

		$this->isLoggedIn = $this->session->userdata('isLoggedIn');
	}


	public function index(){
		if($this->isLoggedIn && $this->session->userdata('status') == $this->config->item('USER_STATUS_ASSOC')['ACTIVE'][0]){
			if(in_array('MANAGE_DB', $this->config->item('USER_ROLE_ASSOC_MENU')[$this->session->userdata('user_role')])){
				$data = array();

				$this->load->view('technicals/index', $data);

			}else{
				$this->load->view('components/unauthorized');
			}
		}else{
			redirect('users/logout');
		}
	}

	public function backupDB(){

		if($this->isLoggedIn && $this->session->userdata('status') == $this->config->item('USER_STATUS_ASSOC')['ACTIVE'][0]){
			if(in_array('MANAGE_DB', $this->config->item('USER_ROLE_ASSOC_MENU')[$this->session->userdata('user_role')])){
				
				$hostname = $this->config->item('default')['hostname'];
				$username = $this->config->item('default')['username'];
				$password = $this->config->item('default')['password'];
				$database = $this->config->item('default')['database'];

				$connection = mysqli_connect('localhost','root','','paptrade-pos');
				$tables = array();
				$result = mysqli_query($connection,"SHOW TABLES");
				while($row = mysqli_fetch_row($result)){
				  $tables[] = $row[0];
				}
				$return = '';
				foreach($tables as $table){
				  $result = mysqli_query($connection,"SELECT * FROM ".$table);
				  $num_fields = mysqli_num_fields($result);
				  
				  $return .= 'DROP TABLE '.$table.';';
				  $row2 = mysqli_fetch_row(mysqli_query($connection,"SHOW CREATE TABLE ".$table));
				  $return .= "\n\n".$row2[1].";\n\n";
				  
				  for($i=0;$i<$num_fields;$i++){
				    while($row = mysqli_fetch_row($result)){
				      $return .= "INSERT INTO ".$table." VALUES(";
				      for($j=0;$j<$num_fields;$j++){
				        $row[$j] = addslashes($row[$j]);
				        if(isset($row[$j])){ $return .= '"'.$row[$j].'"';}
				        else{ $return .= '""';}
				        if($j<$num_fields-1){ $return .= ',';}
				      }
				      $return .= ");\n";
				    }
				  }
				  $return .= "\n\n\n";
				}
				//save file
				$handle = fopen("C:\Users\admin\Documents\THESIS\Inventory_".date('YmdHis').".sql","w+");
				fwrite($handle,$return);
				fclose($handle);
				echo "Successfully backed up";

			}else{
				$this->load->view('components/unauthorized');
			}
		}else{
			redirect('users/logout');
		}


	}
		
}