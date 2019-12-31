<!DOCTYPE html>
<html lang="en">
	<head>
		<title>POS & Inventory System</title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<base href="<?= base_url();?>">
		<link rel="shortcut icon" type="image/x-icon" href="assets/images/iconpap.png" />
		
	    <link rel="stylesheet" type="text/css" href="assets/bootstrap/4.1.3/css/bootstrap.min.css">
	    <link rel="stylesheet" type="text/css" href="assets/fontawesome/5.12.0/css/fontawesome.min.css">
	    <link rel="stylesheet" href="assets/sidenav-style.css">
	</head>

	<body>
		<div class="wrapper">
			<?php $this->load->view('components/nav'); ?>
		
		    <!-- Page Content  -->
	        <div id="content-wrapper">
	        	<nav class="navbar navbar-expand-lg navbar-light bg-light">
	                <div class="container-fluid">

	                    <button type="button" id="sidebarCollapse" class="navbar-btn">
	                        <span></span>
	                        <span></span>
	                        <span></span>
	                    </button>
	                    <span style="margin-left: 30px;">
	                    	<img src="assets/images/paptrade-cropped.png" height="50px">
	                    </span> &nbsp;&nbsp;
	                    <h4><small>POS & Inventory System</small></h4>
	                    
						<button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
	                        <i class="fas fa-align-justify"></i>
	                    </button>

	                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
	                        <ul class="nav navbar-nav ml-auto">
	                        	<li class="nav-item active">
	                                <span class="nav-link" 
	                                style="margin-right: 50px; padding-right: 20px;">
	                                Hello, <?= $session_user; ?>! </span>
	                            </li>
	                            <li class="nav-item active">
	                                <a class="nav-link" href="<?= base_url();?><?= index_page();?>/users/dashboard">Home</a>
	                            </li>
	                            <li class="nav-item">
	                                <a class="nav-link" href="#">POS</a>
	                            </li>
	                            <li class="nav-item">
	                                <a class="nav-link" href="<?= base_url();?><?= index_page();?>/users/logout">Logout</a>
	                            </li>
	                        </ul>
	                    </div>
	                </div>
	            </nav>

