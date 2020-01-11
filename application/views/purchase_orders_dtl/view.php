<div class="content">
	<div class="row page-title">
		<div class="col-lg-12">
			<h1 class="page-header">Purchase Order</h1>
		</div>
	</div>

	<div class="row-pad"><hr/></div>

    <div class="row">
	    <div class="col-md-12">
			<div class="row">
				<div class="col-md-12">
					<label for='ref_no'>Reference No.</label>
					<p><?= $po['REF_NO']; ?></p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<label for='supplier'>Supplier</label>
					<p><?= $po['SUPPLIER_NAME']; ?></p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<label for='oredered_dt'>Order Date</label>
					<p><?= $po['ORDERED_DT']; ?></p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<label for='oredered_by'>Ordered By</label>
					<p><?= $po['ORDERED_BY']; ?></p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<label for='expected_dt'>Expected Date</label>
					<p><?= $po['EXPECTED_DT']; ?></p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<label for='status'>Status</label>
					<p><?= $po['STATUS']; ?></p>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<table class="table table-hover">
		    <thead>
		        <tr>
		            <th>Item</th>
		            <th class="text-right">Unit Price</th>
		            <th class="text-right">Quantity</th>
		            <th class="text-right">Price</th>
		        </tr>
		    </thead>
		    <tbody>
		    	<?php 
		    	$grandtotal = 0.00;
		    	foreach($po_items->result_array() as $r) {

					echo '<tr>';
					echo '	<td>';
					echo '		<span>'.$r['ITEM'].'</span>';
					echo '	</td>';
					echo '	<td class="text-right">';
					echo '		<span class="currency-php">'.$r['UNIT_PRICE'].'</span>';
					echo '	</td>';
					echo '	<td class="text-right">';
					echo '		<span>'.$r['QUANTITY'].'</span>';
					echo '	</td>';
					echo '	<td class="text-right">';
					echo '		<span class="currency-php">'.$r['QUANTITY']*$r['UNIT_PRICE'].'</span>';
					echo '	</td>';
					echo '</tr>';

					$grandtotal += $r['QUANTITY']*$r['UNIT_PRICE'];
		        } ?>
		    </tbody>
		    <tfoot>
		        <tr>
		            <th colspan="3" style="text-align: left;">
		                <span>Grand Total</span>
		            </th>
		            <th colspan="1" class="text-right">
		                <span class="currency-php"><?= $grandtotal; ?></span>
		            </th>
		        </tr>
		        <tr>
		        </tr>
		    </tfoot>
		</table>
	</div>

	<hr/>
	
	<a href="<?= base_url();?><?= index_page();?>/purchase_orders" class="btn btn-secondary">Back</a>
</div>