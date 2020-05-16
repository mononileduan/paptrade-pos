<div class="row">
	<div class="col-md-7">
		<div class="panel panel-default">
			<div class="panel-heading">
				<span class="panel-title">Low on Stocks</span>
			</div>
			<div class="panel-body">
				<table id="lowstocks-branch-data-table" class="table table-bordered table-striped table-hover" style="width:100%">
					<thead>
						<tr>
							<td>ID</td>
							<td>BRANCH</td>
							<td>ITEM_ID</td>
							<td width="50%">Item</td>
							<td width="20%">Critical No. of Stocks</td>
							<td width="20%">Available Stocks</td>
							<td width="10%">Action</td>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="col-md-5">
		<div class="panel panel-default">
			<div class="panel-heading">
				<span class="panel-title">Sales</span>
			</div>
			<div class="panel-body">
				<div class="row" style="margin-top: 20px; margin-bottom: 30px;">
					<div class="col-md-12">
						<label>Today <?= date('m/d/Y') ?></label>
						<table class="table" style="width:100%;">
							<tbody>
								<tr>
									<td width="40%" class="text-right">
										<label style="margin-bottom: 0px;">Transaction Count:&nbsp;</label>
									</td>
									<td width="60%">
										<span class="numeric"><?= $daily_sales_cnt ?></span>
									</td>
								</tr>
								<tr>
									<td width="40%" class="text-right">
										<label style="margin-bottom: 0px;">Total Sales:&nbsp;</label>
									</td>
									<td width="60%">
										<span class="ccy"><?= $daily_total_sales ?></span>
									</td>
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
	</div>
</div>