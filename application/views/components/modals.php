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

<!--div id="delete_modal" class="modal fade" role="dialog" aria-labelledby="edit" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Delete this entry</h4>
			</div>
			<div class="modal-body">
				<div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span>&nbsp;&nbsp;Are you sure you want to delete this record?</div>
			</div>
			<div class="modal-footer ">
				<input type="hidden" name="id">
				<button type="button" class="btn btn-danger" ><span class="fas fa-check"></span> Yes</button>
				<button type="button" class="btn btn-default" data-dismiss="modal"><span class="fas fa-times"></span> No</button>
			</div>
		</div>
	</div>
</div-->

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
				<form action="" id="delete_modal_form" method="post" accept-charset="utf-8">
					<input type="hidden" name="id">
					<input type="submit" name="submit_deletet" class="btn btn-error btn-success btn-block" value="Yes">
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
					<i class="material-icons">help-circle</i>
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