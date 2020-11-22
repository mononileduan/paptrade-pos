<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Centralized Sales & Inventory System</title>
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
			            <h2 class="page-header">Inventory Archive</h2>
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
														<th width="30%">Item</th>
														<th width="15%">Branch</th>
														<th width="15%">Category</th>
														<th width="15%">Unit Price (&#x20B1;)</th>
														<th width="10%">Quantity</th>
														<th width="10%">Critical Quantity</th>
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

		<div class="modal" tabindex="-1" role="dialog" id="hist-modal">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Inventory History</h5>
					</div>
					<div class="modal-body">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
									<span class="panel-title"><span class="glyphicon glyphicon-list"></span>&nbsp; List</span>
								</h4>
							</div>
							<div class="panel-body">
								<div id="hist-container" style="min-height: 300px;">
			            			<table id="hist-view-data-table" class="table table-bordered table-striped table-hover" style="width:100%">
										<thead>
											<tr>
												<th></th>
												<th width="16%">Updated Date</th>
												<th width="27%">Item</th>
												<th width="8%">Quantity</th>
												<th width="9%">Running Quantity</th>
												<th width="5%">Mvt</th>
												<th width="15%">Updated By</th>
												<th width="20%">Remarks</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
								</div>
							</div>
						</div>
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
						   url : "<?= site_url('branch_inventories/list'); ?>",
						   type : 'GET',
						   data : {status : 'ARCHIVED'}
						},
						"order": [[ 1, "asc" ]],
						"columnDefs": [
							{className: "dt-right", "targets": [-2, -3, -4] },
							{render: $.fn.dataTable.render.number( ',', '.', 2, '' ), "targets": [-4] },
							{render: $.fn.dataTable.render.number( ',', '.', 0, '' ), "targets": [-2, -3] },
							{"targets": -1, "data": null, "orderable": false, "defaultContent": 
								"<a class=\'action-hist\' data-mode=\'modal\' title=\'History\'><i class=\'glyphicon glyphicon-calendar\'></i></a>&nbsp;"},
							{"targets": [ 0 ], "visible": false, "searchable": false}
						],
				        "createdRow": function( row, data, dataIndex){
			                if( parseInt(data[5]) <= parseInt(data[6]) ){
			                   // $(row).addClass('critical');
			                   //$(row).attr('title', "This item's stock count is in critical level.");
			                }
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
				                	messageTop: 'Branch Inventory',
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
											text: "Centralized Sales & Inventory System",
											fontSize: 14,
					                        margin: [ 0, 0, 0, 5 ],
											alignment: 'center'
										});

										doc.content.splice( 2, 0, {
											text: "Branch Inventory",
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
											doc.content[4].table.body[i][4].alignment = 'right';
											doc.content[4].table.body[i][5].alignment = 'right';
											doc.content[4].table.body[i][5].margin = [0, 0, 10, 0];
										};
										doc.content[4].table.widths = [ '40%', '20%', '10%', '10%', '10%', '10%' ];

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
					 						.replaceWith( '<h3>Centralized Sales & Inventory System</h3>' );

					 					$(win.document.body).find( 'h3' )
					 						.css( 'text-align', 'center' )
					 						.css( 'margin-top', '10px' );

					 					
					 					$( "<h3>Branch Inventory</h3>" ).insertAfter( $(win.document.body).find( 'h3' ) )
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

				var hist_tbl = $('#hist-view-data-table').DataTable({
					"ordering": false,
			        "columnDefs": [
						{className: "dt-right", "targets": [-5, -4] },
						{render: $.fn.dataTable.render.number( ',', '.', 0, '' ), "targets": [-5, -4] },
						{"targets": [ 0 ], "visible": false, "searchable": false}
					]
			    });


			    $('#view-data-table tbody').on( 'click', 'a.action-hist', function (id) {
			    	var data = $("#view-data-table").DataTable().row( $(this).parents('tr') ).data();
			       	var id = data[0];
			       	hist_tbl.ajax.url( '<?= site_url('branch_inventories/hist_list'); ?>?inventory_id='+id ).load();
			       	hist_tbl.ajax.reload();
					$("#hist-modal").modal('show');
			    } );


				$('#hist-modal').on('shown.bs.modal', function () {
			       	hist_tbl.columns.adjust();
				});


			});
		</script>
	</body>
</html>