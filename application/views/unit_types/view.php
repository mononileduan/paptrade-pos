<div class="container">
    <div class="row">
	    <div class="col-md-12">
	    	<h1>Unit Types</h1>
			<table id="unit-type-table" class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<td>Unit Type</td>
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
	    $('#unit-type-table').DataTable({
	        "ajax": {
	            url : "<?php echo site_url("unit_types/unit_types_page") ?>",
	            type : 'GET'
	        },
	    });
	});
</script>