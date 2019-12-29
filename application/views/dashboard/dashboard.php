	            <nav class="navbar navbar-expand-lg navbar-light bg-light">
	                <div class="container-fluid">

	                    <button type="button" id="sidebarCollapse" class="navbar-btn">
	                        <span></span>
	                        <span></span>
	                        <span></span>
	                    </button>
	                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
	                        <i class="fas fa-align-justify"></i>
	                    </button>
	                    <span style="margin-left: 30px;">
	                    	<img src="assets/images/paptrade-cropped.png" height="50px">
	                    </span> &nbsp;&nbsp;
	                    <h4><small>POS & Inventory System</small></h4>
	                    

	                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
	                        <ul class="nav navbar-nav ml-auto">
	                        	<li class="nav-item active">
	                                <span class="nav-link" 
	                                style="border-right: 1px solid #010101; margin-right: 10px; padding-right: 20px;">
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