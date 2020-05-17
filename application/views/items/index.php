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
			            <h2 class="page-header">Items</h2>
						<div class="margin-left-20px">
				            <div class="row">
				            	<div class="col-md-3">
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<span class="panel-title"><span class="glyphicon glyphicon-plus"></span>&nbsp; Add New</span>
											</h4>
										</div>
										<div class="panel-body">
											<form action="" method="post" accept-charset="utf-8" autocomplete="off">
												<div class="form-group">
													<label for='brand_id'>Brand</label>
													<select required="required" id="brand_id" name="brand_id" class="form-control">
														<option value=""></option>
														<?php foreach($brands->result_array() as $r) {
															if(set_value('brand_id') === $r['ID']){
																echo '<option value="'.$r['ID'].'" selected="selected">'.$r['BRAND'].'</option>';
															}else{
																echo '<option value="'.$r['ID'].'">'.$r['BRAND'].'</option>';
															}
														} ?>
													</select>
													<?php echo form_error('brand_id', '<small class="has-error"><p class="help-block">','</p></small>'); ?>
												</div>
												<div class="form-group">
													<label for='dscp'>Description</label>
													<input required="required" type="text" value="<?php echo set_value('dscp'); ?>" id="dscp" name="dscp" class="form-control" maxlength="50">
													<?php echo form_error('dscp', '<small class="has-error"><p class="help-block">','</p></small>'); ?>
												</div>
												<div class="form-group">
													<label for='category_id'>Category</label>
													<select required="required" id="category_id" name="category_id" class="form-control">
														<option value=""></option>
														<?php foreach($categories->result_array() as $r) {
															if(set_value('category_id') === $r['ID']){
																echo '<option value="'.$r['ID'].'" selected="selected">'.$r['CATEGORY'].'</option>';
															}else{
																echo '<option value="'.$r['ID'].'">'.$r['CATEGORY'].'</option>';
															}
														} ?>
													</select>
													<?php echo form_error('category_id', '<small class="has-error"><p class="help-block">','</p></small>'); ?>
												</div>
												<div class="form-group">
													<label for='price'>Price</label>
													<input required="required" type="text" value="<?php echo set_value('price'); ?>" id="price" name="price" class="form-control" maxlength="10">
													<?php echo form_error('price', '<small class="has-error"><p class="help-block">','</p></small>'); ?>
												</div>
												<div class="form-group">
													<label for='critical_qty'>Critical Quantity</label>
													<input required="required" type="text" value="<?php echo set_value('critical_qty'); ?>" id="critical_qty" name="critical_qty" class="form-control" maxlength="10">
													<?php echo form_error('critical_qty', '<small class="has-error"><p class="help-block">','</p></small>'); ?>
												</div>
												<div class="form-group">
													<label for='stock_type_id'>Stock Type</label>
													<select required="required" id="stock_type_id" name="stock_type_id" class="form-control">
														<option value=""></option>
														<?php foreach($stock_types->result_array() as $r) {
															if(set_value('stock_type_id') === $r['ID']){
																echo '<option value="'.$r['ID'].'" selected="selected">'.$r['STOCK_TYPE'].'</option>';
															}else{
																echo '<option value="'.$r['ID'].'">'.$r['STOCK_TYPE'].'</option>';
															}
														} ?>
													</select>
													<?php echo form_error('stock_type_id', '<small class="has-error"><p class="help-block">','</p></small>'); ?>
												</div>
												<div class="form-group">
													<label for='stock_type_content'>Stock Type Content</label>
													<input required="required" type="text" value="<?php echo set_value('stock_type_content'); ?>" id="stock_type_content" name="stock_type_content" class="form-control" maxlength="10">
													<?php echo form_error('stock_type_content', '<small class="has-error"><p class="help-block">','</p></small>'); ?>
												</div>
												<input type="submit" name="submit_item" class="btn btn-sm btn-primary" value="Submit">
											</form>
										</div>
									</div>
								</div>
								<div class="col-md-9">
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
														<th></th>
														<th width="20%">Brand</th>
														<th width="30%">Description</th>
														<th width="15%">Category</th>
														<th width="10%">Price</th>
														<th width="5%">Critical Quantity</th>
														<th width="10%">Stock Type</th>
														<th width="5%">Stock Type Content</th>
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

		<script type="text/javascript" src="assets/bootstrap/3.4.1/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="assets/datatables/datatables.min.js"></script>

		<script type="text/javascript" src="assets/js/page.height.setter.js"></script>

		<script type="text/javascript">
			$(document).ready(function() {
				var datatable = $('#view-data-table').DataTable({
						"ajax": {
						   url : "<?= site_url('items/list'); ?>",
						    type : 'GET'
						},
						"order": [[ 1, "asc" ]],
						"columnDefs": [
							{className: "dt-right", "targets": [-2, -4, -5] },
							{render: $.fn.dataTable.render.number( ',', '.', 2, '' ), "targets": [-5] },
							{"targets": -1, "data": null, "orderable": false, "defaultContent": 
								"<a class=\'action-edit\' title=\'Edit\'><i class=\'glyphicon glyphicon-pencil\'></i></a>&nbsp; " +
								"<a class=\'action-delete\' data-mode=\'modal\' title=\'Delete\'><i class=\'glyphicon glyphicon-trash\'></i></a>"},
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

	    		$('#view-data-table tbody').on( 'click', 'a.action-edit', function (id) {
					var data = $("#view-data-table").DataTable().row( $(this).parents('tr') ).data();
			       	var id = data[0];
					window.location.replace('<?= site_url('items/edit/') ?>' + id);
			    } );

	    		$('#view-data-table tbody').on( 'click', 'a.action-delete', function (id) {
					var data = $("#view-data-table").DataTable().row( $(this).parents('tr') ).data();
			       	var id = data[0];
			       	var dscp = data[1] + ' ' + data[2];
					$("#delete_modal").find('input[name="id"]').val(id);
					$("#delete_modal").find('p.dscp').text(dscp);
			    	$("#delete_modal").modal('show');
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
							url : '<?= site_url('/items/index') ?>',
							success : function(data) { 
								if(data == 'OK'){
			    					$("#delete_modal").modal('toggle');
									$("#success_modal .modal-content .modal-body p.text-center").text("Item successfully deleted.");
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
						window.location.replace('<?= site_url('/items/index') ?>');
			    	}
				});

			});
		</script>
	</body>
</html>