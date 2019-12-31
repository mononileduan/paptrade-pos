<div class="content">
	<div class="row page-title">
		<div class="col-lg-12">
			<h1 class="page-header">Add Category</h1>
		</div>
	</div>

	<div class="row-pad"></div>

	<div class="row">
	    <div class="col-md-12">
			<form action="" method="post" accept-charset="utf-8">
				<div class="form-group">
					<label for='category'>Category</label>
					<input required="required" type="text" value="<?php echo set_value('category'); ?>" name="category" class="form-control">
					<?php echo form_error('category', '<p class="help-block">','</p>'); ?>
				</div>
				<?php
					if(!empty($success_msg)){
						echo '<p class="status-msg success">'.$success_msg.'</p>';
					}elseif(!empty($error_msg)){
						echo '<p class="alert alert-danger col-sm-12">'.$error_msg.'</p>';
					}
				?>
				<div class="form-group">
					<input type="submit" name="submit_category" class="btn btn-success" value="Submit">
				</div>
			</form>
		</div>
	</div>
</div>