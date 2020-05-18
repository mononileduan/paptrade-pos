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
			            <h2 class="page-header">Supply Requests</h2>
			            <div class="margin-left-20px">
						    <div class="row">
							    <div class="col-md-12">
							    	<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<span class="panel-title"><span class="glyphicon glyphicon-list"></span>&nbsp; List</span>
											</h4>
										</div>
										<div class="panel-body">
											<table id="view-data-table" class="table table-bordered table-striped table-hover" style="width:100%">
												<thead>
													<tr>
														<td></td>
														<td width="30%">Item</td>
														<td width="5%">Quantity</td>
														<td width="20%">Branch</td>
														<td width="15%">Requested By</td>
														<td width="15%">Request Date</td>
														<td width="10%">Status</td>
														<td width="5%">Action</td>
													</tr>
												</thead>
												<tbody>
												</tbody>
											</table>
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
				var id = "<?php if(isset($id)){ echo $id; } else {echo '';} ?>";
				var datatable = $('#view-data-table').DataTable({
						"ajax": {
							url : "<?= site_url('supply_requests/warehouse_list'); ?>",
							data: {'id' : id},
						    type : 'GET'
						},
						"order": [[ 1, "asc" ]],
						"columnDefs": [
							{className: "dt-right", "targets": [2] },
        					{render: $.fn.dataTable.render.number( ',', '.', 0, '' ), "targets": [2] },
							{"targets": -1, "data": null, "orderable": false, "defaultContent": 
								"<a class=\'action-view\' data-mode=\'modal\' title=\'View\'><i class=\'glyphicon glyphicon-eye-open\'></i></a>"},
							{"targets": [ 0 ], "visible": false, "searchable": false}
						]
				});



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

	    		$('#view-data-table tbody').on( 'click', 'a.action-view', function (id) {
					var data = $("#view-data-table").DataTable().row( $(this).parents('tr') ).data();
			       	var id = data[0];
			       	var status = data[6];
			       	var isWarehouse = <?= ($this->session->userdata('user_role') == $this->config->item('USER_ROLE_ASSOC')['WHOUSE_USER'][0]) ? 'true' : 'false' ?>;

			       	if(status == 'NEW' && isWarehouse){
			       		window.location.replace('<?= site_url('supply_requests/approve?id=') ?>' + id);
			       	}else{
			       		window.location.replace('<?= site_url('supply_requests/view?return=warehouse&id=') ?>' + id);
			       	}
			    } );
			});
		</script>
	</body>
</html>