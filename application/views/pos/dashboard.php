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

		<link rel="stylesheet" type="text/css" href="assets/pos/bootstrap/css/bootstrap-3.3.7.css">
	    <link rel="stylesheet" type="text/css" href="assets/pos/pos-style.css">
	    <link rel="stylesheet" type="text/css" href="assets/pos/jquery-ui/jquery-ui-1.12.1.css">
	    <link rel="stylesheet" type="text/css" href="assets/pos/font-awesome/css/font-awesome-4.6.3.min.css">
	    <link rel="stylesheet" type="text/css" href="assets/pos/datatable/dataTables.bootstrap.css">
	    <link rel="stylesheet" type="text/css" href="assets/pos/datatable/dataTables.responsive.css">
	</head>

	<body>
		<div class="wrapper">
		    <!-- Page Content  -->
	        <div id="content-wrapper">
	        	<div class="col-md-12" style="padding: 0">
					<nav class="navbar">
						<span class="navbar-img">
	                    	<img src="assets/images/paptrade-cropped.png" height="50px"> &nbsp;&nbsp; POS & Inventory System
	                    </span>
						
						<ul class="nav navbar-nav navbar-right">
							<li><span>Current User:  <span id="user"><?= $session_user?></span></span></li>
							<?php
							if($session_user_role != 'Cashier'){
								echo '<li><a href="'. base_url() . index_page() . '/users/dashboard">Go to Inventory</a></li>';
							}
							?>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"></i> <span class="caret"></span></a>
								<ul class="dropdown-menu">
									<li><a href="<?= base_url();?><?= index_page();?>/users/logout">Logout</a></li> 
								</ul>
							</li>
						</ul>
					</nav>
				</div>

	            <div class="header">
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

	            	<div class="col-md-6 box">
	            		<h3>Order Details</h3>
	            		<div class="content">
	            			<div id="cart-tbl">
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
												<input type="hidden" name="sales_on_hold_id" id="sales_on_hold_id">
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
													<th class="amount">Price</th>
													<th class="amount">Quantity</th>
													<th class="amount">Sub Total</th>
												</tr>
											</thead>
											<tbody>

											</tbody>
										</table>
										<hr>
										<div class="text-right"> 
											<div>Discount: <span id="r-discount"></span></div>
											<div>Grand Total: <span id="r-total-amount"></span></div>
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
										<td>Discount:</td>
										<td id="summary-discount" class="amount"></td>
									</tr>
									<tr>
										<td>Grand Total:</td>
										<td id="summary-total" class="amount"></td>
									</tr>
									<tr>
										<td>Payment:</td>
										<td id="summary-payment" class="amount"></td>
									</tr>
									<tr>
										<td>Change:</td>
										<td id="summary-change" class="amount"></td>
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

			<div class="modal" tabindex="-2" role="dialog" id="customer-name-modal">
				<div class="modal-dialog modal-sm">
					<div class="modal-content">
						<div class="modal-body">
							<div class="col-md-12">
								<div class="form-group">
									<input type="text" class="form-control" name="customer_name" placeholder="Enter Customer Name" id="customer_name" autocomplete="off" max="500000" maxlength="50">
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

			<div class="modal" tabindex="-3" role="dialog" id="pending-sales-modal">
				<div class="modal-dialog modal-md">
					<div class="modal-content">
						<div class="modal-body">
							<div id="pending-sales-tbl" style="min-height: 310px; max-height: 185px;">
		            			<table id="pending-sales" class="table table-bordered table-striped table-hover" style="width:100%">
									<thead>
										<tr>
											<td width="50%">Customer Name</td>
											<td width="15%">Grand Total</td>
											<td width="15%">Cashier</td>
											<td width="15%">Date</td>
											<!--th width="5%"> </th-->
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
		</div>

		<script type="text/javascript" src="assets/pos/jquery/jquery-3.2.0.js"></script>
		<script type="text/javascript" src="assets/pos/jquery-ui/jquery-ui-1.12.1.js"></script>
		<script type="text/javascript" src="assets/pos/bootstrap/js/bootstrap-3.3.7.min.js"></script>
		<script type="text/javascript" src="assets/pos/datatable/js/jquery.dataTables-1.10.12.min.js"></script>
		<script type="text/javascript" src="assets/pos/datatable/dataTables.bootstrap.min.js"></script>
		<script type="text/javascript" src="assets/pos/datatable/dataTables.responsive.js"></script>
		<script type="text/javascript" src="assets/pos/jquery-pos.js"></script>
		<script type="text/javascript" src="assets/pos/print.js"></script>
		<script type="text/javascript" src="assets/pos/pos.js"></script>

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
		</script>
	</body>
</html>