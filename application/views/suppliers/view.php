<div class="container">
    <div class="row">
	    <div class="col-md-12">
	    	<h1>Suppliers</h1>
			<table id="supplier-table" class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<td>Name</td>
						<td>Contact Person</td>
						<td>Address</td>
						<td>Contact No.</td>
						<td>Email</td>
						<td>Website</td>
						<td>Notes</td>
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
	    $('#supplier-table').DataTable({
	        "ajax": {
	            url : "<?php echo site_url("suppliers/suppliers_page") ?>",
	            type : 'GET'
	        },
	    });
	});
</script>