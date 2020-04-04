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
	    <link rel="stylesheet" type="text/css" href="assets/datatables/DataTables-1.10.20/css/jquery.dataTables.css">
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
			            <h2 class="page-header">Inventory History</h2>

					    <div class="row">
						    <div class="col-md-12">
								<table id="view-data-table" class="table table-bordered table-striped table-hover" style="width:100%">
									<thead>
										<tr>
											<td></td>
											<td width="30%">Item</td>
											<td width="10%">Quantity</td>
											<td width="10%">Running Quantity</td>
											<td width="5%">Movement</td>
											<td width="15%">Updated By</td>
											<td width="15%">Updated Date</td>
											<td width="15%">Remarks</td>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-12">
								<input type="button" class="btn btn-secondary back-btn" value="Back">
							</div>
						</div>
			            
			        </div>
	    		</div>
	    	</div>
		</div>

		<?php $this->load->view('components/modals'); ?>

		<script type="text/javascript" src="assets/datatables/datatables.min.js"></script>
		<script type="text/javascript" src="assets/bootstrap/3.4.1/js/bootstrap.min.js"></script>

		<script type="text/javascript">
			$(document).ready(function() {
				var datatable = $('#view-data-table').DataTable({
						"ajax": {
						   url : "<?= site_url('branch_inventories/hist_list'); ?>",
						   type : 'GET',
						   data : {"inventory_id" : '<?= $inventory_id; ?>' }
						},
						"columnDefs": [
							{className: "dt-right", "targets": [-5, -6] },
							{render: $.fn.dataTable.render.number( ',', '.', 0, '' ), "targets": [-5, -6] },
							{"targets": [ 0 ], "visible": false, "searchable": false}
						]
				});

				$('.back-btn').on('click', function () {
			        window.location.replace('<?= site_url('branch_inventories/index') ?>');
			    } );

			});
		</script>
	</body>
</html>