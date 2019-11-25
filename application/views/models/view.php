<div class="container">
    <div class="row">
	    <div class="col-md-12">
	    	<h1>Models</h1>
			<table id="models-table" class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<td>Model</td>
						<td>Brand</td>
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
	    $('#models-table').DataTable({
	        "ajax": {
	            url : "<?php echo site_url("models/models_page") ?>",
	            type : 'GET'
	        },
	    });
	});
</script>