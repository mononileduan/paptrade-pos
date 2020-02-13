<style type="text/css">
	.table tr {
	    cursor: pointer;
	}
	.hiddenRow {
	    padding: 0 4px !important;
	    background-color: #eeeeee;
	    font-size: 14px;
	}
</style>
<div class="content">
	<div class="row page-title">
		<div class="col-lg-12">
			<h1 class="page-header">Branch Supply Requests</h1>
		</div>
	</div>

	<div class="row-pad"></div>

    <div class="row">
	    <div class="col-md-12">
	    	<table class="table table-condensed" style="border-collapse:collapse;">
			    <thead>
			        <tr>
			            <th>Item</th>
			            <th>Stocks</th>
			            <th>Unit</th>
			            <th></th>
			        </tr>
			    </thead>
			    <tbody>
					<?php
						$ctr = 0;

						foreach($items->result_array() as $r) {
							
							echo '<tr data-toggle="collapse" data-target="#hidden'.$ctr.'" class="accordion-toggle">';
					        echo '    <td>'.$r['ITEM'].'</td>';
					        echo '    <td>'.$r['STOCKS'].'</td>';
					        echo '    <td>'.$r['UNIT_TYPE'].'</td>';
					        echo '    <td></td>';
					        echo '</tr>';
					        echo '<tr >';
					        echo '    <td colspan="4" class="hiddenRow">';
					        echo '		<div class="accordian-body collapse" id="hidden'.$ctr.'" style="margin-left:100px;">';
					        echo '			<table class="table">';
					        echo '				<thead>';
					        echo '					<tr>';
					        echo '						<th>Branch</th>';
					        echo '						<th>Request Quantity</th>';
					        echo '						<th>Requested By</th>';
					        echo '						<th>Requested Date</th>';
					        echo '					</tr>';
					        echo '				<thead>';
					        echo '				<tbody>';
					        foreach ($requests[$r['ITEM_ID']] as $req) {
					        echo '					<tr>';
					        echo '    					<td>'.$req['branch'].'</td>';
					        echo '    					<td>'.$req['quantity'].'</td>';
					        echo '    					<td>'.$req['requested_by'].'</td>';
					        echo '    					<td>'.$req['requested_dt'].'</td>';
							echo '					</tr>';
					        }
					        echo '				<tbody>';
					        echo '			</table>';
					        echo '		</div> ';
					        echo '    </td>';
					        echo '</tr>';
					        $ctr++;
						}
					?>
			    </tbody>
			</table>
		</div>
	</div>
</div>
<script type="text/javascript">
	$('.accordian-body').on('show.bs.collapse', function () {
	    $(this).closest("table")
	        .find(".collapse.in")
	        .not(this)
	        //.collapse('toggle')
	})
</script>