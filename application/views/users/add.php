<div class="content">
	<div class="row page-title">
		<div class="col-lg-12">
			<h1 class="page-header">Add User</h1>
		</div>
	</div>

	<div class="row-pad"></div>

	<div class="row">
	    <div class="col-md-12">
			<form action="" method="post" accept-charset="utf-8">
				<div class="form-group">
					<label for='last_name'>Last Name</label>
					<input required="required" type="text" value="<?php echo set_value('last_name'); ?>" name="last_name" class="form-control">
					<?php echo form_error('last_name', '<p class="help-block">','</p>'); ?>
				</div>
				<div class="form-group">
					<label for='first_name'>First Name</label>
					<input required="required" type="text" value="<?php echo set_value('first_name'); ?>" name="first_name" class="form-control">
					<?php echo form_error('first_name', '<p class="help-block">','</p>'); ?>
				</div>
				<div class="form-group">
					<label for='branch_id'>Branch</label>
					<select required="required" name="branch_id" class="form-control">
						<option value=""></option>
						<?php foreach($branches->result_array() as $r) {
							if(set_value('branch_id') === $r['ID']){
								echo '<option value="'.$r['ID'].'" selected="selected">'.$r['BRANCH_NAME'].'</option>';
							}else{
								echo '<option value="'.$r['ID'].'">'.$r['BRANCH_NAME'].'</option>';
							}
						} ?>
					</select>
					<?php echo form_error('branch_id', '<p class="help-block">','</p>'); ?>
				</div>
				<div class="form-group">
					<label for='username'>Username</label>
					<input required="required" type="text" value="<?php echo set_value('username'); ?>" name="username" class="form-control">
					<?php echo form_error('username', '<p class="help-block">','</p>'); ?>
				</div>
				<div class="form-group">
					<label for='password'>Password</label>
					<input required="required" type="password" value="<?php echo set_value('password'); ?>" name="password" class="form-control">
					<?php echo form_error('password', '<p class="help-block">','</p>'); ?>
				</div>
				<div class="form-group">
					<label for='role'>Role</label>
					<select required="required" name="role" class="form-control">
						<option value=""></option>
						<option value="System Administrator">System Administrator</option>
						<option value="Branch Administrator">Branch Administrator</option>
						<option value="Cashier">Cashier</option>
					</select>
					<?php echo form_error('role', '<p class="help-block">','</p>'); ?>
				</div>
				<?php
					if(!empty($success_msg)){
						echo '<p class="status-msg success">'.$success_msg.'</p>';
					}elseif(!empty($error_msg)){
						echo '<p class="alert alert-danger col-sm-12">'.$error_msg.'</p>';
					}
				?>
				<div class="form-group">
					<input type="submit" name="submit_user" class="btn btn-success" value="Submit">
				</div>
			</form>
		</div>
	</div>
</div>