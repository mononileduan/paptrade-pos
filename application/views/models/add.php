<div class="content">
	<div class="row page-title">
		<div class="col-lg-12">
			<h1 class="page-header">Add Model</h1>
		</div>
	</div>

	<div class="row-pad"></div>

	<div class="row">
	    <div class="col-md-12">
			<form action="" method="post" accept-charset="utf-8">
				<div class="form-group">
					<label for='brand_id'>Brand</label>
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
					<?php echo form_error('brand_id', '<p class="help-block">','</p>'); ?>
				</div>
				<div class="form-group">
					<label for='model'>Model</label>
					<input required="required" type="text" value="<?php echo set_value('model'); ?>" name="model" class="form-control">
					<?php echo form_error('model', '<p class="help-block">','</p>'); ?>
				</div>
				<div class="form-group">
					<label for='category_id'>Category</label>
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
					<?php echo form_error('category_id', '<p class="help-block">','</p>'); ?>
				</div>
				<?php
					if(!empty($success_msg)){
						echo '<p class="status-msg success">'.$success_msg.'</p>';
					}elseif(!empty($error_msg)){
						echo '<p class="alert alert-danger col-sm-12">'.$error_msg.'</p>';
					}
				?>
				<div class="form-group">
					<input type="submit" name="submit_model" class="btn btn-success" value="Submit">
				</div>
			</form>
		</div>
	</div>
</div>