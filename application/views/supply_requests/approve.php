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
			        
			        <?php $this->load->view('components/menu'); ?>

			        <div class="col-sm-10 col-md-10" id="page-content">
			            <h2 class="page-header">Supply Request</h2>
			            <div class="margin-left-20px">
				            <div class="row">
				            	<div class="col-md-4">
							    	<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<span class="panel-title"><span class="glyphicon glyphicon-tasks"></span>&nbsp; Approval Details</span>
											</h4>
										</div>
										<div class="panel-body">
											<form action="" method="post" accept-charset="utf-8" class="form-horizontal">
												<div class="row">
													<label class="col-sm-5 control-label">Available Stocks</label>
													<div class="col-sm-7">
														<p class="form-control-static"><?= isset($wh_item['AVAILABLE_QTY']) ? $wh_item['AVAILABLE_QTY'] : '0'; ?></p>
													</div>
												</div>
												<div class="row">
													<label class="col-sm-5 control-label" for="approved_qty">Approved Quantity</label>
													<div class="col-sm-7">
														<input required="required" type="text" value="<?php echo (set_value('approved_qty') != null) ? set_value('approved_qty') : $req['QTY']; ?>" id="approved_qty" name="approved_qty" class="form-control" maxlength="5" size="5">
													</div>
												</div>

												<div class="row-pad"></div>

												<div class="form-group row">
													<label class="col-sm-5 control-label"></label>
													<div class="col-sm-7">
														<input type="hidden" name="id" value="<?= $req['ID']; ?>">
														<input type="button" class="btn btn-sm btn-secondary back-btn" value="Back">
														<?php 
														if($req['STATUS'] == 'NEW'){
															echo '<input type="submit" name="submit_approve_request" class="btn btn-sm btn-primary" value="Approve">';
														}
														?>
													</div>
												</div>
											</form>
										</div>
									</div>
								</div>
								<div class="col-md-6">
							    	<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<span class="panel-title"><span class="glyphicon glyphicon-tasks"></span>&nbsp; Request Details</span>
											</h4>
										</div>
										<div class="panel-body">
											<form class="form-horizontal">
												<div class="row">
													<label class="col-sm-4 control-label">Item</label>
													<div class="col-sm-8">
														<p class="form-control-static"><?= $req['ITEM']; ?></p>
													</div>
												</div>
												<div class="row">
													<label class="col-sm-4 control-label">Quantity</label>
													<div class="col-sm-8">
														<p class="form-control-static"><?= $req['QTY']; ?></p>
													</div>
												</div>
												<div class="row">
													<label class="col-sm-4 control-label">Branch</label>
													<div class="col-sm-8">
														<p class="form-control-static"><?= $req['BRANCH']; ?></p>
													</div>
												</div>
												<div class="row">
													<label class="col-sm-4 control-label">Requested By</label>
													<div class="col-sm-8">
														<p class="form-control-static"><?= $req['REQUESTED_BY']; ?></p>
													</div>
												</div>
												<div class="row">
													<label class="col-sm-4 control-label">Requested Date</label>
													<div class="col-sm-8">
														<p class="form-control-static"><?= $req['REQUESTED_DT']; ?></p>
													</div>
												</div>
											</form>
										</div>
									</div>
								</div>
								<div class="col-md-offset-1"></div>
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
				var ref_no = "<?php if(isset($ref_no)){ echo $ref_no; } else {echo '';} ?>";
				var params = "?ref_no=" + ref_no;
				
	    		$('.back-btn').on('click', function () {
			        window.location.replace('<?= site_url('supply_requests/warehouse') ?>' + params);
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