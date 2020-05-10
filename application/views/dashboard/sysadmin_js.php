<script type="text/javascript">
	$(document).ready(function() {

		var lowstocks_whouse_datatable = $('#lowstocks-whouse-data-table').DataTable({
				"ajax": {
				   url : "<?= site_url('warehouse_inventories/lowstocks'); ?>",
				    type : 'GET'
				},
				"columnDefs": [
					{className: "dt-right", "targets": [-1, -2, -3] },
					{render: $.fn.dataTable.render.number( ',', '.', 0, '' ), "targets": [-2, -3, -4] },
					{"targets": [ 0, 1 ], "visible": false, "searchable": false}
				]
		});


		var lowstocks_branch_datatable = $('#lowstocks-branch-data-table').DataTable({
				"ajax": {
				   url : "<?= site_url('branch_inventories/lowstocks'); ?>",
				    type : 'GET'
				},
				"columnDefs": [
					{className: "dt-right", "targets": [-2, -1] },
					{render: $.fn.dataTable.render.number( ',', '.', 0, '' ), "targets": [-1, -2] },
					{"targets": [ 0, 2 ], "visible": false, "searchable": false}
				]
		});


		function formatCurrency(ccy){
			var monetary_value = $(ccy).text();
		    var i = new Intl.NumberFormat('en-PH', { 
		        style: 'currency', 
		        currency: 'PHP' 
		    }).format(monetary_value); 
		    $(ccy).text(i); 
		}

		function thousands(str){
		    return str.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
		}


		$('.ccy').each(function(){
			formatCurrency($(this));
		});

		$('.numeric').each(function(){
			thousands($(this));
		});

	});
</script>