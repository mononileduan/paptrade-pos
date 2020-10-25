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
	 	<link rel="stylesheet" type="text/css" href="assets/datepicker/1.7.1/css/bootstrap-datepicker3.css"/>
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
			            <h2 class="page-header">Sales</h2>
			            <div class="margin-left-20px">
				            <div class="row">
								<div class="col-md-9">
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<span class="panel-title"><span class="glyphicon glyphicon-list"></span>&nbsp; List</span>
											</h4>
										</div>
										<div class="panel-body">
											<div class="col-md-12">
												<div class="row">
													<div class="col-sm-12 col-md-12" id="content-table-container_">
														<table id="view-data-table" class="table table-bordered table-striped table-hover" style="width:100%">
															<thead>
																<tr>
																	<th>ID</th>
																	<th width="20%">Branch</th>
																	<th width="20%">Transaction Date</th>
																	<th width="15%">Reference No.</th>
																	<th width="15%">Transaction Amount</th>
																	<th width="25%">Cashier</th>
																	<th width="5%">Action</th>
																</tr>
															</thead>
															<tbody>
															</tbody>
														</table>
													</div>
												</div>
												<div class="row">
													<div class="col-md-6 text-right">
														<label>Total Sales:</label>
													</div>
													<div class="col-md-6">
														<span id="total_sales" class="text-right ccy"><?= $total_sales ?></span>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
						        <div class="col-md-3">
						        	<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<span class="panel-title"><span class="glyphicon glyphicon-search"></span>&nbsp; Search</span>
											</h4>
										</div>
										<div class="panel-body">
											<form id="search-sales-form" autocomplete="off">
												<div class="form-group">
													<label for='branch'>Branch</label>
													<select id="branch" name="branch" class="form-control" <?= $this->config->item('USER_ROLE_ASSOC')[$this->session->userdata('user_role')][0] == 'BRANCH_USER' ? 'disabled' : '' ?> >
														<option value=""></option>
														<?php foreach($branches->result_array() as $r) {
															if($this->config->item('USER_ROLE_ASSOC')[$this->session->userdata('user_role')][0] == 'BRANCH_USER' 
																&& $this->session->userdata('branch_id') === $r['ID']){
																echo '<option value="'.$r['ID'].'" selected="selected">'.$r['BRANCH_NAME'].'</option>';
															}else{
																echo '<option value="'.$r['ID'].'">'.$r['BRANCH_NAME'].'</option>';
															}
														} ?>
													</select>
												</div>
												<div class="form-group">
													<label for='refno'>Reference Number</label>
													<input type="text" id="refno" name="refno" class="form-control">
												</div>
												<div class="form-group">
													<label for='datetimepickerfrom'>Transaction Date From</label>
													<div class='input-group date' id='datetimepickerfrom'>
									                    <input type='text' class="form-control" name="datetimepickerfrom"/>
									                    <span class="input-group-addon">
									                        <span class="glyphicon glyphicon-calendar"></span>
									                    </span>
									                </div>
												</div>
												<div class="form-group">
													<label for='datetimepickerto'>Transaction Date To</label>
													<div class='input-group date' id='datetimepickerto'>
									                    <input type='text' class="form-control" name="datetimepickerto" />
									                    <span class="input-group-addon">
									                        <span class="glyphicon glyphicon-calendar"></span>
									                    </span>
									                </div>
												</div>
												<div class="form-group">
													<label for='tranAmt'>Transaction Amount</label>
													<input type="text" id="tranAmt" name="tranAmt" class="form-control">
												</div>
												<div class="form-group">
													<label for='cashier'>Cashier</label>
													<select id="cashier" name="cashier" class="form-control">
														<option value=""></option>
														<?php foreach($cashiers->result_array() as $r) {
															echo '<option value="'.$r['USERNAME'].'">'.$r['FIRST_NAME'].' '.$r['LAST_NAME'].' - '.$r['BRANCH_NAME'].'</option>';
														} ?>
													</select>
												</div>
												<input type="submit" name="search" class="btn btn-sm btn-primary" value="Search">
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

		<script type="text/javascript" src="assets/datatables/datatables.min.js"></script>
		<script type="text/javascript" src="assets/bootstrap/3.4.1/js/bootstrap.min.js"></script>


		<script type="text/javascript" src="assets/datatables/Buttons-1.6.1/js/dataTables.buttons.min.js"></script>

		<script type="text/javascript" src="assets/datatables/JSZip-3.1.3/js/jszip.min.js"></script>

		<script type="text/javascript" src="assets/datatables/PDFMake-0.1.53/js/pdfmake.min.js"></script>
		<script type="text/javascript" src="assets/datatables/PDFMake-0.1.53/js/vfs_fonts.js"></script>

		<script type="text/javascript" src="assets/datatables/Buttons-1.6.1/js/buttons.html5.min.js"></script>
		<script type="text/javascript" src="assets/datatables/Buttons-1.6.1/js/buttons.print.min.js"></script>

		<script type="text/javascript" src="assets/datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
		
		<script type="text/javascript" src="assets/js/page.height.setter.js"></script>

		<script type="text/javascript">
			$(document).ready(function() {
				var base_url = $("meta[name='base_url']").attr('content');
				var data = {};
				if($('#branch').val() != ''){
					data['branchId'] = $('#branch').val();
				}
				var datatable = $('#view-data-table').DataTable({
						"ajax": {
						   	url : "<?= site_url('sales/list'); ?>",
						    type : 'GET',
						    data: data
						},
						"order": [[ 2, "desc" ]],
						"columnDefs": [
							{className: "dt-right", "targets": [-3] },
							{render: $.fn.dataTable.render.number( ',', '.', 2, '' ), "targets": [-3] },
							{"targets": -1, "data": null, "orderable": false, "defaultContent": 
								"<a class=\'action-view\' data-mode=\'modal\' title=\'View\'><i class=\'glyphicon glyphicon-eye-open\'></i></a>&nbsp; "},
							{"targets": [ 0 ], "visible": false, "searchable": false}
						],
						dom: 'lBftipr',
						buttons: [
								{
					                extend: 'copyHtml5',
					                exportOptions: {
					                    columns: [ 1, 2, 3, 4, 5 ]
					                }
					            },
								{
					                extend: 'excelHtml5',
					                exportOptions: {
					                    columns: [ 1, 2, 3, 4, 5 ]
				                	},
				                	messageTop: 'Sales',
				                	messageBottom: '***Nothing follows***',
				                	customize: function ( xlsx ) {
									    var sheet = xlsx.xl.worksheets['sheet1.xml'];
										
									    
									}
				            	},
					            {
					                extend: 'pdfHtml5',
					                exportOptions: {
					                    columns: [ 1, 2, 3, 4, 5 ]
					                },
					                customize: function ( doc ) {
					                    doc.content.splice( 0, 0, {
					                        margin: [ 0, 0, 0, 5 ],
					                        alignment: 'center',
											width: 100,
					                        image: 'data:image/png;base64,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'
					                    } );

										doc.content.splice( 1, 1, {
											text: "POS & Inventory System",
											fontSize: 14,
					                        margin: [ 0, 0, 0, 5 ],
											alignment: 'center'
										});

										doc.content.splice( 2, 0, {
											text: "Sales",
											fontSize: 14,
					                        margin: [ 0, 0, 0, 10 ],
											alignment: 'center'
										});

										doc.content.splice( 3, 0, [
											{
												text: 'Total Sales:			'+$('#total_sales').text(),
												fontSize: 10,
												margin: [0,0,0,3]
											},
											{
												text: 'No. of Records:	'+$('#view-data-table').DataTable().rows().count(),
												fontSize: 10,
												margin: [0,0,0,3]
											},
											{
												text: 'Exported By:		 <?= $this->session->userdata('fullname') ?>',
												fontSize: 10,
												margin: [0,0,0,3]
											},
											{
												text: 'Exported Date:	 <?= date('m/d/Y H:i:s') ?>',
												fontSize: 10,
												margin: [0,0,0,5]
											}
										]);

										doc.content.splice( 5, 0, {
											text: "***Nothing follows***",
											fontSize: 10,
					                        margin: [ 0, 0, 0, 10 ],
											alignment: 'center'
										});
					                }
					            },
					            {
					                extend: 'print',
					                exportOptions: {
					                    columns: [ 1, 2, 3, 4, 5 ]
					                },
               						/*autoPrint: false,*/
	                                customize: function ( win ) {
					                    $(win.document.body)
					                        .css( 'font-size', '10pt' )
					                        .prepend(
					                            '<img src="'+base_url+'assets/images/paptrade-nav.png" style="display: block; margin-left: auto; margin-right: auto; width:100px" />'
					                        );

					 					$(win.document.body).find( 'h1' )
					 						.replaceWith( '<h3>POS & Inventory System</h3>' );

					 					$(win.document.body).find( 'h3' )
					 						.css( 'text-align', 'center' )
					 						.css( 'margin-top', '10px' );

					 					
					 					$( "<h3>Sales</h3>" ).insertAfter( $(win.document.body).find( 'h3' ) )
					 						.css( 'text-align', 'center' )
					 						.css( 'margin-top', '5px' );

					 					var export_dtls = '<div style="max-width:50%; float:left;">'+
					 						'<label>Total Sales:</label> <span class="text-right ccy">'+$('#total_sales').text()+'</span> <br/>'+
			 								'<label>No. of Records:</label> <span class="text-right ccy">'+$('#view-data-table').DataTable().rows().count()+'</span><br/>'+
				 						'</div>'+
				 						'<div style="margin-left: 60%; text-align:right;">'+
					 						'<label>Exported By:</label> <span class="text-right"><?= $this->session->userdata('fullname') ?></span><br/>'+
					 						'<label>Exported Date:</label> <span class="text-right"><?= date('m/d/Y H:i:s') ?></span>'+
				 						'</div>';
					 					$( export_dtls )
					 						.insertBefore($(win.document.body).find( 'table' ));

					                    $(win.document.body).find( 'table' )
					                        .addClass( 'compact' )
					                        .css( 'font-size', 'inherit' );

					 					$( '<div style="text-align:center;"><label>***Nothing follows***</label></div>' )
					 						.insertAfter($(win.document.body).find( 'table' ));

					                }
					            }]
				});

				 $('#view-data-table tbody').on( 'click', 'a.action-view', function (id) {
					var data = $("#view-data-table").DataTable().row( $(this).parents('tr') ).data();
			       	var id = data[0];
			        window.location.replace('<?= site_url('sales/details?id=') ?>' + id);
			    } );

			    
		        $('#datetimepickerfrom').datepicker({
		            format: "yyyy-mm-dd",
		            autoclose: true,
		            todayHighlight: true
		        });

		        $('#datetimepickerto').datepicker({
		            format: "yyyy-mm-dd",
		            autoclose: true,
		            todayHighlight: true
		        });


				$("#search-sales-form").submit(function(e) {
					e.preventDefault();
					var branch = $('#branch').val();
					var refno = $('#refno').val();
					var tranDtFrom = $('input[name="datetimepickerfrom"]').val();
					var tranDtTo = $('input[name="datetimepickerto"]').val();
					var tranAmt = $('#tranAmt').val();
					var cashier = $('#cashier').val();

					var data = {};
					var filter = '';
					if(branch != ''){
						filter = "?branchId=" + branch;
						data['branchId'] = branch;
					}
					if(refno != ''){
						if(filter == ''){
							filter += '?';
						}else{
							filter += '&';
						}
						filter += "refno=" + refno;
						data['refno'] = refno;
					}
					if(tranDtFrom != ''){
						if(filter == ''){
							filter += '?';
						}else{
							filter += '&';
						}
						filter += "tranDtFrom=" + tranDtFrom;
						data['tranDtFrom'] = tranDtFrom;
					}
					if(tranDtTo != ''){
						if(filter == ''){
							filter += '?';
						}else{
							filter += '&';
						}
						filter += "tranDtTo=" + tranDtTo;
						data['tranDtTo'] = tranDtTo;
					}
					if(tranAmt != ''){
						if(filter == ''){
							filter += '?';
						}else{
							filter += '&';
						}
						filter += "tranAmt=" + tranAmt;
						data['tranAmt'] = tranAmt;
					}
					if(cashier != ''){
						if(filter == ''){
							filter += '?';
						}else{
							filter += '&';
						}
						filter += "cashier=" + cashier;
						data['cashier'] = cashier;
					}

					datatable.ajax.url( '<?= site_url('sales/list'); ?>'+ filter ).load();
			       	datatable.ajax.reload();

			       	$.ajax({
						type : 'GET',
						data : data,
						url : '<?= site_url('sales/list_totalamt'); ?>',
						success : function(data) { 	
							var json = JSON.parse(data);
							$('#total_sales').text(formatCurrencyVal(json['GRAND_TOTAL']));
						}
					})
				});


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