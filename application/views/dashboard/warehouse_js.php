<script type="text/javascript">
	$(document).ready(function() {

		var lowstocks_whouse_datatable = $('#lowstocks-whouse-data-table').DataTable({
				"ajax": {
				   url : "<?= site_url('warehouse_inventories/lowstocks'); ?>",
				    type : 'GET'
				},
				"columnDefs": [
					{className: "dt-right", "targets": [-2, -3, -4] },
					{render: $.fn.dataTable.render.number( ',', '.', 0, '' ), "targets": [-2, -3, -4] },
					{"targets": -1, "data": null, "defaultContent": 
						"<a class=\'action-add\' data-mode=\'modal\' title=\'Add Stocks\'><i class=\'glyphicon glyphicon-plus\'></i></a>&nbsp; "},
					{"targets": [ 0, 1 ], "visible": false, "searchable": false}
				]
		});

		$('#lowstocks-whouse-data-table tbody').on( 'click', 'a.action-add', function (id) {
			var data = $("#lowstocks-whouse-data-table").DataTable().row( $(this).parents('tr') ).data();
	       	var item_id = data[1];
	       	window.location.replace('<?= site_url('warehouse_inventories/index') ?>' + '/' + item_id);
	    } );


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