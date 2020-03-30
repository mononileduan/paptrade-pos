<div class="col-sm-2 col-md-2">
	
	<div class="panel-group">
		<div class="panel panel-default">
			<div class="panel-body login-info-panel">
				<table class="table login-info-table">
					<tr>
						<td>
							<small><span class="glyphicon glyphicon-user"></span>&nbsp;<?=$this->session->userdata('fullname')?></small>
						</td>
					</tr>
					<tr>
						<td>
							<small><span class="glyphicon glyphicon-briefcase"></span>&nbsp;<?=$this->session->userdata('user_role_dscp')?></small>
						</td>
					</tr>
					<tr>
						<td>
							<small><span class="glyphicon glyphicon-map-marker"></span>&nbsp;<?=$this->session->userdata('branch')?></small>
						</td>
					</tr>
					<tr>
						<td>
							<small><span class="glyphicon glyphicon-calendar"></span>&nbsp;<?=date($this->session->userdata('last_login_dt'))?></small>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
    
    <div class="panel-group" id="accordion">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">
					<a href="<?=index_page()?>/users/index"><span class="glyphicon glyphicon-dashboard"></span>&nbsp;Dashboard</a>
				</h4>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">
					<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"><span class="glyphicon glyphicon-wrench"></span>&nbsp;Maintenance</a>
				</h4>
			</div>
			<div id="collapseOne" class="panel-collapse collapse">
				<div class="panel-body">
					<table class="table">
						<tr>
							<td>
								<a href="<?=index_page()?>/brands">Brand</a>
							</td>
						</tr>
						<tr>
							<td>
								<a href="<?=index_page()?>/categories">Category</a>
							</td>
						</tr>
						<tr>
							<td>
								<a href="<?=index_page()?>/stock_types">Stock Type</a>
							</td>
						</tr>
						<tr>
							<td>
								<a href="<?=index_page()?>/items">Item</a>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">
					<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"><span class="glyphicon glyphicon-map-marker"></span>&nbsp;Branch</a>
				</h4>
			</div>
			<div id="collapseTwo" class="panel-collapse collapse">
				<div class="panel-body">
					<table class="table">
						<tr>
							<td>
								<a href="">Inventory</a>
							</td>
						</tr>
						<tr>
							<td>
								<a href="">Supply Request</a>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">
					<a data-toggle="collapse" data-parent="#accordion" href="#collapseThree"><span class="glyphicon glyphicon-list-alt"></span>&nbsp;Warehouse</a>
				</h4>
			</div>
			<div id="collapseThree" class="panel-collapse collapse">
				<div class="panel-body">
					<table class="table">
						<tr>
							<td>
								<a href="<?=index_page()?>/warehouse_inventories">Inventory</a>
							</td>
						</tr>
						<tr>
							<td>
								<a href="">Supply Request</a>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">
					<a data-toggle="collapse" data-parent="#accordion" href="#collapseFour"><span class="glyphicon glyphicon-file"></span>&nbsp;Reports</a>
				</h4>
			</div>
			<div id="collapseFour" class="panel-collapse collapse">
				<div class="panel-body">
					<table class="table">
						<tr>
							<td>
								<span class="glyphicon glyphicon-usd"></span><a href="">&nbsp;Sales</a>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">
					<a data-toggle="collapse" data-parent="#accordion" href="#collapseFive"><span class="glyphicon glyphicon-cog"></span>&nbsp;Administration</a>
				</h4>
			</div>
			<div id="collapseFive" class="panel-collapse collapse">
				<div class="panel-body">
					<table class="table">
						<tr>
							<td>
								<a href="">Branch</a>
							</td>
						</tr>
						<tr>
							<td>
								<a href="">User</a>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">
					<a data-toggle="collapse" data-parent="#accordion" href="#collapseSix"><span class="glyphicon glyphicon-user"></span>&nbsp;Account</a>
				</h4>
			</div>
			<div id="collapseSix" class="panel-collapse collapse">
				<div class="panel-body">
					<table class="table">
						<tr>
							<td>
								<a href="">Change Password</a>
							</td>
						</tr>
						<tr>
							<td>
								<a href="">Logout</a>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>

</div>


