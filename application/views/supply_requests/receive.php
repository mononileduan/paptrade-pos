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

			        <div class="col-sm-10 col-md-10" id="page-content">
			            <h2 class="page-header">View Supply Request</h2>

						<div class="row-pad"></div>

						<div class="row-pad"></div>

						<div class="form-horizontal">
						    <div class="row form-group">
								<div class="col-sm-2"><label>Item</label></div>
								<div class="col-sm-10"><?= $req['ITEM']; ?></div>
							</div>
							 <div class="row form-group">
								<div class="col-sm-2"><label>Quantity</label></div>
								<div class="col-sm-10"><?= $req['QTY']; ?></div>
							</div>
							 <div class="row form-group">
								<div class="col-sm-2"><label>Branch</label></div>
								<div class="col-sm-10"><?= $req['BRANCH']; ?></div>
							</div>
							 <div class="row form-group">
								<div class="col-sm-2"><label>Requested By</label></div>
								<div class="col-sm-10"><?= $req['REQUESTED_BY']; ?></div>
							</div>
							<div class="row form-group">
								<div class="col-sm-2"><label>Requested Date</label></div>
								<div class="col-sm-10"><?= $req['REQUESTED_DT']; ?></div>
							</div>
							<?php 
							if($req['STATUS'] == 'APPROVED' || $req['STATUS'] == 'RECEIVED'){
								echo '<div class="row form-group">';
								echo '<div class="col-sm-2"><label>Approved Quantity</label></div>';
								echo '<div class="col-sm-10">'.$req['APPROVED_QTY'].'</div>';
								echo '</div>';

								echo '<div class="row form-group">';
								echo '<div class="col-sm-2"><label>Processed By</label></div>';
								echo '<div class="col-sm-10">'.$req['PROCESSED_BY'].'</div>';
								echo '</div>';

								echo '<div class="row form-group">';
								echo '<div class="col-sm-2"><label>Date Processed</label></div>';
								echo '<div class="col-sm-10">'.$req['PROCESSED_DT'].'</div>';
								echo '</div>';
							}

							if($req['STATUS'] == 'RECEIVED'){
								echo '<div class="row form-group">';
								echo '<div class="col-sm-2"><label>Received By</label></div>';
								echo '<div class="col-sm-10">'.$req['RECEIVED_BY'].'</div>';
								echo '</div>';

								echo '<div class="row form-group">';
								echo '<div class="col-sm-2"><label>Date Received</label></div>';
								echo '<div class="col-sm-10">'.$req['RECEIVED_DT'].'</div>';
								echo '</div>';
							}
							?>
						</div>

						<div class="row-pad"></div>

						<div class="row-pad"></div>


						<div class="row">
						    <div class="col-md-12">
						    	<form action="" method="post" accept-charset="utf-8" class="form-horizontal">
									<div class="row form-group">
										<div class="col-sm-12">
											<input type="hidden" name="id" value="<?= $req['ID']; ?>">
											<input type="hidden" name="approved_qty" value="<?= $req['APPROVED_QTY']; ?>">
											<input type="button" class="btn btn-secondary back-btn" value="Back">
											<?php
											if($req['STATUS'] == 'APPROVED'){
												echo '<input type="submit" name="submit_receive_request" class="btn btn-success" value="Receive">';
											}
											?>
										</div>
									</div>
								</form>
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
	    		$('.back-btn').on('click', function () {
			        window.location.replace('<?= site_url('supply_requests/branch') ?>');
			    } );

			    var success_msg = "<?php if(isset($success_msg)){ echo $success_msg; } else {echo '';} ?>";
			    var error_msg = "<?php if(isset($error_msg)){ echo $error_msg; } else {echo '';} ?>";

			    if(success_msg){
			    	$("#success_modal .modal-content .modal-body p.text-center").text(success_msg);
			    	$("#success_modal").modal('show');
			    }

			    if(error_msg){
			    	$("#error_modal .modal-content .modal-body p.text-center").text(error_msg);
			    	$("#error_modal").modal('show');
			    }


			});
		</script>
	</body>
</html>