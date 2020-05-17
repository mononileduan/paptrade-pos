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
			            <h2 class="page-header">Supply Request</h2>
			            <div class="margin-left-20px">
			            	<div class="row">
			            		<div class="col-md-10">
			            			<div class="row">
										<div class="col-md-12">
									    	<div class="panel panel-default">
												<div class="panel-heading">
													<h4 class="panel-title">
														<span class="panel-title"><span class="glyphicon glyphicon-tasks"></span>&nbsp; Request Status</span>
													</h4>
												</div>
												<div class="panel-body">
													<form class="form-horizontal">
														<div class="row">
															<label class="col-sm-2 control-label">Status</label>
															<div class="col-sm-10">
																<p class="form-control-static"><?= $req['STATUS']; ?></p>
															</div>
														</div>
													</form>
												</div>
											</div>
										</div>
									</div>
					            	<div class="row">
					            		<div class="col-md-7">
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
					            		<div class="col-md-5">
					            			<div class="row">
												<div class="col-md-12">
											    	<div class="panel panel-default">
														<div class="panel-heading">
															<h4 class="panel-title">
																<span class="panel-title"><span class="glyphicon glyphicon-tasks"></span>&nbsp; Approval Details</span>
															</h4>
														</div>
														<div class="panel-body">
															<form class="form-horizontal">
																<div class="row">
																	<label class="col-sm-5 control-label">Approved Quantity</label>
																	<div class="col-sm-7">
																		<p class="form-control-static"><?= isset($req['APPROVED_QTY']) ? $req['APPROVED_QTY'] : ''; ?></p>
																	</div>
																</div>

																<div class="row">
																	<label class="col-sm-5 control-label">Processed By</label>
																	<div class="col-sm-7">
																		<p class="form-control-static"><?= isset($req['PROCESSED_BY']) ? $req['PROCESSED_BY'] : ''; ?></p>
																	</div>
																</div>

																<div class="row">
																	<label class="col-sm-5 control-label">Date Processed</label>
																	<div class="col-sm-7">
																		<p class="form-control-static"><?= isset($req['PROCESSED_DT']) ? $req['PROCESSED_DT'] : ''; ?></p>
																	</div>
																</div>
															</form>
														</div>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-md-12">
											    	<div class="panel panel-default">
														<div class="panel-heading">
															<h4 class="panel-title">
																<span class="panel-title"><span class="glyphicon glyphicon-tasks"></span>&nbsp; Receiving Details</span>
															</h4>
														</div>
														<div class="panel-body">
															<form class="form-horizontal">
																<div class="row">
																	<label class="col-sm-5 control-label">Received By</label>
																	<div class="col-sm-7">
																		<p class="form-control-static"><?= isset($req['RECEIVED_BY']) ? $req['RECEIVED_BY'] : ''; ?></p>
																	</div>
																</div>
																<div class="row">
																	<label class="col-sm-5 control-label" for="approved_qty">Date Received</label>
																	<div class="col-sm-7">
																		<p class="form-control-static"><?= isset($req['RECEIVED_DT']) ? $req['RECEIVED_DT'] : ''; ?></p>
																	</div>
																</div>
															</form>
														</div>
													</div>
												</div>
											</div>
					            		</div>
					            	</div>
			            		</div>
			            		<div class="col-md-offset-1"></div>
			            	</div>
							<input type="button" class="btn btn-sm btn-secondary back-btn" value="Back">
			            </div>
			        </div>
	    		</div>
	    	</div>
		</div>

		<script type="text/javascript" src="assets/bootstrap/3.4.1/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="assets/datatables/datatables.min.js"></script>

		<script type="text/javascript" src="assets/js/page.height.setter.js"></script>

		<script type="text/javascript">
			$(document).ready(function() {
	    		$('.back-btn').on('click', function () {
			        window.location.replace('<?= site_url('supply_requests/'.$return_page) ?>');
			    } );
			});
		</script>
	</body>
</html>