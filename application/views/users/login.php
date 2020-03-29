<!DOCTYPE html>
<html lang="en">
	<head>
		<title>POS & Inventory System</title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="base_url" content="<?= base_url();?><?= index_page();?>">
		<base href="<?= base_url();?><?= index_page();?>">
		<link rel="shortcut icon" type="image/x-icon" href="assets/images/paptrade-icon.png" />

	 	<link rel="stylesheet" type="text/css" href="assets/bootstrap/3.4.1/css/bootstrap.css">
	 	<link rel="stylesheet" type="text/css" href="assets/login/login.css">
	</head>
	<body>
		<div class="wrapper">
			<div class="container-fluid">

				<div class="top-logo-container col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
					<img class="top-logo" src="assets/login/images/paptrade.png">
					<h2><strong>POS & Inventory System</strong></h2>
				</div>


				<div class="login-box-container col-md-4 col-md-offset-4 col-sm-8 col-sm-offset-2">
				
					<div class="panel panel-primary">
						<div class="panel-heading">
							<div class="panel-title">Sign In</div>
							<!--div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="#">Forgot password?</a></div-->
						</div>     

						<div style="padding-top:30px" class="panel-body" >

							<form action="" method="post" id="loginform" class="form-horizontal" role="form">

								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
									<input id="login-username" type="text" class="form-control" name="username" value="" placeholder="username">
								</div>
								<div style="margin-bottom: 25px; font-size: x-small;" class="has-error">
									<?php echo form_error('username', '<p class="help-block">','</p>'); ?>
								</div>


								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
									<input id="login-password" type="password" class="form-control" name="password" placeholder="password">
								</div>
								<div style="margin-bottom: 25px; font-size: x-small;" class="has-error">
									<?php echo form_error('password', '<p class="help-block">','</p>'); ?>
								</div>

								<?php
									if(!empty($success_msg)){
										echo '<p class="status-msg success">'.$success_msg.'</p>';
									}elseif(!empty($error_msg)){
										echo '<p class="alert alert-danger col-sm-12">'.$error_msg.'</p>';
									}
								?>

								<div style="margin-top:10px" class="form-group">
									<div class="col-sm-12 controls">
										<input type="submit" name="loginSubmit" value="Login" class="btn btn-primary form-control">
									</div>
								</div>
							</form>
						</div>                     
					</div>  
				</div>

			</div>
		</div>
	</body>
</html>