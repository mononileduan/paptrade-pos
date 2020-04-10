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
			            <h2 class="page-header">Inventory</h2>

			            <div class="row">
							<div class="col-md-12">
								<div class="row">
									<div class="col-md-12">
										<a href="#add_container" class="btn btn-primary btn-sm" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class='glyphicon glyphicon-plus'></i> Add New</a>
									</div>
								</div>

								<div class="row-pad"></div>

								<div class="row collapse <?php if(!empty($error_msg)){echo 'show';} ?> border border-primary rounded" id="add_container" style="padding-top: 10px;">
									<div class="col-md-12">
										<div class="container">
											<form action="" method="post" accept-charset="utf-8" class="form-horizontal">
												<div class="form-group">
													<label class="control-label col-sm-2" for='item_id'>Item</label>
													<div class="col-sm-10">
														<select required="required" name="item_id" id="item_select" class="form-control">
															<option value=""></option>
															<?php foreach($items->result_array() as $r) {
																if(set_value('item_id') === $r['ID']){
																	echo '<option value="'.$r['ID'].'"data-critqty="'.$r['CRITICAL_QTY'].'" selected="selected">'.$r['BRAND'].' '.$r['DSCP'].'</option>';
																}else{
																	echo '<option value="'.$r['ID'].'"data-critqty="'.$r['CRITICAL_QTY'].'">'.$r['BRAND'].' '.$r['DSCP'].'</option>';
																}
															} ?>
														</select>
														<?php echo form_error('item_id', '<small class="has-error"><p class="help-block">','</p></small>'); ?>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-sm-2" for='init_qty'>Initial Quantity</label>
													<div class="col-sm-10">
														<input required="required" type="text" value="<?php echo set_value('init_qty'); ?>" name="init_qty" class="form-control">
														<?php echo form_error('init_qty', '<small class="has-error"><p class="help-block">','</p></small>'); ?>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-sm-2" for='crit_qty'>Critical Quantity</label>
													<div class="col-sm-10">
														<input required="required" type="text" value="<?php echo set_value('crit_qty'); ?>" name="crit_qty" class="form-control">
														<?php echo form_error('crit_qty', '<small class="has-error"><p class="help-block">','</p></small>'); ?>
													</div>
												</div>
												
												<div class="form-group">
													<div class="col-sm-offset-2 col-sm-10">
												    	<input type="submit" name="submit_new_inventory" class="btn btn-sm btn-success" value="Submit">
												    </div>
													
												</div>
											</form>
										</div>
									</div>
								</div>

							</div>
						</div>

						<div class="row-pad"></div>

						<div class="row-pad"></div>

					    <div class="row">
						    <div class="col-md-12">
								<table id="view-data-table" class="table table-bordered table-striped table-hover" style="width:100%">
									<thead>
										<tr>
											<td></td>
											<td width="35%">Item</td>
											<td width="15%">Category</td>
											<td width="10%">Unit Price</td>
											<td width="10%">Current Quantity</td>
											<td width="10%">Available Quantity</td>
											<td width="10%">Critical Quantity</td>
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

		<?php $this->load->view('components/modals'); ?>

		<script type="text/javascript" src="assets/datatables/datatables.min.js"></script>
		<script type="text/javascript" src="assets/bootstrap/3.4.1/js/bootstrap.min.js"></script>

		<script type="text/javascript">
			$(document).ready(function() {
				var datatable = $('#view-data-table').DataTable({
						"ajax": {
						   url : "<?= site_url('warehouse_inventories/list'); ?>",
						    type : 'GET'
						},
						"columnDefs": [
							{className: "dt-right", "targets": [-2, -3, -4, -5] },
        					{render: $.fn.dataTable.render.number( ',', '.', 2, '' ), "targets": [-5] },
							{"targets": -1, "data": null, "defaultContent": 
								"<a class=\'action-add\' data-mode=\'modal\' title=\'Add\'><i class=\'glyphicon glyphicon-plus\'></i></a>&nbsp; " +
								"<a class=\'action-deduct\' data-mode=\'modal\' title=\'Deduct\'><i class=\'glyphicon glyphicon-minus\'></i></a>&nbsp; " +
								"<a class=\'action-edit\' data-mode=\'modal\' title=\'Edit\'><i class=\'glyphicon glyphicon-pencil\'></i></a>&nbsp; " +
								"<a class=\'action-hist\' data-mode=\'modal\' title=\'History\'><i class=\'glyphicon glyphicon-calendar\'></i></a>"},
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



	    		$('#item_select').change(function(){ 
	    			var crit_qty = $('#item_select option:selected').data('critqty');
		        	$('input[name="crit_qty"]').val(crit_qty);
				})

				$('#view-data-table tbody').on( 'click', 'a.action-edit', function (id) {
					var data = $("#view-data-table").DataTable().row( $(this).parents('tr') ).data();
			       	var id = data[0];
			       	var crit = data[5];
					$("#edit_modal").find('input[name="id"]').val(id);
					$("#edit_modal").find('input[name="crit_qty"]').val(crit);
			    	$("#edit_modal").modal('show');
			    } );
		        

				$('#view-data-table tbody').on( 'click', 'a.action-add', function (id) {
					var data = $("#view-data-table").DataTable().row( $(this).parents('tr') ).data();
			       	var id = data[0];
			       	var avail = data[4];
					$("#add_modal").find('input[name="id"]').val(id);
					$("#add_modal").find('input[name="id"]').attr('data-avail', avail);
					$("#add_modal").modal('show');
			    } );
		        

				$('#view-data-table tbody').on( 'click', 'a.action-deduct', function (id) {
					var data = $("#view-data-table").DataTable().row( $(this).parents('tr') ).data();
			       	var id = data[0];
			       	var avail = data[4];
					$("#deduct_modal").find('input[name="id"]').val(id);
					$("#deduct_modal").find('input[name="id"]').attr('data-avail', avail);
					$("#deduct_modal").modal('show');
			    } );


			    $('#view-data-table tbody').on( 'click', 'a.action-hist', function (id) {
					var data = $("#view-data-table").DataTable().row( $(this).parents('tr') ).data();
			       	var id = data[0];
			        window.location.replace('<?= site_url('warehouse_inventories/hist/') ?>' + id);
			    } );


			    $('#success_modal').on('hide.bs.modal', function () {
			    	if($('#success_modal').data('trigger') =='not-new'){
						window.location = '<?= site_url('/warehouse_inventories/index') ?>';
			    	}
				});


			    $("#edit_modal_form").submit(function(e) {
					e.preventDefault();
					var id = $("#edit_modal").find('input[name="id"]').val();
					var crit = $("#edit_modal").find('input[name="crit_qty"]').val();

					if(id == ''){
						$("#error_modal .modal-content .modal-body p.text-center").text('Could not proceed with update. ID not found.');
					    $("#error_modal").modal('show');
					}
					if(crit == ''){
						$("#error_modal .modal-content .modal-body p.text-center").text('Critical Quantity is required');
					    $("#error_modal").modal('show');
					}
					if(id!='' && crit!=''){
						var data = {};
						data['submit_edit'] = true;
						data['id'] = id;
						data['crit_qty'] = crit;

						$.ajax({
							type : 'POST',
							data : data,
							url : '<?= site_url('/warehouse_inventories/index') ?>',
							success : function(data) { 
								if(data == 'OK'){
			    					$("#edit_modal").modal('toggle');
									$("#success_modal .modal-content .modal-body p.text-center").text("Inventory successfully updated.");
									$("#success_modal").attr('data-trigger', 'not-new');
									$("#success_modal").modal('show');
								}
							}
						})
						return;
					}
				})

				$("#add_modal_form").submit(function(e) {
					e.preventDefault();
					var id = $("#add_modal").find('input[name="id"]').val();
					var qty = $("#add_modal").find('input[name="adjust_qty"]').val();

					if(id == ''){
						$("#error_modal .modal-content .modal-body p.text-center").text('Could not proceed with update. ID not found.');
					    $("#error_modal").modal('show');
					}
					if(qty == ''){
						$("#error_modal .modal-content .modal-body p.text-center").text('No. of Stocks to Add is required');
					    $("#error_modal").modal('show');
					}
					if(id!='' && qty!=''){
						var data = {};
						data['submit_add'] = true;
						data['id'] = id;
						data['adjust_qty'] = qty;

						$.ajax({
							type : 'POST',
							data : data,
							url : '<?= site_url('/warehouse_inventories/index') ?>',
							success : function(data) { 
								if(data == 'OK'){
			    					$("#add_modal").modal('toggle');
									$("#success_modal .modal-content .modal-body p.text-center").text("Inventory successfully updated.");
									$("#success_modal").attr('data-trigger', 'not-new');
									$("#success_modal").modal('show');
								}
							}
						})
						return;
					}
				})

				$("#deduct_modal_form").submit(function(e) {
					e.preventDefault();
					var id = $("#deduct_modal").find('input[name="id"]').val();
					var qty = $("#deduct_modal").find('input[name="adjust_qty"]').val();
					var avail = $("#deduct_modal").find('input[name="id"]').data('avail');

					if(id == ''){
						$("#error_modal .modal-content .modal-body p.text-center").text('Could not proceed with update. ID not found.');
					    $("#error_modal").modal('show');
					}
					if(qty == ''){
						$("#error_modal .modal-content .modal-body p.text-center").text('No. of Stocks to Deduct is required.');
					    $("#error_modal").modal('show');
					}else if(parseInt(qty) > parseInt(avail)){
						$("#error_modal .modal-content .modal-body p.text-center").text('Available Quantity is not enough to deduct the requested no. of stocks.');
					    $("#error_modal").modal('show');
					}
					if(id!='' && qty!='' && parseInt(qty)<=parseInt(avail)){
						var data = {};
						data['submit_deduct'] = true;
						data['id'] = id;
						data['adjust_qty'] = qty;

						$.ajax({
							type : 'POST',
							data : data,
							url : '<?= site_url('/warehouse_inventories/index') ?>',
							success : function(data) { 
								if(data == 'OK'){
			    					$("#deduct_modal").modal('toggle');
									$("#success_modal .modal-content .modal-body p.text-center").text("Inventory successfully updated.");
									$("#success_modal").attr('data-trigger', 'not-new');
									$("#success_modal").modal('show');
								}
							}
						})
						return;
					}
				})

			});
		</script>
	</body>
</html>