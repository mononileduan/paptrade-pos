<!DOCTYPE html>
<html lang="en">
	<head>
		<title>POS & Inventory System</title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="base_url" content="<?= base_url();?><?= index_page();?>">
		<base href="<?= base_url();?><?= index_page();?>">
		<link rel="shortcut icon" type="image/x-icon" href="assets/images/iconpap.png" />
		
	    <link rel="stylesheet" type="text/css" href="assets/bootstrap/4.4.1/css/bootstrap.min.css">
	    <link rel="stylesheet" type="text/css" href="assets/fontawesome/5.12.0/css/fontawesome.min.css">

	    <link rel="stylesheet" type="text/css" href="assets/DataTables/datatables.min.css">
	    <link rel="stylesheet" type="text/css" href="assets/DataTables/DataTables-1.10.20/css/dataTables.bootstrap4.min.css">
	    <link rel="stylesheet" type="text/css" href="assets/DataTables/Buttons-1.6.1/css/buttons.bootstrap4.min.css">

	    <link rel="stylesheet" type="text/css" href="assets/datepicker/gijgo/css/gijgo.min.css">
	    <link rel="stylesheet" href="assets/pos-style.css">

    	<script src="assets/jquery/3.4.1/jquery.min.js"></script>
		<script type="text/javascript" src="assets/sweetalert/9.5.4/sweetalert2.all.min.js"></script>
	</head>

	<body>
		<div class="wrapper">
		    <!-- Page Content  -->
	        <div id="content-wrapper">
	        	<nav class="navbar navbar-expand-lg navbar-light bg-light">
	                <div class="container-fluid">

	                    <span style="margin-left: 30px;">
	                    	<img src="assets/images/paptrade-cropped.png" height="50px">
	                    </span> &nbsp;&nbsp;
	                    <h4><small>POS & Inventory System</small></h4>
	                    
						<button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
	                        <i class="fas fa-align-justify"></i>
	                    </button>

	                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
	                        <ul class="nav navbar-nav ml-auto">
	                        	<li class="nav-item active">
	                                <span class="nav-link" 
	                                style="margin-right: 50px; padding-right: 20px;">
	                                Hello, <?= $session_user; ?>! </span>
	                            </li>
	                            <li class="nav-item">
	                                <a class="nav-link" href="<?= base_url();?><?= index_page();?>/users/dashboard">Home</a>
	                            </li>
	                            <li class="nav-item">
	                                <a class="nav-link active" href="<?= base_url();?><?= index_page();?>/pos">POS</a>
	                            </li>
	                            <li class="nav-item">
	                                <a class="nav-link" href="<?= base_url();?><?= index_page();?>/users/logout">Logout</a>
	                            </li>
	                        </ul>
	                    </div>
	                </div>
	            </nav>


	            <div class="row header">
	            	<div class="col-md-6 box rightnone" style="height: 694px; overflow-y: auto;">
	            		<h3>List of Items</h3>
	            		<div class="content">
	            			<label>Select Item</label>
	            			<table id="item-table" class="table table-bordered table-striped table-hover" style="width:100%">
								<thead>
									<tr>
										<td>ID</td>
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

	            	<div class="col-md-6 box" style="height: 694px; overflow-y: auto;">
	            		<h3>Order Details</h3>
	            		<div class="content">
	            			<div id="cart-tbl" style="min-height: 310px; max-height: 185px;">
		            			<table id="cart" class="table table-bordered table-striped table-hover" style="width:100%">
									<thead>
										<tr>
											<td width="50%">Item</td>
											<td width="15%">Unit Price</td>
											<td width="15%">Quantity</td>
											<td width="15%">Sub-Total</td>
											<th width="5%"> </th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>

							<div class="col-md-12" style="border-bottom: solid 1px #ddd;padding: 15px 25px;">
								<!--div>Total Discount: <span id="amount-discount" class="pull-right">00.00</span></div--> 
								<div style="">Grand Total: <span id="amount-total" class="pull-right"></span></div>
								
							</div>
							<div class="col-md-12" style="padding: 15px 25px;">
								<form id="process-form">
									<div class="form-group">
										<input type="text" class="form-control" name="" placeholder="Enter Payment" id="payment" autocomplete="off" max="500000" maxlength="6">
									</div>
									<div class="form-group">
										 
										<input readonly="readonly" type="text" class="form-control" name="" placeholder="Change:" id="change" autocomplete="off">
										 
									</div>
									<div class="form-group">
										<input type="submit" class="btn btn-primary form-control" name="" value="Process" id="btn" >
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
							<!--<div class="col-md-12" style="border-bottom: solid 1px #ddd;padding: 15px 25px;">
								<label>Grand Total: </label>
								<span id="grand-total" class="align-right"></span>
							</div>
							<div class="col-md-12" style="padding: 15px 25px;">
								<form action="" method="post" accept-charset="utf-8">
									<div class="form-group">
										<label for='payment'>Payment</label>
										<input required="required" type="text" value="<?php echo set_value('payment'); ?>" name="payment" class="form-control">
										<?php echo form_error('payment', '<p class="help-block">','</p>'); ?>
									</div>
									<div class="form-group">
										<input type="submit" name="submit_payment" class="btn btn-success" value="Submit">
									</div>
								</form>
							</div>-->
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
							<div class="col-md-7">
								<div id="receipt">
									<div class="r-header text-center">
										<h3>Receipt</h3>
										<div class="row">
											<div class="col-md-4 text-left">
												<div>ID:</div>
												<div>Date: <span></span></div>
												<div>Cashier:</div>
												<div>Time:</div>
											</div>
											<div class="col-md-8 text-left">
												<div id="r-id">005250</div>
												<div id="r-date">01/26/2020</div>
												<div id="r-cashier">Cashier</div>
												<div id="r-time">03:22 pm</div> 
											</div>
										</div>
										<div class="clearfix"></div>
									</div>
									<div class="r-body">
										<table class="table table-striped" id="r-items-table">
											<thead>
												<tr> 
													<th>Item Name</th>
													<th>Price</th>
													<th>Quantity</th>
													<th>Sub Total</th>
												</tr>
											</thead>
											<tbody>

											</tbody>
										</table>
										<hr>
										<div class="text-right"> 
											<div>Discount: <span id="r-discount"></span></div>
											<div>Grand Total <span id="r-total-amount"></span></div>
											<div>Payment: <span id="r-payment"></span></div>
											<div>Change: <span id="r-change"></span></div>
										</div>

										<div class="r-footer">
											<p>Thank you for shopping at our store</p>
										</div>
									</div>

								</div>
							</div>
							
							<div class="col-md-5">
								<h4 class="">Transaction Summary</h3> 
								<table class="table"> 
									<tr>
										<td>Discount Amount:</td>
										<td id="summary-discount"></td>
									</tr>
									<tr>
										<td>Grand Amount:</td>
										<td id="summary-total"></td>
									</tr>
									<tr>
										<td>Payment:</td>
										<td id="summary-payment"></td>
									</tr>
									<tr>
										<td>Change:</td>
										<td id="summary-change"></td>
									</tr>
								</table>
								<button class="btn btn-default btn-sm" id="print">Print Receipt</button>
							</div>

							<div class="clearfix"></div>

						</div>
						<div class="modal-footer"> 
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</div>

					</div>

				</div>
			</div>
		</div>


	    <script src="assets/fontawesome/5.0.13/js/solid.js"></script>
	    <script src="assets/fontawesome/5.12.0/js/fontawesome.min.js"></script>

	    <!-- Popper.JS -->
	    <script src="assets/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	    <!-- Bootstrap JS -->
	    <script src="assets/bootstrap/4.4.1/js/bootstrap.min.js"></script>

	    <script type="text/javascript" src="assets/DataTables/datatables.min.js"></script>
	    <script type="text/javascript" src="assets/DataTables/DataTables-1.10.20/js/jquery.dataTables.min.js"></script>
	    <script type="text/javascript" src="assets/DataTables/DataTables-1.10.20/js/dataTables.bootstrap4.min.js"></script>
	    <script type="text/javascript" src="assets/DataTables/Buttons-1.6.1/js/dataTables.buttons.min.js"></script>
	    <script type="text/javascript" src="assets/DataTables/Buttons-1.6.1/js/buttons.bootstrap4.min.js"></script>
	    <script type="text/javascript" src="assets/DataTables/Buttons-1.6.1/js/buttons.flash.min.js"></script>
		<script type="text/javascript" src="assets/DataTables/Buttons-1.6.1/js/buttons.html5.min.js"></script>
		<script type="text/javascript" src="assets/DataTables/Buttons-1.6.1/js/buttons.print.min.js"></script>
		<script type="text/javascript" src="assets/datepicker/gijgo/js/gijgo.min.js"></script>


	    <script type="text/javascript">
	    	
		    function formatCurrency(ccy){
				var monetary_value = $(ccy).text();
		        var i = new Intl.NumberFormat('en-PH', { 
		            style: 'currency', 
		            currency: 'PHP' 
		        }).format(monetary_value); 
		        $(ccy).text(i); 
			}

		    function formatCurrencyVal(money){
		        var i = new Intl.NumberFormat('en-PH', { 
		            style: 'currency', 
		            currency: 'PHP' 
		        }).format(money); 
		        return i;
			}


			$(document).ready(function() {
				var table = $('#item-table').DataTable({
			        "ajax": {
			            url : "<?php echo site_url('inventories_branch/inventories_branch_page') ?>",
			            type : 'GET'
			        },
			        "columnDefs": [{
			        	className: "dt-right",
			        	"targets": [-1, -2]
			        }]
			        
			    });


			});
		</script>
		<script type="text/javascript" src="assets/jquery-pos.js"></script>
		<script type="text/javascript" src="assets/print.js"></script>
		<script type="text/javascript" src="assets/pos.js"></script>
	</body>
</html>