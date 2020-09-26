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
														<th>ID</th>
														<th width="10%">Ref. No.</th>
														<th width="15%">Request Date</th>
														<th width="25%">Item</th>
														<th width="5%">Quantity</th>
														<th width="15%">Branch</th>
														<th width="15%">Requested By</th>
														<th width="10%">Status</th>
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
				var id = "<?php if(isset($id)){ echo $id; } else {echo '';} ?>";
				var ref_no = "<?php if(isset($ref_no)){ echo $ref_no; } else {echo '';} ?>";
				var datatable = $('#view-data-table').DataTable({
						"ajax": {
							url : "<?= site_url('supply_requests/warehouse_list'); ?>",
							data: {'id' : id, 'ref_no' : ref_no},
						    type : 'GET'
						},
						"order": [[ 1, "desc" ]],
						"columnDefs": [
							{className: "dt-right", "targets": [4] },
        					{render: $.fn.dataTable.render.number( ',', '.', 0, '' ), "targets": [4] },
							{"targets": -1, "data": null, "orderable": false, "defaultContent": 
								"<a class=\'action-view\' data-mode=\'modal\' title=\'View\'><i class=\'glyphicon glyphicon-eye-open\'></i></a>"},
							{"targets": [ 0 ], "visible": false, "searchable": false},
							{"targets": [ 1 ], "visible": false, "searchable": true}
						],
				        "drawCallback": function ( settings ) {
				            var api = this.api();
				            var rows = api.rows( {page:'current'} ).nodes();
				            var last=null;
				 
				            api.column(1, {page:'current'} ).data().each( function ( group, i ) {
				                if ( last !== group ) {
				                    $(rows).eq( i ).before(
				                        '<tr class="group"><td colspan="7">'+group+'</td></tr>'
				                    );
				                    last = group;
				                }
				            } );
				        },
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
    
    			// Order by the grouping column
			    $('#view-data-table tbody').on( 'dblclick', 'tr.group', function () {
			        var currentOrder = datatable.order()[0];
			        if ( currentOrder[0] === 1 && currentOrder[1] === 'asc' ) {
			            datatable.order( [ 1, 'desc' ] ).draw();
			        }
			        else {
			            datatable.order( [ 1, 'asc' ] ).draw();
			        }
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

	    		$('#view-data-table tbody').on( 'click', 'a.action-view', function (id) {
					var data = $("#view-data-table").DataTable().row( $(this).parents('tr') ).data();
			       	var id = data[0];
			       	var status = data[7];
			       	var isWarehouse = <?= ($this->session->userdata('user_role') == $this->config->item('USER_ROLE_ASSOC')['WHOUSE_USER'][0]) ? 'true' : 'false' ?>;
					var params = "id=" + id + "&ref_no=" + ref_no;

			       	if(status == 'NEW' && isWarehouse){
			       		window.location.replace('<?= site_url('supply_requests/approve?') ?>' + params);
			       	}else{
			       		window.location.replace('<?= site_url('supply_requests/view?return=warehouse&') ?>' + params);
			       	}
			    } );
			});
		</script>
	</body>
</html>