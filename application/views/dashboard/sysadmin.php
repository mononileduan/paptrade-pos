<div class="row">
	<div class="col-md-6">
		<h3>Low on Stocks</h3>

		<hr/>

		<div class="row">
			<div class="col-md-12">
				<h4><strong>Warehouse</strong></h4>
				<table id="lowstocks-whouse-data-table" class="table table-bordered table-striped table-hover" style="width:100%">
					<thead>
						<tr>
							<td>ID</td>
							<td>ITEM_ID</td>
							<td width="55%">Item</td>
							<td width="15%">Critical Stocks</td>
							<td width="15%">Current Stocks</td>
							<td width="15%">Available Stocks</td>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>

		<hr/>
		
		<div class="row">
			<div class="col-md-12">
				<h4><strong>Branch</strong></h4>
				<table id="lowstocks-branch-data-table" class="table table-bordered table-striped table-hover" style="width:100%">
					<thead>
						<tr>
							<td>ID</td>
							<td width="35%">BRANCH</td>
							<td>ITEM_ID</td>
							<td width="45%">Item</td>
							<td width="10%">Critical Stocks</td>
							<td width="10%">Available Stocks</td>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>

		<hr/>
		
	</div>

	<div class="col-md-6">
		<h3>Sales</h3>

		<hr/>
		
		<div class="row" style="margin-top: 20px; margin-bottom: 30px;">
			<div class="col-md-12">
				<label>Today <?= date('m/d/Y') ?></label>
				<table class="table" style="width:100%;">
					<tbody>
						<tr>
							<td width="30%" class="text-right">
								<label style="margin-bottom: 0px;">Transaction Count:&nbsp;</label>
							</td>
							<td width="70%">
								<span class="numeric"><?= $daily_sales_cnt ?></span>
							</td>
						</tr>
						<tr>
							<td width="30%" class="text-right">
								<label style="margin-bottom: 0px;">Total Sales:&nbsp;</label>
							</td>
							<td width="70%">
								<span class="ccy"><?= $daily_total_sales ?></span>
							</td>
						</tr>
						<tr>
							<td></td><td></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<label>Last 6 Months</label>
				<table id="salesreport-data-table" class="table table-bordered table-striped table-hover" style="width:100%">
					<thead>
						<tr>
							<th width="35%">Month</th>
							<th width="25%" class="text-right">Transaction Count</th>
							<th width="40%" class="text-right">Total Sales</th>
						</tr>
					</thead>
					<tbody>
						<?php
							if($sales_monthly->num_rows() > 0){
								foreach($sales_monthly->result_array() as $r){
									echo '<tr>';
									echo '	<td class="text-left"><span>'.$r['MONTH'].'</span></td>';
									echo '	<td class="text-right numeric">'.$r['CNT'].'</td>';
									echo '	<td class="text-right"><span class="ccy">'.$r['TOTAL'].'</span></td>';
									echo '</tr>';
								}
							}else{
								echo '<tr class="odd"><td valign="top" colspan="3" style="text-align: center;">No data available</td></tr>';
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>