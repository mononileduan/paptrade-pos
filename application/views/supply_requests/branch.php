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
											<div class="row">
												<div class="col-md-12">
													<a href="<?= site_url('supply_requests/add') ?>" class="btn btn-primary btn-sm"><i class='glyphicon glyphicon-plus'></i> New Request</a>
													<div class="row-pad"></div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-12">
													<table id="view-data-table" class="table table-bordered table-striped table-hover" style="width:100%">
														<thead>
															<tr>
																<td>ID</td>
																<td width="15%">Request Date</td>
																<td width="20%">Item</td>
																<td width="10%">Quantity</td>
																<td width="15%">Branch</td>
																<td width="15%">Requested By</td>
																<td width="15%">Status</td>
																<td width="10%">Action</td>
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
		
		<script type="text/javascript" src="assets/js/page.height.setter.js"></script>

		<script type="text/javascript">
			$(document).ready(function() {
				var datatable = $('#view-data-table').DataTable({
						"ajax": {
						   url : "<?= site_url('supply_requests/branch_list'); ?>",
						    type : 'GET'
						},
						"order": [[ 1, "desc" ]],
						"columnDefs": [
							{className: "dt-right", "targets": [3] },
        					{render: $.fn.dataTable.render.number( ',', '.', 0, '' ), "targets": [2] },
							{"targets": -1, "data": null, "orderable": false, "defaultContent": 
							"<a class=\'action-view\' data-mode=\'modal\' title=\'View\'><i class=\'glyphicon glyphicon-eye-open\'></i></a>&nbsp; " +
							"<a class=\'action-delete\' data-mode=\'modal\' title=\'Delete\'><i class=\'glyphicon glyphicon-trash\'></i></a>"},
							{"targets": [ 0 ], "visible": false, "searchable": false}
						],
						dom: 'lBftipr',
						buttons: [
								{
					                extend: 'copyHtml5',
					                exportOptions: {
					                    columns: [ 1, 2, 3, 4, 5, 6 ]
					                }
					            },
								{
					                extend: 'excelHtml5',
					                exportOptions: {
					                    columns: [ 1, 2, 3, 4, 5, 6 ]
				                	}
				            	},
					            {
					                extend: 'pdfHtml5',
					                exportOptions: {
					                    columns: [ 1, 2, 3, 4, 5, 6 ]
					                }
					            },
					            {
					                extend: 'print',
					                exportOptions: {
					                    columns: [ 1, 2, 3, 4, 5, 6 ]
					                }
					            }]
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

			       	var isBranch = <?= ($this->session->userdata('user_role') == $this->config->item('USER_ROLE_ASSOC')['BRANCH_USER'][0]) ? 'true' : 'false' ?>;

			       	if(status == 'APPROVED' && isBranch){
			       		window.location.replace('<?= site_url('supply_requests/receive?id=') ?>' + id);
			       	}else{
			       		window.location.replace('<?= site_url('supply_requests/view?return=branch&id=') ?>' + id);
			       	}
			    } );

	    		$('#view-data-table tbody').on( 'click', 'a.action-delete', function (id) {
					var data = $("#view-data-table").DataTable().row( $(this).parents('tr') ).data();
			       	var id = data[0];
			       	var dscp = data[1];
			       	var status = data[6];
			       	if(status != 'NEW'){
						$("#error_modal .modal-content .modal-body p.text-center").text('You cannot delete this request.');
					    $("#error_modal").modal('show');
			       	}else{
			       		$("#delete_modal").find('input[name="id"]').val(id);
						$("#delete_modal").find('p.dscp').text(dscp);
				    	$("#delete_modal").modal('show');
			       	}
			    } );

			    $("#delete_modal_form").submit(function(e) {
					e.preventDefault();
					var id = $("#delete_modal").find('input[name="id"]').val();

					if(id == ''){
						$("#error_modal .modal-content .modal-body p.text-center").text('Could not proceed with delete. ID not found.');
					    $("#error_modal").modal('show');
					}
					
					if(id!=''){
						var data = {};
						data['submit_delete'] = true;
						data['id'] = id;

						$.ajax({
							type : 'POST',
							data : data,
							url : '<?= site_url('supply_requests/branch') ?>',
							success : function(data) { 
								if(data == 'OK'){
			    					$("#delete_modal").modal('toggle');
									$("#success_modal .modal-content .modal-body p.text-center").text("Supply Request successfully deleted.");
									$("#success_modal").attr('data-trigger', 'not-new');
									$("#success_modal").modal('show');
								}else{
									$("#error_modal .modal-content .modal-body p.text-center").text(data);
									$("#error_modal").modal('show');
								}
							}
						})
						return;
					}
				})

				$('#success_modal').on('hide.bs.modal', function () {
			    	if($('#success_modal').data('trigger') =='not-new'){
						window.location.replace('<?= site_url('supply_requests/branch') ?>');
			    	}
				});

			});
		</script>
	</body>
</html>