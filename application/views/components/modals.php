<style type="text/css">
    body {
		font-family: 'Varela Round', sans-serif;
	}
	.modal-confirm {		
		color: #636363;
		width: 325px;
	}
	.modal-confirm .modal-content {
		padding: 20px;
		border-radius: 5px;
		border: none;
	}
	.modal-confirm .modal-header {
		border-bottom: none;   
        position: relative;
        display: block;
	}
	.modal-confirm h4 {
		text-align: center;
		font-size: 26px;
		margin: 30px 0 -15px;
	}
	.modal-confirm .form-control, .modal-confirm .btn {
		min-height: 40px;
		border-radius: 3px; 
	}
	.modal-confirm .close {
        position: absolute;
		top: -5px;
		right: -5px;
	}	
	.modal-confirm .modal-footer {
		border: none;
		text-align: center;
		border-radius: 5px;
		font-size: 13px;
	}	
	.modal-confirm .icon-box {
		color: #fff;		
		position: absolute;
		margin: 0 auto;
		left: 0;
		right: 0;
		top: -70px;
		width: 95px;
		height: 95px;
		border-radius: 50%;
		z-index: 9;
		background: #82ce34;
		padding: 15px;
		text-align: center;
		box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);
	}
	.modal-confirm .error-icon-box {
		color: #fff;		
		position: absolute;
		margin: 0 auto;
		left: 0;
		right: 0;
		top: -70px;
		width: 95px;
		height: 95px;
		border-radius: 50%;
		z-index: 9;
		background: #f15e5e;
		padding: 15px;
		text-align: center;
		box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);
	}
	.modal-confirm .icon-box i {
		font-size: 58px;
		position: relative;
		top: 3px;
	}
	.modal-confirm .error-icon-box i {
		font-size: 58px;
		position: relative;
		top: 3px;
	}
	.modal-confirm.modal-dialog {
		margin-top: 80px;
	}
    .modal-confirm .btn {
        color: #fff;
        border-radius: 4px;
		background: #82ce34;
		text-decoration: none;
		transition: all 0.4s;
        line-height: normal;
        border: none;
    }
	.modal-confirm .btn:hover, .modal-confirm .btn:focus {
		background: #6fb32b;
		outline: none;
	}
	.modal-confirm .btn-error {
        color: #fff;
        border-radius: 4px;
		background: #f15e5e;
		text-decoration: none;
		transition: all 0.4s;
        line-height: normal;
        border: none;
    }
	.modal-confirm .btn-error:hover, .modal-confirm .btn-error:focus {
		background: #f15e5e;
		outline: none;
	}
	.modal-confirm .dscp {
		font-weight: bold;
		margin-top:20px;
	}

</style>

<div id="delete_modal" class="modal fade">
	<div class="modal-dialog modal-confirm">
		<div class="modal-content">
			<div class="modal-header">
				<div class="error-icon-box">
					<i class="material-icons">warning</i>
				</div>	
				<div>		
					<h4>Delete</h4>	
				</div>	
			</div>
			<div class="modal-body">
				<p class="text-center">Are you sure you want to delete this record?</p>
				<p class="dscp text-center"></p>
			</div>
			<div class="modal-footer">
				<form action="" id="delete_modal_form" method="post" accept-charset="utf-8" autocomplete="off">
					<input type="hidden" name="id">
					<input type="submit" name="submit_delete" class="btn btn-error btn-success btn-block" value="Yes">
					<button class="btn btn-info btn-block" data-dismiss="modal">No</button>
				</form>
			</div>
		</div>
	</div>
</div>

<div id="confirm_modal" class="modal fade">
	<div class="modal-dialog modal-confirm">
		<div class="modal-content">
			<div class="modal-header">
				<div class="icon-box">
					<i class="material-icons">help</i>
				</div>	
				<div>		
					<h4>Confirm</h4>	
				</div>	
			</div>
			<div class="modal-body">
				<p class="text-center">Are you sure you want to add this record?</p>
			</div>
			<div class="modal-footer">
				<button class="btn btn-success btn-block" data-dismiss="modal">OK</button>
			</div>
		</div>
	</div>
</div>

<div id="confirm_update_modal" class="modal fade">
	<div class="modal-dialog modal-confirm">
		<div class="modal-content">
			<div class="modal-header">
				<div class="icon-box">
					<i class="material-icons">help</i>
				</div>	
				<div>		
					<h4>Confirm</h4>	
				</div>	
			</div>
			<div class="modal-body">
				<p class="text-center">Are you sure you want to update this record?</p>
				<p class="dscp text-center"></p>
			</div>
			<div class="modal-footer">
				<form action="" id="update_modal_form" method="post" accept-charset="utf-8" autocomplete="off">
					<input type="hidden" name="id">
					<input type="submit" name="submit_update" class="btn btn-error btn-success btn-block" value="Yes">
					<button class="btn btn-info btn-block" data-dismiss="modal">No</button>
				</form>
			</div>
		</div>
	</div>
</div>

<div id="success_modal" class="modal fade">
	<div class="modal-dialog modal-confirm">
		<div class="modal-content">
			<div class="modal-header">
				<div class="icon-box">
					<i class="material-icons">&#xE876;</i>
				</div>	
				<div>		
					<h4>Success!</h4>	
				</div>	
			</div>
			<div class="modal-body">
				<p class="text-center">Success!</p>
			</div>
			<div class="modal-footer">
				<button class="btn btn-success btn-block" data-dismiss="modal">OK</button>
			</div>
		</div>
	</div>
</div>

<div id="error_modal" class="modal fade">
	<div class="modal-dialog modal-confirm">
		<div class="modal-content">
			<div class="modal-header">
				<div class="error-icon-box">
					<i class="material-icons">error</i>
				</div>	
				<div>		
					<h4>Error</h4>	
				</div>	
			</div>
			<div class="modal-body">
				<p class="text-center">Error!</p>
			</div>
			<div class="modal-footer">
				<button class="btn btn-error btn-success btn-block" data-dismiss="modal">OK</button>
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
			<form action="" id="edit_modal_form" method="post" accept-charset="utf-8" autocomplete="off">
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
			<form action="" id="add_modal_form" method="post" accept-charset="utf-8" autocomplete="off">
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
			<form action="" id="deduct_modal_form" method="post" accept-charset="utf-8" autocomplete="off">
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