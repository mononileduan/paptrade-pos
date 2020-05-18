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
			
			<div class="container-fluid with-color-accent">

				<div class="row">
			        
			        <div class="col-sm-2 col-md-2">

			        </div>

			        <div class="col-sm-10 col-md-10" id="page-content">
			            <h2 class="page-header">Change Password</h2>
						<div class="margin-left-20px">
				            <div class="row">
								<div class="col-md-4">
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<span class="panel-title"><span class="glyphicon glyphicon-edit"></span>&nbsp; Details</span>
											</h4>
										</div>
										<div class="panel-body">
											<form action="" method="post" accept-charset="utf-8" autocomplete="off">
												<div class="form-group">
													<label for='old_password'>Password</label>
													<input required="required" type="password" id="old_password" name="old_password" class="form-control">
													<?php echo form_error('old_password', '<small class="has-error"><p class="help-block">','</p></small>'); ?>
												</div>
												<div class="form-group">
													<label for='new_password'>New Password</label>
													<input required="required" type="password" id="new_password" name="new_password" class="form-control" maxlength="50">
													<?php echo form_error('new_password', '<small class="has-error"><p class="help-block">','</p></small>'); ?>
												</div>
												<div class="form-group">
													<label for='confirm_password'>Confirm Password</label>
													<input required="required" type="password" id="confirm_password" name="confirm_password" class="form-control" maxlength="50">
													<?php echo form_error('confirm_password', '<small class="has-error"><p class="help-block">','</p></small>'); ?>
												</div>
												<input type="submit" name="submit" class="btn btn-sm btn-primary" value="Submit">
											</form>
										</div>
									</div>
								</div>
							</div>
			            </div>
			        </div>
	    		</div>
	    	</div>
		</div>

		
		<?php $this->load->view('components/modals'); ?>

		<script type="text/javascript" src="assets/bootstrap/3.4.1/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="assets/datatables/datatables.min.js"></script>

		<script type="text/javascript" src="assets/js/page.height.setter.js"></script>

		<script type="text/javascript">
			$(document).ready(function() {
				
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

			    $('#success_modal').on('hide.bs.modal', function () {
			    	window.location.replace('<?= site_url('users/dashboard') ?>');
				});

			});
		</script>
	</body>
</html>