<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Centralized Sales & Inventory System</title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<base href="<?= site_url() ?>">
		<link rel="shortcut icon" type="image/x-icon" href="assets/images/paptrade-icon.png" />

	 	<link rel="stylesheet" type="text/css" href="assets/bootstrap/3.4.1/css/bootstrap.css">
	 	<link rel="stylesheet" type="text/css" href="assets/datatables/datatables.min.css"/>
	    <link rel="stylesheet" type="text/css" href="assets/materialicons/material-icons.css">
	 	<link rel="stylesheet" type="text/css" href="assets/css/styles.css">
		
    	<script src="assets/jquery/3.4.1/jquery.min.js"></script>
	</head>

	<body>
		<div>

			<?php $this->load->view('components/navbar'); ?>
			
			<div class="container-fluid with-color-accent">
				<div class="row">
			        
			        <div class="col-sm-2 col-md-2">

			        </div>

			        <div class="col-sm-10 col-md-10" id="page-content">
			        	<h2 class="page-header"><i class="glyphicon glyphicon-warning-sign text-warning"></i>&nbsp; Access Denied</h2>
			            <div class="margin-left-20px">
				            <div class="row">
				            	<div div class="col-sm-12 col-md-12" id="content-container">
						           <p class="alert alert-danger col-sm-12"><i class="glyphicon glyphicon-exclamation-sign"></i>&nbsp; You are not authorized to view this page</p>
							    </div>
				            </div>
			            </div>
			        </div>
	    		</div>
	    	</div>
		</div>
		<script type="text/javascript" src="assets/js/page.height.setter.js"></script>
	</body>
</html>