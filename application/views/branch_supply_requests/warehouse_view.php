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
					        echo '</tr>';
					        echo '<tr >';
					        echo '    <td colspan="6" class="hiddenRow"><div class="accordian-body collapse" id="hidden'.$ctr.'"> Dummy Content1 </div> </td>';
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