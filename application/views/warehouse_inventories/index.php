		<div class="content">
			<div class="row page-title">
				<div class="col-lg-12">
					<h1 class="page-header">Inventory</h1>
				</div>
			</div>

			<div class="row-pad"></div>

			<div class="row">
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-12">
							<a href="#add_container" class="btn btn-primary btn-sm" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class='fas fa-plus'></i> Add New</a>
						</div>
					</div>

					<div class="row-pad"></div>

					<div class="row collapse <?php if(!empty($error_msg)){echo 'show';} ?> border border-primary rounded" id="add_container" style="padding-top: 10px;">
						<div class="col-md-12">
							<div class="col-md-12">
								<form action="" method="post" accept-charset="utf-8">
									<div class="form-group">
										<label for='item_id'>Item</label>
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
										<?php echo form_error('item_id', '<p class="help-block">','</p>'); ?>
									</div>
									<div class="form-group">
										<label for='init_qty'>Initial Quantity</label>
										<input required="required" type="text" value="<?php echo set_value('init_qty'); ?>" name="init_qty" class="form-control">
										<?php echo form_error('init_qty', '<p class="help-block">','</p>'); ?>
									</div>
									<div class="form-group">
										<label for='crit_qty'>Critical Quantity</label>
										<input required="required" type="text" value="<?php echo set_value('crit_qty'); ?>" name="crit_qty" class="form-control">
										<?php echo form_error('crit_qty', '<p class="help-block">','</p>'); ?>
									</div>
									
									<div class="form-group">
										<input type="submit" name="submit_new_inventory" class="btn btn-sm btn-success" value="Submit">
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
								<td width="45%">Item</td>
								<td width="15%">Category</td>
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




<div id="edit_modal" class="modal fade">
	<div class="modal-dialog modal-confirm">
		<div class="modal-content">
			<div class="modal-header">
				<div class="icon-box">
					<i class="material-icons">edit</i>
				</div>	
				<div>		
					<h4>Update</h4>	
				</div>	
			</div>
			<form action="" id="edit_modal_form" method="post" accept-charset="utf-8">
				<div class="modal-body">
					<div class="form-group">
						<label for='crit_qty'>Critical Quantity</label>
						<input required="required" type="text" value="<?php echo set_value('crit_qty'); ?>" name="crit_qty" class="form-control">
						<?php echo form_error('crit_qty', '<p class="help-block">','</p>'); ?>
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="id" >
					<input type="submit" name="submit_edit" class="btn btn-sm btn-success btn-block" value="Submit">
				</div>
			</form>
		</div>
	</div>
</div>


<div id="add_modal" class="modal fade">
	<div class="modal-dialog modal-confirm">
		<div class="modal-content">
			<div class="modal-header">
				<div class="icon-box">
					<i class="material-icons">add</i>
				</div>	
				<div>		
					<h4>Add Stocks</h4>	
				</div>	
			</div>
			<form action="" id="add_modal_form" method="post" accept-charset="utf-8">
				<div class="modal-body">
					<div class="form-group">
						<label for='adjust_qty'>No. of Stocks to Add</label>
						<input required="required" type="text" value="<?php echo set_value('adjust_qty'); ?>" name="adjust_qty" class="form-control">
						<?php echo form_error('adjust_qty', '<p class="help-block">','</p>'); ?>
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="id" >
					<input type="submit" name="submit_add" class="btn btn-sm btn-success btn-block" value="Submit">
				</div>
			</form>
		</div>
	</div>
</div>


<div id="deduct_modal" class="modal fade">
	<div class="modal-dialog modal-confirm">
		<div class="modal-content">
			<div class="modal-header">
				<div class="icon-box">
					<i class="material-icons">remove</i>
				</div>	
				<div>		
					<h4>Deduct Stocks</h4>	
				</div>	
			</div>
			<form action="" id="deduct_modal_form" method="post" accept-charset="utf-8">
				<div class="modal-body">
					<div class="form-group">
						<label for='adjust_qty'>No. of Stocks to Deduct</label>
						<input required="required" type="text" value="<?php echo set_value('adjust_qty'); ?>" name="adjust_qty" class="form-control">
						<?php echo form_error('adjust_qty', '<p class="help-block">','</p>'); ?>
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="id">
					<input type="submit" name="submit_deduct" class="btn btn-sm btn-success btn-block" value="Submit">
				</div>
			</form>
		</div>
	</div>
</div>


<script type="text/javascript">
    $(document).ready(function(){
		var base_url = $("meta[name='base_url']").attr('content');

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

	    $('#success_modal').on('hide.bs.modal', function () {
	    	if($('#success_modal').data('trigger') =='not-new'){
				window.location = base_url + '/warehouse_inventories/index';
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
					url : base_url + '/warehouse_inventories/index',
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
					url : base_url + '/warehouse_inventories/index',
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
					url : base_url + '/warehouse_inventories/index',
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