<div class="container">
    <div class="row">
	    <div class="col-md-12">
	    	<h1>Units of Measure</h1>
			<table id="measure-table" class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<td>Unit of Measure</td>
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
	    $('#measure-table').DataTable({
	        "ajax": {
	            url : "<?php echo site_url("measures/measures_page") ?>",
	            type : 'GET'
	        },
	    });
	});
</script>