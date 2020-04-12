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
			            <h2 class="page-header">Users</h2>

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
													<label class="control-label col-sm-2" for='last_name'>Last Name</label>
													<div class="col-sm-10">
														<input required="required" type="text" value="<?php echo set_value('last_name'); ?>" name="last_name" class="form-control">
														<?php echo form_error('last_name', '<small class="has-error"><p class="help-block">','</p></small>'); ?>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-sm-2" for='first_name'>First Name</label>
													<div class="col-sm-10">
														<input required="required" type="text" value="<?php echo set_value('first_name'); ?>" name="first_name" class="form-control">
														<?php echo form_error('first_name', '<small class="has-error"><p class="help-block">','</p></small>'); ?>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-sm-2" for='branch_id'>Branch</label>
													<div class="col-sm-10">
														<select required="required" name="branch_id" class="form-control">
															<option value=""></option>
															<?php foreach($branches->result_array() as $r) {
																if(set_value('branch_id') === $r['ID']){
																	echo '<option value="'.$r['ID'].'" selected="selected">'.$r['BRANCH_NAME'].'</option>';
																}else{
																	if($this->session->userdata('user_role') == 'Branch Administrator'){
																		if($this->session->userdata('branch_id') === $r['ID']){
																			echo '<option value="'.$r['ID'].'" selected="selected">'.$r['BRANCH_NAME'].'</option>';
																		}
																	}else{
																		echo '<option value="'.$r['ID'].'">'.$r['BRANCH_NAME'].'</option>';
																	}
																}
															} ?>
														</select>
														<?php echo form_error('branch_id', '<small class="has-error"><p class="help-block">','</p></small>'); ?>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-sm-2" for='username'>Username</label>
													<div class="col-sm-10">
														<input required="required" type="text" value="<?php echo set_value('username'); ?>" name="username" class="form-control">
														<?php echo form_error('username', '<small class="has-error"><p class="help-block">','</p></small>'); ?>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-sm-2" for='password'>Password</label>
													<div class="col-sm-10">
														<input required="required" type="password" value="<?php echo set_value('password'); ?>" name="password" class="form-control">
														<?php echo form_error('password', '<small class="has-error"><p class="help-block">','</p></small>'); ?>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-sm-2" for='role'>Role</label>
													<div class="col-sm-10">
														<select required="required" name="role" class="form-control">
															<option value=""></option>
															<?php if($this->session->userdata('user_role') == 'System Administrator'){
															echo '<option value="System Administrator">System Administrator</option>';
															}?>
															<option value="Branch Administrator">Branch Administrator</option>
															<option value="Cashier">Cashier</option>
														</select>
														<?php echo form_error('role', '<small class="has-error"><p class="help-block">','</p></small>'); ?>
													</div>
												</div>
												
												<div class="form-group">
													<div class="col-sm-offset-2 col-sm-10">
												    	<input type="submit" name="submit_user" class="btn btn-sm btn-success" value="Submit">
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
											<td>ID</td>
											<td>BRANCH ID</td>
											<td width="15%">Last Name</td>
											<td width="15%">First Name</td>
											<td width="15%">Branch Name</td>
											<td width="10%">Role</td>
											<td width="10%">Status</td>
											<td width="15%">Username</td>
											<td width="15%">Last Login Date</td>
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

		<div class="modal" tabindex="-1" role="dialog" id="update_modal">
			<div class="modal-dialog modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Update User</h5>
					</div>
					<form action="" method="post" accept-charset="utf-8" class="form-horizontal" id="update_modal_form">
						<div class="modal-body">
							<div class="form-group">
								<label class="control-label col-sm-3" for='last_name'>Last Name</label>
								<div class="col-sm-9">
									<input required="required" type="text" value="<?php echo set_value('last_name'); ?>" name="last_name" class="form-control">
									<?php echo form_error('last_name', '<small class="has-error"><p class="help-block">','</p></small>'); ?>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-3" for='first_name'>First Name</label>
								<div class="col-sm-9">
									<input required="required" type="text" value="<?php echo set_value('first_name'); ?>" name="first_name" class="form-control">
									<?php echo form_error('first_name', '<small class="has-error"><p class="help-block">','</p></small>'); ?>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-3" for='branch_id'>Branch</label>
								<div class="col-sm-9">
									<select required="required" name="branch_id" class="form-control">
										<option value=""></option>
										<?php foreach($branches->result_array() as $r) {
											if(set_value('branch_id') === $r['ID']){
												echo '<option value="'.$r['ID'].'" selected="selected">'.$r['BRANCH_NAME'].'</option>';
											}else{
												if($this->session->userdata('user_role') == 'Branch Administrator'){
													if($this->session->userdata('branch_id') === $r['ID']){
														echo '<option value="'.$r['ID'].'" selected="selected">'.$r['BRANCH_NAME'].'</option>';
													}
												}else{
													echo '<option value="'.$r['ID'].'">'.$r['BRANCH_NAME'].'</option>';
												}
											}
										} ?>
									</select>
									<?php echo form_error('branch_id', '<small class="has-error"><p class="help-block">','</p></small>'); ?>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-3" for='role'>Role</label>
								<div class="col-sm-9">
									<select required="required" name="role" class="form-control">
										<option value=""></option>
										<?php if($this->session->userdata('user_role') == 'System Administrator'){
											echo '<option value="System Administrator">System Administrator</option>';
										}?>
										<option value="Branch Administrator">Branch Administrator</option>
										<option value="Cashier">Cashier</option>
									</select>
									<?php echo form_error('role', '<small class="has-error"><p class="help-block">','</p></small>'); ?>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-3" for='status'>Status</label>
								<div class="col-sm-9">
									<select required="required" name="status" class="form-control">
										<option value=""></option>
										<option value="Active">Active</option>
										<option value="Blocked">Blocked</option>
									</select>
									<?php echo form_error('status', '<small class="has-error"><p class="help-block">','</p></small>'); ?>
								</div>
							</div>
						</div>
						<div class="modal-footer"> 
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<input type="hidden" name="id">
									<button type="button" class="btn btn-secondary" data-dismiss="modal" id="payment-modal-close">Close</button>
							    	<input type="submit" name="submit_edit" class="btn btn-sm btn-success" value="Submit">
							    </div>
							</div>
						</div>
					</form>
				</div>

			</div>
		</div>

		<?php $this->load->view('components/modals'); ?>

		<script type="text/javascript" src="assets/bootstrap/3.4.1/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="assets/datatables/datatables.min.js"></script>

		<script type="text/javascript">
			$(document).ready(function() {
				var datatable = $('#view-data-table').DataTable({
						"ajax": {
						   url : "<?= site_url('users/list'); ?>",
						    type : 'GET'
						},
						"order": [[ 2, "asc" ]],
						"columnDefs": [
							{className: "dt-right", "targets": [] },
							{render: $.fn.dataTable.render.number( ',', '.', 2, '' ), "targets": [] },
							{"targets": -1, "data": null, "defaultContent": 
								"<a class=\'action-edit\' title=\'Edit\'><i class=\'glyphicon glyphicon-pencil\'></i></a>&nbsp; "},
							{"targets": [ 0, 1 ], "visible": false, "searchable": false}
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
			       	var branch_id = data[1];
			       	var lastname = data[2];
			       	var firstname = data[3];
			       	var branch_name = data[4];
			       	var role = data[5];
			       	var status = data[6];


			       	$("#update_modal_form").find('input[name="id"]').val(id);
			       	$("#update_modal_form").find('input[name="last_name"]').val(lastname);
			       	$("#update_modal_form").find('input[name="first_name"]').val(firstname);
			       	$("#update_modal_form").find('select[name="branch_id"]').val(branch_id);
			       	$("#update_modal_form").find('select[name="role"]').val(role);
			       	$("#update_modal_form").find('select[name="status"]').val(status);
					$("#update_modal").modal('show');
			    } );

			    $("#update_modal_form").submit(function(e) {
					e.preventDefault();
					var id = $("#update_modal").find('input[name="id"]').val();

					if(id == ''){
						$("#error_modal .modal-content .modal-body p.text-center").text('Could not proceed with update. ID not found.');
					    $("#error_modal").modal('show');
					}

					if($("#update_modal").find('input[name="last_name"]').val() == ''){
						$("#error_modal .modal-content .modal-body p.text-center").text('Last Name is required');
					    $("#error_modal").modal('show');
					}

					if($("#update_modal").find('input[name="first_name"]').val() == ''){
						$("#error_modal .modal-content .modal-body p.text-center").text('First Name is required');
					    $("#error_modal").modal('show');
					}

					if($("#update_modal").find('select[name="branch_id"]').val() == ''){
						$("#error_modal .modal-content .modal-body p.text-center").text('Branch is required');
					    $("#error_modal").modal('show');
					}

					if($("#update_modal").find('select[name="role"]').val() == ''){
						$("#error_modal .modal-content .modal-body p.text-center").text('Role is required');
					    $("#error_modal").modal('show');
					}

					if($("#update_modal").find('select[name="status"]').val() == ''){
						$("#error_modal .modal-content .modal-body p.text-center").text('Status is required');
					    $("#error_modal").modal('show');
					}
					
					if(id!=''){
						var data = {};
						data['submit_edit'] = true;
						data['id'] = id;
						data['last_name'] = $("#update_modal").find('input[name="last_name"]').val();
						data['first_name'] = $("#update_modal").find('input[name="first_name"]').val();
						data['branch_id'] = $("#update_modal").find('select[name="branch_id"]').val();
						data['role'] = $("#update_modal").find('select[name="role"]').val();
						data['status'] = $("#update_modal").find('select[name="status"]').val();

						$.ajax({
							type : 'POST',
							data : data,
							url : '<?= site_url('/users/index') ?>',
							success : function(data) { 
								if(data == 'OK'){
			    					$("#update_modal").modal('toggle');
									$("#success_modal .modal-content .modal-body p.text-center").text("User successfully updated.");
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
						window.location.replace('<?= site_url('/users/index') ?>');
			    	}
				});

			});
		</script>
	</body>
</html>