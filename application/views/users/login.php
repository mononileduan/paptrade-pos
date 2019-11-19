<div class="container">
	<h2>Login to your account</h2>

	<?php
		if(!empty($success_msg)){
			echo '<p class="status-msg success">'.$success_msg.'</p>';
		}elseif(!empty($error_msg)){
			echo '<p class="status-msg error">'.$error_msg.'</p>';
		}
	?>

	<div class="regisFrm">
		<form action="" method="post">
			<div class="form-group">
				<input type="text" name="username" placeholder="Username" required="">
				<?php echo form_error('username', '<p class="help-block">','</p>'); ?>
			</div>
			<div class="form-group">
				<input type="password" name="password" placeholder="Password" required="">
				<?php echo form_error('password', '<p class="help-block">','</p>'); ?>
			</div>
			<div class="send-button">
				<input type="submit" name="loginSubmit" value="LOGIN">
			</div>
		</form>
	</div>
</div>