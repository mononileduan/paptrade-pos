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
			            <h2 class="page-header">Users</h2>
			            <div class="margin-left-20px">
				            <div class="row">
				            	<div class="col-md-2">
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<span class="panel-title"><span class="glyphicon glyphicon-plus"></span>&nbsp; Add New</span>
											</h4>
										</div>
										<div class="panel-body">
											<form action="" method="post" accept-charset="utf-8" autocomplete="off">
												<div class="form-group">
													<label for='last_name_add'>Last Name</label>
													<input required="required" type="text" value="<?php echo set_value('last_name'); ?>" id="last_name_add" name="last_name" class="form-control" maxlength="50">
													<?php echo form_error('last_name', '<small class="has-error"><p class="help-block">','</p></small>'); ?>
												</div>
												<div class="form-group">
													<label for='first_name_add'>First Name</label>
													<input required="required" type="text" value="<?php echo set_value('first_name'); ?>" id="first_name_add" name="first_name" class="form-control" maxlength="50">
													<?php echo form_error('first_name', '<small class="has-error"><p class="help-block">','</p></small>'); ?>
												</div>
												<div class="form-group">
													<label for='branch_id_add'>Branch</label>
													<select required="required" id="branch_id_add" name="branch_id" class="form-control">
														<option value=""></option>
														<?php foreach($branches->result_array() as $r) {
															if(set_value('branch_id') === $r['ID']){
																echo '<option value="'.$r['ID'].'" selected="selected">'.$r['BRANCH_NAME'].'</option>';
															}else{
																echo '<option value="'.$r['ID'].'">'.$r['BRANCH_NAME'].'</option>';
															}
														} ?>
													</select>
													<?php echo form_error('branch_id', '<small class="has-error"><p class="help-block">','</p></small>'); ?>
												</div>
												<div class="form-group">
													<label for='username_add'>Username</label>
													<input required="required" type="text" value="<?php echo set_value('username'); ?>" id="username_add" name="username" class="form-control" maxlength="50">
													<?php echo form_error('username', '<small class="has-error"><p class="help-block">','</p></small>'); ?>
												</div>
												<div class="form-group">
													<label for='password_add'>Password</label>
													<input required="required" type="password" value="<?php echo set_value('password'); ?>" id="password_add" name="password" class="form-control" maxlength="50">
													<?php echo form_error('password', '<small class="has-error"><p class="help-block">','</p></small>'); ?>
												</div>
												<div class="form-group">
													<label for='role_add'>Role</label>
													<select required="required" id="role_add" name="role" class="form-control">
														<option value=""></option>
														<?php foreach($roles as $r) {
															if(set_value('role') === $r['0']){
																echo '<option value="'.$r[0].'" selected="selected">'.$r[1].'</option>';
															}else{
																echo '<option value="'.$r[0].'">'.$r[1].'</option>';
															}
														}?>
													</select>
													<?php echo form_error('role', '<small class="has-error"><p class="help-block">','</p></small>'); ?>
												</div>
												<input type="submit" name="submit_user" class="btn btn-sm btn-primary" value="Submit">
											</form>
										</div>
									</div>
								</div>
								<div class="col-md-10">
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
														<th>BRANCH ID</th>
														<th width="15%">Last Name</th>
														<th width="15%">First Name</th>
														<th width="15%">Branch Name</th>
														<th width="15%">Role</th>
														<th width="5%">Status</th>
														<th width="15%">Username</th>
														<th width="15%">Last Login Date</th>
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

		<div class="modal" tabindex="-1" role="dialog" id="update_modal">
			<div class="modal-dialog modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Update User</h5>
					</div>
					<form action="" method="post" accept-charset="utf-8" class="form-horizontal" id="update_user_modal_form">
						<div class="modal-body">
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title">
										<span class="panel-title"><span class="glyphicon glyphicon-edit"></span>&nbsp; Edit</span>
									</h4>
								</div>
								<div class="panel-body">
									<div class="container-fluid">
									 <div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label for='last_name'>Last Name</label>
												<input required="required" type="text" value="<?php echo set_value('last_name'); ?>" id="last_name" name="last_name" class="form-control" maxlength="50">
												<?php echo form_error('last_name', '<small class="has-error"><p class="help-block">','</p></small>'); ?>
											</div>
											<div class="form-group">
												<label for='first_name'>First Name</label>
												<input required="required" type="text" value="<?php echo set_value('first_name'); ?>" id="first_name" name="first_name" class="form-control" maxlength="50">
												<?php echo form_error('first_name', '<small class="has-error"><p class="help-block">','</p></small>'); ?>
											</div>
											<div class="form-group">
												<label for='branch_id'>Branch</label>
												<select required="required" id="branch_id" name="branch_id" class="form-control">
													<option value=""></option>
													<?php foreach($branches->result_array() as $r) {
														if(set_value('branch_id') === $r['ID']){
															echo '<option value="'.$r['ID'].'" selected="selected">'.$r['BRANCH_NAME'].'</option>';
														}else{
															echo '<option value="'.$r['ID'].'">'.$r['BRANCH_NAME'].'</option>';
														}
													} ?>
												</select>
												<?php echo form_error('branch_id', '<small class="has-error"><p class="help-block">','</p></small>'); ?>
											</div>
											<div class="form-group">
												<label for='role'>Role</label>
												<select required="required" id="role" name="role" class="form-control">
													<option value=""></option>
													<?php foreach($roles as $r) {
														if(set_value('role') === $r['0']){
															echo '<option value="'.$r[0].'" selected="selected">'.$r[1].'</option>';
														}else{
															echo '<option value="'.$r[0].'">'.$r[1].'</option>';
														}
													}?>
												</select>
												<?php echo form_error('role', '<small class="has-error"><p class="help-block">','</p></small>'); ?>
											</div>
											<div class="form-group">
												<label for='status'>Status</label>
												<select required="required" id="status" name="status" class="form-control">
													<option value=""></option>
													<?php foreach($status as $r) {
														if(set_value('status') === $r['0']){
															echo '<option value="'.$r[0].'" selected="selected">'.$r[1].'</option>';
														}else{
															echo '<option value="'.$r[0].'">'.$r[1].'</option>';
														}
													}?>
												</select>
												<?php echo form_error('status', '<small class="has-error"><p class="help-block">','</p></small>'); ?>
											</div>
										</div>
									</div>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer"> 
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<input type="hidden" name="id">
							    	<input type="submit" name="submit_edit" class="btn btn-sm btn-primary" value="Submit">
									<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal" id="edit-modal-close">Close</button>
							    </div>
							</div>
						</div>
					</form>
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
						   url : "<?= site_url('users/list'); ?>",
						    type : 'GET'
						},
						"order": [[ 2, "asc" ]],
						"columnDefs": [
							{className: "dt-right", "targets": [] },
							{render: $.fn.dataTable.render.number( ',', '.', 2, '' ), "targets": [] },
							{"render": function ( data, type, row ) {
				                	var status = <?php echo json_encode($status); ?>;
				                	for(i=0; i<status.length; i++){
				                		if(status[i][0] == data){
				                			return status[i][1];
				                		}
				                	}
				                },
				                "targets": -4 },
							{"render": function ( data, type, row ) {
				                	var role = <?php echo json_encode($roles); ?>;
				                	for(i=0; i<role.length; i++){
				                		if(role[i][0] == data){
				                			return role[i][1];
				                		}
				                	}
				                },
				                "targets": -5 },
							{"targets": -1, "data": null, "orderable": false, "defaultContent": 
								"<a class=\'action-edit\' title=\'Edit\'><i class=\'glyphicon glyphicon-pencil\'></i></a>&nbsp; "},
							{"targets": [ 0, 1 ], "visible": false, "searchable": false}
						],
						dom: 'lBftipr',
						buttons: [
								{
					                extend: 'copyHtml5',
					                exportOptions: {
					                    columns: [ 2, 3, 4, 5, 6, 7, 8 ]
					                }
					            },
								{
					                extend: 'excelHtml5',
					                exportOptions: {
					                    columns: [ 2, 3, 4, 5, 6, 7, 8 ]
				                	},
				                	messageTop: 'Users',
				                	messageBottom: '***Nothing follows***',
				                	customize: function ( xlsx ) {
									    var sheet = xlsx.xl.worksheets['sheet1.xml'];
										
									    
									}
				            	},
					            {
					                extend: 'pdfHtml5',
					                exportOptions: {
					                    columns: [ 2, 3, 4, 5, 6, 7, 8 ]
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
											text: "Users",
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
										};
										doc.content[4].table.widths = [ '15%', '15%', '17%', '15%', '10%', '13%', '15%' ];

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
					                    columns: [ 2, 3, 4, 5, 6, 7, 8 ]
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

					 					
					 					$( "<h3>Users</h3>" ).insertAfter( $(win.document.body).find( 'h3' ) )
					 						.css( 'text-align', 'center' )
					 						.css( 'margin-top', '5px' );

					 					var export_dtls = '<div style="max-width:50%; float:left;">'+
					 						'<label> </label> <span class="text-right ccy"> </span> <br/>'+
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


			       	$("#update_user_modal_form").find('input[name="id"]').val(id);
			       	$("#update_user_modal_form").find('input[name="last_name"]').val(lastname);
			       	$("#update_user_modal_form").find('input[name="first_name"]').val(firstname);
			       	$("#update_user_modal_form").find('select[name="branch_id"]').val(branch_id);
			       	$("#update_user_modal_form").find('select[name="role"]').val(role);
			       	$("#update_user_modal_form").find('select[name="status"]').val(status);
					$("#update_modal").modal('show');
			    } );

			    $("#update_user_modal_form").submit(function(e) {
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