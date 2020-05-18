<script type="text/javascript">
	$(document).ready(function() {

		var lowstocks_branch_datatable = $('#lowstocks-branch-data-table').DataTable({
				"ajax": {
				   url : "<?= site_url('branch_inventories/lowstocks'); ?>",
				    type : 'GET'
				},
				"columnDefs": [
					{className: "dt-right", "targets": [-2, -3] },
					{render: $.fn.dataTable.render.number( ',', '.', 2, '' ), "targets": [-4] },
					{"targets": -1, "data": null, "orderable": false, "defaultContent": 
						"<a class=\'action-add\' data-mode=\'modal\' title=\'Add Supply Request\'><i class=\'glyphicon glyphicon-plus\'></i></a>&nbsp; "},
					{"targets": [ 0, 1, 2 ], "visible": false, "searchable": false}
				]
		});

		$('#lowstocks-branch-data-table tbody').on( 'click', 'a.action-add', function (id) {
			var data = $("#lowstocks-branch-data-table").DataTable().row( $(this).parents('tr') ).data();
	       	var item_id = data[2];
	       	window.location.replace('<?= site_url('supply_requests/add?item_id=') ?>' + item_id);
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