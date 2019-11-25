<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Add Supplier</h1>
	</div>
</div>

<div class="row">
    <div class="col-md-12">
		<form action="" method="post" accept-charset="utf-8">
			<div class="form-group">
				<label for='supplier_name'>Supplier Name</label>
				<input required="required" type="text" name="supplier_name" class="form-control">
				<?php echo form_error('supplier_name', '<p class="help-block">','</p>'); ?>
			</div>
			<div class="form-group">
				<label for='contact_person'>Contact Person</label>
				<input required="required" type="text" name="contact_person" class="form-control">
				<?php echo form_error('contact_person', '<p class="help-block">','</p>'); ?>
			</div>
			<div class="form-group">
				<label for='address'>Address</label>
				<input required="required" type="text" name="address" class="form-control">
				<?php echo form_error('address', '<p class="help-block">','</p>'); ?>
			</div>
			<div class="form-group">
				<label for='contact_no'>Contact No.</label>
				<input required="required" type="text" name="contact_no" class="form-control">
				<?php echo form_error('contact_no', '<p class="help-block">','</p>'); ?>
			</div>
			<div class="form-group">
				<label for='email'>Email</label>
				<input required="required" type="text" name="email" class="form-control">
				<?php echo form_error('email', '<p class="help-block">','</p>'); ?>
			</div>
			<div class="form-group">
				<label for='website'>Website</label>
				<input required="required" type="text" name="website" class="form-control">
				<?php echo form_error('website', '<p class="help-block">','</p>'); ?>
			</div>
			<div class="form-group">
				<label for='notes'>Notes</label>
				<textarea name="notes" class="form-control"></textarea>
				<?php echo form_error('notes', '<p class="help-block">','</p>'); ?>
			</div>
			<div class="form-group">
				<input type="submit" name="submit_supplier" class="btn btn-success" value="Submit">
				<button class="btn btn-info" type="reset">Reset</button>
			</div>
		</form>
		<?php
			if(!empty($success_msg)){
				echo '<p class="status-msg success">'.$success_msg.'</p>';
			}elseif(!empty($error_msg)){
				echo '<p class="status-msg error">'.$error_msg.'</p>';
			}
		?>
	</div>
</div>

<script type="text/javascript" src="assets/bootstrap/4.0.0/js/bootstrap.min.js"></script>