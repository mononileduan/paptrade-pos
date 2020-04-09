<!DOCTYPE html>
<html lang="en">
	<head>
		<title>POS & Inventory System</title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="base_url" content="<?= base_url() ?>">
		<meta name="index_page" content="<?= index_page() ?>">
		<meta name="user" content="<?=$this->session->userdata('fullname')?>">
		<base href="<?= site_url() ?>">
		<link rel="shortcut icon" type="image/x-icon" href="assets/images/paptrade-icon.png" />

	 	<link rel="stylesheet" type="text/css" href="assets/bootstrap/3.4.1/css/bootstrap.css">
	 	<link rel="stylesheet" type="text/css" href="assets/datatables/datatables.min.css"/>
	    <link rel="stylesheet" type="text/css" href="assets/datatables/DataTables-1.10.20/css/jquery.dataTables.css">
	    <link rel="stylesheet" type="text/css" href="assets/materialicons/material-icons.css">
	 	<link rel="stylesheet" type="text/css" href="assets/css/styles.css">
	 	<link rel="stylesheet" type="text/css" href="assets/pos/pos.css">
		
    	<script src="assets/jquery/3.4.1/jquery.min.js"></script>
	</head>

	<body>
		<div>

			<?php $this->load->view('components/navbar'); ?>
			
			<div class="container-fluid" style="margin-top:0px;">
				<div class="row">
					<div class="col-md-7 box-container rightnone" style="height: 694px; overflow-y: auto;">
						<h3>List of Items</h3>

						<div class="content">
	            			<table id="item-table" class="table table-bordered table-striped table-hover" style="width:100%">
								<thead>
									<tr>
										<td></td>
										<td>Item</td>
										<td>Category</td>
										<td>Stocks</td>
										<td>Unit Price</td>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
	            		</div>
					</div>
					<div class="col-md-5 box-container">
						<h3>Order Details</h3>
						<div id="sales-dtls-container">
							<table class="table table-striped" style="width:100%; margin-bottom: 10px;">
								<tr>
									<td width="20%">
										<a id="open-temp-txn"><span class="open" style="font-size:14px;"><i class="glyphicon glyphicon-folder-open" title="Open Saved Transactions"></i></span></a> &nbsp; &nbsp;
										<a id="save-temp-txn"><span class="save" style="font-size:14px;"><i class="glyphicon glyphicon-floppy-disk" title="Save for Later"></i></span></a>
									</td>
									<td width="30%" class="text-right" style="vertical-align: middle;">
										<label style="margin-bottom: 0px;">Sales Count:&nbsp;</label><span id="daily_sales_cnt"><?= $daily_sales_cnt ?></span>
									</td>
									<td width="50%" class="text-right" style="vertical-align: middle;">
										<label style="margin-bottom: 0px;">Total Sales:&nbsp;</label><span id="daily_total_sales"><?= $daily_total_sales ?></span>
									</td>
								</tr>
							</table>
						</div>
						<div class="content" style="padding-top: 0; ">
	            			<div id="cart-container">
		            			<table id="cart" class="table" style="width:100%">
									<thead>
										<tr>
											<th width="50%">Item</th>
											<th width="15%" class="text-right">Unit Price</th>
											<th width="15%" class="text-right">Quantity</th>
											<th width="15%" class="text-right">Sub-Total</th>
											<th width="5%"> </th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>

							<div class="col-md-12" style="border-bottom: solid 1px #ddd;padding: 15px 25px;">
								<div style="">Grand Total: <span id="amount-total" class="pull-right"></span></div>
								
							</div>
							<div class="col-md-12" style="padding: 15px 25px;">
								<form id="process-form">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<input type="text" class="form-control" name="" placeholder="Enter Payment" id="payment" autocomplete="off" max="500000" maxlength="6">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<input readonly="readonly" type="text" class="form-control" name="" placeholder="Change:" id="change" autocomplete="off">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<input type="submit" class="btn btn-primary form-control" name="" value="Process" id="btn" >
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<input type="hidden" name="sales_temp_id" id="sales_temp_id">
												<input type="button" class="btn btn-success form-control" name="" value="Save for Later" id="btn-save" >
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<input type="button" class="btn btn-info form-control" name="" value="View Saved Transactions" id="btn-view-saved" >
											</div>
										</div>
									</div>
								</form>

								<?php
									if(!empty($success_msg)){
										echo '<p class="status-msg success">'.$success_msg.'</p>';
									}elseif(!empty($error_msg)){
										echo '<p class="alert alert-danger col-sm-12">'.$error_msg.'</p>';
									}
								?>
							</div>
	            		</div>
					</div>
			        
	    		</div>
	    	</div>
		</div>

		<div class="modal" tabindex="-1" role="dialog" id="payment-modal">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Transaction Complete</h5>
					</div>
					<div class="modal-body">
						<div class="col-md-8">
							<div id="receipt">
								<div class="r-header text-center">
									<h3>Receipt</h3>
									<div class="row">
										<div class="col-md-4 text-right">
											<div>Reference No.:</div>
											<div>Date: <span></span></div>
											<div>Time:</div>
											<div>Cashier:</div>
										</div>
										<div class="col-md-8 text-left">
											<div id="r-id">005250</div>
											<div id="r-date">01/26/2020</div>
											<div id="r-time">03:22 pm</div> 
											<div id="r-cashier">Cashier</div>
										</div>
									</div>
									<div class="clearfix"></div>
								</div>
								<div class="r-body">
									<table class="table table-striped" id="r-items-table">
										<thead>
											<tr> 
												<th>Item Name</th>
												<th class="text-right">Price</th>
												<th class="text-right">Quantity</th>
												<th class="text-right">Sub Total</th>
											</tr>
										</thead>
										<tbody>

										</tbody>
									</table>
									<hr>
									<div class="row">
										<div class="col-md-4 text-right">
											<div>Grand Total:</div>
											<div>Payment: <span></span></div>
											<div>Change:</div>
										</div>
										<div class="col-md-8 text-right">
											<div id="r-total-amount">Total Amount</div>
											<div id="r-payment">Payment</div>
											<div id="r-change">Change</div>
										</div>
									</div>

									<div class="r-footer">
										<p>Thank you for shopping at our store</p>
									</div>
								</div>

							</div>
						</div>
						
						<div class="col-md-4">
							<h4 class="">Transaction Summary</h3> 
							<table class="table"> 
								<tr>
									<td>Grand Total:</td>
									<td id="summary-total" class="text-right"></td>
								</tr>
								<tr>
									<td>Payment:</td>
									<td id="summary-payment" class="text-right"></td>
								</tr>
								<tr>
									<td>Change:</td>
									<td id="summary-change" class="text-right"></td>
								</tr>
							</table>
							<button class="btn btn-default btn-sm" id="print">Print Receipt</button>
						</div>

						<div class="clearfix"></div>

					</div>
					<div class="modal-footer"> 
						<button type="button" class="btn btn-secondary" data-dismiss="modal" id="payment-modal-close">Close</button>
					</div>

				</div>

			</div>
		</div>

		<div class="modal" tabindex="-2" role="dialog" id="customer-name-modal">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Save for Later</h5>
					</div>
					<div class="modal-body">
						<div class="col-md-12">
							<div class="form-group">
								<input type="text" class="form-control" name="customer_name" placeholder="Enter Customer Name" id="customer_name" autocomplete="off" max="50" maxlength="50">
							</div>
						</div>

						<div class="clearfix"></div>

					</div>
					<div class="modal-footer"> 
						<button type="button" class="btn btn-success" id="customer-name-confirm-btn">Confirm</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					</div>

				</div>

			</div>
		</div>

		<div class="modal" tabindex="-3" role="dialog" id="sales-tmp-modal">
			<div class="modal-dialog modal-md">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Saved for Later Transactions</h5>
					</div>
					<div class="modal-body">
						<div id="sales-tmp-container" style="min-height: 310px; max-height: 185px;">
	            			<table id="sales-tmp" class="table table-bordered table-striped table-hover" style="width:100%">
								<thead>
									<tr>
										<td>ID</td>
										<td>Branch</td>
										<td width="40%">Customer Name</td>
										<td width="10%">Products</td>
										<td width="35%">Cashier</td>
										<td width="15%">Date</td>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
						<div class="clearfix"></div>

					</div>
					<div class="modal-footer"> 
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>

				</div>

			</div>
		</div>


		<?php $this->load->view('components/modals'); ?>

		<script type="text/javascript" src="assets/datatables/datatables.min.js"></script>
		<script type="text/javascript" src="assets/bootstrap/3.4.1/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="assets/pos/jQuery.print.js"></script>
		<script type="text/javascript" src="assets/pos/pos.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
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

				$('#success_modal').on('hide.bs.modal', function () {
			    	if($('#success_modal').data('trigger') =='not-new'){
						window.location.replace('<?= site_url('/brands/index') ?>');
			    	}
				});
			});
		</script>
	</body>
</html>