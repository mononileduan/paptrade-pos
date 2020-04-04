<!DOCTYPE html>
<html lang="en">
	<head>
		<title>POS & Inventory System</title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="base_url" content="<?= base_url();?><?= index_page();?>">
		<base href="<?= base_url();?><?= index_page();?>">
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
			            <h2 class="page-header">Items</h2>

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
													<label class="control-label col-sm-2" for='brand_id'>Brand</label>
													<div class="col-sm-10">
														<select required="required" name="brand_id" class="form-control">
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
												</div>
												<div class="form-group">
													<label class="control-label col-sm-2" for='dscp'>Description</label>
													<div class="col-sm-10">
														<input required="required" type="text" value="<?php echo set_value('dscp'); ?>" name="dscp" class="form-control">
														<?php echo form_error('dscp', '<small class="has-error"><p class="help-block">','</p></small>'); ?>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-sm-2" for='category_id'>Category</label>
													<div class="col-sm-10">
														<select required="required" name="category_id" class="form-control">
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
												</div>
												<div class="form-group">
													<label class="control-label col-sm-2" for='price'>Price</label>
													<div class="col-sm-10">
														<input required="required" type="text" value="<?php echo set_value('price'); ?>" name="price" class="form-control">
														<?php echo form_error('price', '<small class="has-error"><italics><p class="help-block">','</p></italics></small>'); ?>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-sm-2" for='critical_qty'>Critical Quantity</label>
													<div class="col-sm-10">
														<input required="required" type="text" value="<?php echo set_value('critical_qty'); ?>" name="critical_qty" class="form-control">
														<?php echo form_error('critical_qty', '<small class="has-error"><italics><p class="help-block">','</p></italics></small>'); ?>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-sm-2" for='stock_type_id'>Stock Type</label>
													<div class="col-sm-10">
														<select required="required" name="stock_type_id" class="form-control">
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
												</div>
												<div class="form-group">
													<label class="control-label col-sm-2" for='stock_type_content'>Stock Type Content</label>
													<div class="col-sm-10">
														<input required="required" type="text" value="<?php echo set_value('stock_type_content'); ?>" name="stock_type_content" class="form-control">
														<?php echo form_error('stock_type_content', '<small class="has-error"><p class="help-block">','</p></small>'); ?>
													</div>
												</div>
												
												<div class="form-group">
													<div class="col-sm-offset-2 col-sm-10">
												    	<input type="submit" name="submit_item" class="btn btn-sm btn-success" value="Submit">
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
											<td width="20%">Brand</td>
											<td width="30%">Description</td>
											<td width="15%">Category</td>
											<td width="10%">Price</td>
											<td width="5%">Critical Quantity</td>
											<td width="10%">Stock Type</td>
											<td width="5%">Stock Type Content</td>
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

		<?php $this->load->view('components/modals'); ?>

		<script type="text/javascript" src="assets/bootstrap/3.4.1/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="assets/datatables/datatables.min.js"></script>

		<script type="text/javascript">
			$(document).ready(function() {
				var base_url = $("meta[name='base_url']").attr('content');

				var datatable = $('#view-data-table').DataTable({
						"ajax": {
						   url : "<?= site_url('items/list'); ?>",
						    type : 'GET'
						},
						"columnDefs": [
							{className: "dt-right", "targets": [-2, -4, -5] },
							{render: $.fn.dataTable.render.number( ',', '.', 2, '' ), "targets": [-5] },
							{"targets": -1, "data": null, "defaultContent": 
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
							url : base_url + '/items/index',
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
						window.location.replace(base_url + '/items/index');
			    	}
				});

			});
		</script>
	</body>
</html>