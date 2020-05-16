<!DOCTYPE html>
<html lang="en">
	<head>
		<title>POS & Inventory System</title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<base href="<?= site_url() ?>">
		<link rel="shortcut icon" type="image/x-icon" href="assets/images/paptrade-icon.png" />

	 	<link rel="stylesheet" type="text/css" href="assets/bootstrap/3.4.1/css/bootstrap.css">
	 	<link rel="stylesheet" type="text/css" href="assets/datatables/datatables.min.css"/>
	    <link rel="stylesheet" type="text/css" href="assets/materialicons/material-icons.css">
	 	<link rel="stylesheet" type="text/css" href="assets/css/styles.css">
		
    	<script src="assets/jquery/3.4.1/jquery.min.js"></script>
	</head>

	<body>

		<div>

			<?php $this->load->view('components/navbar'); ?>
			
			<div class="container-fluid">

				<div class="row">

			        <?php $this->load->view('components/menu'); ?>

			        <div class="col-sm-9 col-md-10" id="page-content">
			            <h2 class="page-header">Dashboard</h2>
			            <div class="row">
			            	<div div class="col-sm-12 col-md-12" id="content-container">
					            <?php
								if($this->session->userdata('user_role') == $this->config->item('USER_ROLE_ASSOC')['BRANCH_USER'][0]){
							        $this->load->view('dashboard/branch');

							    }else if($this->session->userdata('user_role') == $this->config->item('USER_ROLE_ASSOC')['WHOUSE_USER'][0]){
							        $this->load->view('dashboard/warehouse');
							        
							    }else if($this->session->userdata('user_role') == $this->config->item('USER_ROLE_ASSOC')['SYS_ADMIN'][0]){
							        $this->load->view('dashboard/sysadmin');
							    }
							    ?>
						    </div>
			            </div>
			        </div>

	    		</div>

	    	</div>

		</div>

		<?php $this->load->view('components/modals'); ?>

		<script type="text/javascript" src="assets/bootstrap/3.4.1/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="assets/datatables/datatables.min.js"></script>

		<script type="text/javascript">
			$(document).ready(function() {

				var dHeight = parseInt($(document).height());
			 	
				dHeight = dHeight - 150;
				$("#content-container").css('height', dHeight + 'px');
				$("#content-container").css('overflow-y', 'auto');

				dHeight = parseInt($(document).height());
			 	
				dHeight = dHeight - 60;
				$("#left-menu-container").css('height', dHeight + 'px');
				$("#left-menu-container").css('overflow-y', 'auto');

				
				var success_msg = "<?php if(isset($success_msg)){ echo $success_msg; } else {echo '';} ?>";
			    var error_msg = "<?php if(isset($error_msg)){ echo $error_msg; } else {echo '';} ?>";

			    if(success_msg){
			    	$("#success_modal .modal-content .modal-body p.text-center").text(success_msg);
			    	$("#success_modal").modal('show');
			    }

			    if(error_msg){
			    	if(error_msg.includes('You are locked')){
			    		$("#error_modal").attr('data-trigger', 'logout');
			    	}
			    	$("#error_modal .modal-content .modal-body p.text-center").text(error_msg);
			    	$("#error_modal").modal('show');
			    }

			    $('#error_modal').on('hide.bs.modal', function () {
			    	if($('#error_modal').data('trigger') =='logout'){
						window.location.replace('<?= site_url('/users/logout') ?>');
			    	}
				});
			})
		</script>

        <?php 
		if($this->session->userdata('user_role') == $this->config->item('USER_ROLE_ASSOC')['BRANCH_USER'][0]){
	        $this->load->view('dashboard/branch_js'); 

	    }else if($this->session->userdata('user_role') == $this->config->item('USER_ROLE_ASSOC')['WHOUSE_USER'][0]){
	        $this->load->view('dashboard/warehouse_js'); 
	        
	    }else if($this->session->userdata('user_role') == $this->config->item('USER_ROLE_ASSOC')['SYS_ADMIN'][0]){
	        $this->load->view('dashboard/sysadmin_js'); 
	    }
	    ?>
		
	</body>
</html>