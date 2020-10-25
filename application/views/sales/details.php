<!DOCTYPE html>
<html lang="en">
	<head>
		<title>POS & Inventory System</title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="base_url" content="<?= base_url() ?>">
		<meta name="index_page" content="<?= index_page() ?>">
		<base href="<?= site_url() ?>">
		<link rel="shortcut icon" type="image/x-icon" href="assets/images/paptrade-icon.png" />

	 	<link rel="stylesheet" type="text/css" href="assets/bootstrap/3.4.1/css/bootstrap.css">
	 	<link rel="stylesheet" type="text/css" href="assets/datatables/datatables.min.css"/>
	    <link rel="stylesheet" type="text/css" href="assets/materialicons/material-icons.css">
	 	<link rel="stylesheet" type="text/css" href="assets/css/styles.css">
	 	<link rel="stylesheet" type="text/css" href="assets/pos/pos.css">
		
    	<script src="assets/jquery/3.4.1/jquery.min.js"></script>
	</head>

	<body>

		<div>

			<?php $this->load->view('components/navbar'); ?>
			
			<div class="container-fluid with-color-accent">

				<div class="row">
			        
			        <?php $this->load->view('components/menu'); ?>

			        <div class="col-sm-10 col-md-10" id="page-content">
			            <h2 class="page-header">Sales</h2>
			            <div class="margin-left-20px">
				            <div class="row">
								<div class="col-md-8">
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<span class="panel-title"><span class="glyphicon glyphicon-list"></span>&nbsp; Transaction Details</span>
											</h4>
										</div>
										<div class="panel-body">
											<div class="row">
											    <div class="col-sm-12 col-md-12">
													<div class="row">
														<div class="col-sm-4 col-md-4 text-right">
															<div><label>Reference No.:</label></div>
															<div><label>Date:</label></div>
															<div><label>Cashier:</label></div>
															<div><label>Branch:</label></div>
														</div>
														<div class="col-sm-8 col-md-8 text-left">
															<div class="dataview-val"><span><?= $hdr['REF_NO']; ?></span></div>
															<div class="dataview-val"><span><?= $hdr['CREATED_DT']; ?></span></div>
															<div class="dataview-val"><span><?= $hdr['CREATED_BY']; ?></span></div>
															<div class="dataview-val"><?= $hdr['BRANCH']; ?></div>
														</div>
													</div>

													<div class="row-pad"></div>

											    	<div class="row">
											    		<div class="col-md-12">
											    			<div id="sales-dtls-tbl-container">
													    		<table id="view-data-table" class="table table-bordered table-striped table-hover" style="width:100%">
																	<thead>
																		<tr>
																			<th width="50%">Item</th>
																			<th width="20%" class="text-right">Unit Price</th>
																			<th width="10%" class="text-right">Quantity</th>
																			<th width="20%" class="text-right">Sub-Total</th>
																		</tr>
																	</thead>
																	<tbody>
																		<?php
																			foreach($dtl->result_array() as $r){
																				echo '<tr>';
																				echo '	<td>'.$r['ITEM'].'</td>';
																				echo '	<td class="text-right"><span class="ccy">'.$r['UNIT_PRICE'].'</span></td>';
																				echo '	<td class="text-right numeric">'.$r['QUANTITY'].'</td>';
																				echo '	<td class="text-right"><span class="ccy">'.$r['SUB_TOTAL'].'</span></td>';
																				echo '</tr>';
																			}
																		?>
																	</tbody>
																</table>
															</div>
														</div>
											    	</div>
											    	<div class="row">
														<div class="col-sm-8 col-md-9 text-right">
															<div><label>Grand Total:</label></div>
															<div><label>Payment:</label></div>
															<div><label>Change:</label></div>
														</div>
														<div class="col-sm-4 col-md-2 text-right">
															<div class="dataview-val"><span class="text-right ccy"><?= $hdr['GRAND_TOTAL']; ?></span></div>
															<div class="dataview-val"><span class="text-right ccy"><?= $hdr['PAYMENT']; ?></span></div>
															<div class="dataview-val"><span class="text-right ccy"><?= $hdr['PAYMENT'] - $hdr['GRAND_TOTAL']; ?></span></div> 
														</div>
														<div class="col-md-1"></div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-offset-2"></div>
							</div>
							<input type="button" class="btn btn-sm btn-secondary back-btn" value="Back">
							<input type="button" class="btn btn-sm btn-primary" value="View Receipt" id="btn-view-receipt">
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
									<img class="logo" src="assets/images/paptrade-receipt.png">
									<div>
										<small><?= $hdr['BRANCH_ADDRESS'] ?></small>
									</div>
									<div>
										<small><?= $hdr['BRANCH_CONTACT'] ?></small>
									</div>
									<br>
									<div class="clearfix"></div>
									<h4>Receipt</h4>
								</div>
								<div class="r-body">
									<div class="row dtl-header">
										<div class="col-md-4 text-right">
											<div>Reference No.:</div>
											<div>Date: <span></span></div>
											<div>Cashier:</div>
											<div>Branch:</div>
										</div>
										<div class="col-md-8 text-left">
											<div id="r-id"><?= $hdr['REF_NO']; ?></div>
											<div id="r-date"><?= $hdr['CREATED_DT']; ?></div>
											<div id="r-cashier"><?= $hdr['CREATED_BY']; ?></div>
											<div id="r-branch"><?= $hdr['BRANCH']; ?></div>
										</div>
									</div>
									<div class="clearfix"></div>
									<table class="table table-striped" id="r-items-table">
										<thead>
											<tr> 
												<th>Item</th>
												<th class="text-right">Unit Price</th>
												<th class="text-right">Qty</th>
												<th class="text-right">Sub Total</th>
											</tr>
										</thead>
										<tbody>
											<?php
												foreach($dtl->result_array() as $r){
													echo '<tr>';
													echo '	<td>'.$r['ITEM'].'</td>';
													echo '	<td class="text-right"><span class="ccy">'.$r['UNIT_PRICE'].'</span></td>';
													echo '	<td class="text-right numeric">'.$r['QUANTITY'].'</td>';
													echo '	<td class="text-right"><span class="ccy">'.$r['SUB_TOTAL'].'</span></td>';
													echo '</tr>';
												}
											?>
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
											<div id="r-total-amount" class="ccy"><?= $hdr['GRAND_TOTAL']; ?></div>
											<div id="r-payment" class="ccy"><?= $hdr['PAYMENT']; ?></div>
											<div id="r-change" class="ccy"><?= $hdr['PAYMENT'] - $hdr['GRAND_TOTAL']; ?></div>
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
									<td id="summary-total" class="text-right ccy"><?= $hdr['GRAND_TOTAL']; ?></td>
								</tr>
								<tr>
									<td>Payment:</td>
									<td id="summary-payment" class="text-right ccy"><?= $hdr['PAYMENT']; ?></td>
								</tr>
								<tr>
									<td>Change:</td>
									<td id="summary-change" class="text-right ccy"><?= $hdr['PAYMENT'] - $hdr['GRAND_TOTAL']; ?></td>
								</tr>
							</table>
							<button class="btn btn-primary btn-sm" id="print">Print Receipt</button>
						</div>

						<div class="clearfix"></div>

					</div>
					<div class="modal-footer"> 
						<button type="button" class="btn btn-secondary" data-dismiss="modal" id="payment-modal-close">Close</button>
					</div>

				</div>

			</div>
		</div>

		<script type="text/javascript" src="assets/datatables/datatables.min.js"></script>
		<script type="text/javascript" src="assets/bootstrap/3.4.1/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="assets/pos/jQuery.print.js"></script>

		<script type="text/javascript" src="assets/js/page.height.setter.js"></script>

		<script type="text/javascript">
			$(document).ready(function() {
				$("#btn-view-receipt").click(function(){
					$("#payment-modal").modal('toggle');
				});


				$("#print").click(function(){
					var base_url = $("meta[name='base_url']").attr('content');
					$("#receipt").print({
				        	globalStyles: true,
				        	mediaPrint: false,
				        	stylesheet: base_url + '/assets/pos/receipt.css',
				        	noPrintSelector: ".no-print",
				        	iframe: true,
				        	append: null,
				        	prepend: null,
				        	manuallyCopyFormValues: true,
				        	deferred: $.Deferred(),
				        	timeout: 500,
				        	title: 'Receipt',
				        	doctype: '<!doctype html>'
					});
				})

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

				function thousands(str){
				    return str.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
				}

				$('.back-btn').on('click', function () {
			        window.location.replace('<?= site_url('sales') ?>');
			    } );


				$('.ccy').each(function(){
					formatCurrency($(this));
				});

				$('.numeric').each(function(){
					thousands($(this));
				});
			});
		</script>
	</body>
</html>