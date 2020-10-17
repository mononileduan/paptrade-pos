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
											<div div class="col-sm-12 col-md-12" id="content-table-container_">
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
				                	}
				            	},
					            {
					                extend: 'pdfHtml5',
					                exportOptions: {
					                    columns: [ 1, 2, 3, 4, 5 ]
					                }
					            },
					            {
					                extend: 'print',
					                exportOptions: {
					                    columns: [ 1, 2, 3, 4, 5 ]
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

					var filter = '';
					if(branch != ''){
						filter = "?branchId=" + branch;
					}
					if(refno != ''){
						if(filter == ''){
							filter += '?';
						}else{
							filter += '&';
						}
						filter += "refno=" + refno;
					}
					if(tranDtFrom != ''){
						if(filter == ''){
							filter += '?';
						}else{
							filter += '&';
						}
						filter += "tranDtFrom=" + tranDtFrom;
					}
					if(tranDtTo != ''){
						if(filter == ''){
							filter += '?';
						}else{
							filter += '&';
						}
						filter += "tranDtTo=" + tranDtTo;
					}
					if(tranAmt != ''){
						if(filter == ''){
							filter += '?';
						}else{
							filter += '&';
						}
						filter += "tranAmt=" + tranAmt;
					}
					if(cashier != ''){
						if(filter == ''){
							filter += '?';
						}else{
							filter += '&';
						}
						filter += "cashier=" + cashier;
					}

					datatable.ajax.url( '<?= site_url('sales/list'); ?>'+ filter ).load();
			       	datatable.ajax.reload();
				});
			});
		</script>
	</body>
</html>