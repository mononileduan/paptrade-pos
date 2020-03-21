$(document).ready(function() {
	var base_url = $("meta[name='base_url']").attr('content');

	$('#add-req-item-btn').on('click', function () {
	    var item_id = $('#add-req-item-container').find('select[name="item"]').val();
	    var item_dscp = $('#add-req-item-container').find('select[name="item"] option:selected').text();
		var qty = $('#add-req-item-container').find('input[name="qty"]').val();

		if(item_id == ''){
			alert('item');
		}else if(qty == ''){
			alert('qty');
		}else{
			if (itemExist(item_id, qty) == false) {
				$("#requests-tbl tbody").append(
				'<tr>' +
					'<input name="id" type="hidden" value="'+ item_id +'">' +
					'<td>'+ item_dscp +'</td>' +
					'<td><input name="qty" type="text" value="'+qty+'" class="quantity-box" size="5"></td>' +
					'<td><span class="remove" style="font-size:12px;"><i class="fa fa-trash" title="Remove"></i></span></td>' +
				'</tr>'
				);
			}
			$('#add-req-item-container').find('select[name="item"]').val('');
			$('#add-req-item-container').find('select[name="item"] option:selected').text('');
			$('#add-req-item-container').find('input[name="qty"]').val('');
		}
	});


	$("#requests-tbl").on('click', '.remove',function() {
		var row = $(this).parents('tr');
		row.remove();
	})


	$("#process-submit-request").submit(function(e) {
		e.preventDefault();
		var row = $("#requests-tbl tbody tr").length;
		var requests = [];
		if (row) {
			for (i = 0; i < row; i++) {
				var r = $("#requests-tbl tbody tr").eq(i).find('td');
				var quantity = r.eq(1).find('input').val();
				var arr = {
						item_id : $("#requests-tbl tbody tr").eq(i).find('input[name="id"]').val(), 
						quantity : quantity
					};
				requests.push(arr);
			}

			var data = {};
			data['process_requests'] = true;
			data['requests'] = requests;

			$.ajax({
				type : 'POST',
				data : data,
				url : base_url + '/supply_requests/process_add',
				success : function(data) { 
					if(data == 'OK'){
						$("#requests-tbl tbody").empty();
						$("#success_modal .modal-content .modal-body p.text-center").text("Successfully submitted request.");
						$("#success_modal").modal('show');
					}
				}
			})

			return;
		}
	})


	function itemExist(itemID, qty) {
		var table = $("#requests-tbl tbody tr");
	 	var exist = false;
		$.each(table, function(index) {
			id = ($(this).find('[name="id"]').val());
			if (id == itemID) {
				qtyCol = $(this).find('[name="qty"]');
				qtyCol.val(parseInt(qtyCol.val()) + parseInt(qty));
				exist = true;
			}
		})

		return exist;
	}


});