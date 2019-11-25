<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Add Category</h1>
	</div>
</div>

<div class="row">
    <div class="col-md-12">
		<form action="" method="post" accept-charset="utf-8">
			<div class="form-group">
				<label for='category'>Category</label>
				<input required="required" type="text" name="category" class="form-control">
				<?php echo form_error('category', '<p class="help-block">','</p>'); ?>
			</div>
			<div class="form-group">
				<input type="submit" name="submit_category" class="btn btn-success" value="Submit">
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