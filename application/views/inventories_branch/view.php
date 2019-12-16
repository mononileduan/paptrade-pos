<div class="container">
    <div class="row">
	    <div class="col-md-12">
	    	<h1>Branch Inventory</h1>
			<table id="inventories-branch-table" class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<td>SKU</td>
						<td>Item</td>
						<td>Brand</td>
						<td>Category</td>
						<td>Unit Type</td>
						<td>Quantity</td>
						<td>Selling Price</td>
						<td>Warehouse PO Ref. No.</td>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	</div>
</div>

<script type="text/javascript" src="assets/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
	    $('#inventories-branch-table').DataTable({
	        "ajax": {
	            url : "<?php echo site_url("inventories_branch/inventories_branch_page") ?>",
	            type : 'GET'
	        },
	    });
	});
</script>