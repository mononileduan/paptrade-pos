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
							    <div class="col-md-12" id="content-container">
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
																<th>ID</th>
																<th>Ref. No.</th>
																<th width="15%">Request Date</th>
																<th width="25%">Item</th>
																<th width="10%">Quantity</th>
																<th width="15%">Branch</th>
																<th width="15%">Requested By</th>
																<th width="15%">Status</th>
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
		<script type="text/javascript" src="assets/js/getExportLogoImage.js"></script>

		<script type="text/javascript">
			$(document).ready(function() {
				var base_url = $("meta[name='base_url']").attr('content');
				var datatable = $('#view-data-table').DataTable({
						"ajax": {
						   url : "<?= site_url('supply_requests/branch_list'); ?>",
						    type : 'GET'
						},
						"order": [[ 1, "desc" ]],
						"columnDefs": [
							{className: "dt-right", "targets": [4] },
        					{render: $.fn.dataTable.render.number( ',', '.', 0, '' ), "targets": [4] },
							{"targets": -1, "data": null, "orderable": false, "defaultContent": 
							"<a class=\'action-view\' data-mode=\'modal\' title=\'View\'><i class=\'glyphicon glyphicon-eye-open\'></i></a>&nbsp; " +
							"<a class=\'action-delete\' data-mode=\'modal\' title=\'Delete\'><i class=\'glyphicon glyphicon-trash\'></i></a>"},
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
				                	},
				                	messageTop: 'Supply Request: Branch',
				                	messageBottom: '***Nothing follows***',
				                	customize: function ( xlsx ) {
									    var sheet = xlsx.xl.worksheets['sheet1.xml'];
										
									    
									}
				            	},
					            {
					                extend: 'pdfHtml5',
					                exportOptions: {
					                    columns: [ 1, 2, 3, 4, 5, 6 ]
					                },
                					orientation: 'landscape',
					                customize: function ( doc ) {
					                    doc.content.splice( 0, 0, {
					                        margin: [ 0, 0, 0, 5 ],
					                        alignment: 'center',
											width: 100,
					                        image: getExportLogoImage()
					                    } );

										doc.content.splice( 1, 1, {
											text: "POS & Inventory System",
											fontSize: 14,
					                        margin: [ 0, 0, 0, 5 ],
											alignment: 'center'
										});

										doc.content.splice( 2, 0, {
											text: "Supply Request: Branch",
											fontSize: 14,
					                        margin: [ 0, 0, 0, 10 ],
											alignment: 'center'
										});

										doc.content.splice( 3, 0, [
											{
												text: '',
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

										var rowCount = doc.content[4].table.body.length;
										for (i = 0; i < rowCount; i++) {
											doc.content[4].table.body[i][0].margin = [10, 0, 0, 0];
											doc.content[4].table.body[i][3].alignment = 'right';
											doc.content[4].table.body[i][5].margin = [0, 0, 10, 0];
										};
										doc.content[4].table.widths = [ '15%', '15%', '20%', '10%', '20%', '20%' ];

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
					                    columns: [ 1, 2, 3, 4, 5, 6 ]
					                },
               						/*autoPrint: false,*/
	                                customize: function ( win ) {
	                                	var css = '@page { size: landscape; }',
						                    head = win.document.head || win.document.getElementsByTagName('head')[0],
						                    style = win.document.createElement('style');
						 
						                style.type = 'text/css';
						                style.media = 'print';
						                if (style.styleSheet){
						                  style.styleSheet.cssText = css;
						                }else{
						                  style.appendChild(win.document.createTextNode(css));
						                }
						                head.appendChild(style);


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

					 					
					 					$( "<h3>Supply Request: Branch</h3>" ).insertAfter( $(win.document.body).find( 'h3' ) )
					 						.css( 'text-align', 'center' )
					 						.css( 'margin-top', '5px' );

					 					var export_dtls = '<div style="max-width:50%; float:left;">'+
					 						'<label></label> <span class="text-right ccy"></span> <br/>'+
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
			       	var status = data[7];
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