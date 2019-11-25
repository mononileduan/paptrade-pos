<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Add Model</h1>
	</div>
</div>

<div class="row">
    <div class="col-md-12">
		<form action="" method="post" accept-charset="utf-8">
			<div class="form-group">
				<label for='brand'>Brand</label>
				<select required="required" name="brand" class="form-control">
					<option value="" selected="selected"></option>
					<?php foreach($brands->result_array() as $r) {
						echo '<option value="'.$r['BRAND'].'">'.$r['BRAND'].'</option>';
					} ?>
				</select>
				<?php echo form_error('brand', '<p class="help-block">','</p>'); ?>
			</div>
			<div class="form-group">
				<label for='model'>Model</label>
				<input required="required" type="text" name="model" class="form-control">
				<?php echo form_error('model', '<p class="help-block">','</p>'); ?>
			</div>
			<div class="form-group">
				<input type="submit" name="submit_model" class="btn btn-success" value="Submit">
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