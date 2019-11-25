<div class="container">
    <div class="row">
	    <div class="col-md-12">
	    	<h1>Brands</h1>
			<table id="brands-table" class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<td>Brand</td>
						<td>Category</td>
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
	    $('#brands-table').DataTable({
	        "ajax": {
	            url : "<?php echo site_url("brands/brands_page") ?>",
	            type : 'GET'
	        },
	    });
	});
</script>