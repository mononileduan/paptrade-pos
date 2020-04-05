$(document).ready(function() {
	var base_url = $("meta[name='base_url']").attr('content');
	var index_page = $("meta[name='index_page']").attr('content');
	var user = $("meta[name='user']").attr('content');


	var totalAmountDue = 0;

	var dHeight = parseInt($(document).height());
 	
	dHeight = dHeight - 60;
	$(".box-container").css('height', dHeight + 'px');
	$(".box-container").css('overflow-y', 'auto');
	$("#cart-container").css('min-height', (dHeight - (80 + 231 + 25)) + 'px');
	$("#cart-container").css('max-height', (dHeight - (80 + 150 + 231)) + 'px');


	var item_table = $('#item-table').DataTable({
        "ajax": {
            url : index_page + '/branch_inventories/pos_list',
            type : 'GET'
        },
        "columnDefs": [
        	{className: "dt-right", "targets": [-1, -2] },
        	{render: $.fn.dataTable.render.number( ',', '.', 2, '' ), "targets": [-1] },
        	{"targets": [ 0 ], "visible": false, "searchable": false}
        ]
    });


    $("#item-table").on('click', 'tbody tr', function(event) {
    	var data = $("#item-table").DataTable().row( $(this) ).data();
		var id = data[0];
		var item = data[1];
		var category = data[2];
		var stockCol = $(this).find('td').eq(2);
		var stocks = stockCol.text();
		var price = data[4];
		
	 	if ( parseInt(stocks.split(' ').join('')) > 0 ) {
	 		if (id && item && stocks && price) {
	  	 		if (itemExist(id,stocks) == false) {
		  	 		var quantity = 1;
					$("#cart tbody").append(
						'<tr>' +
							'<input name="id" type="hidden" value="'+ id +'">' +
							'<td>'+ item +'</td>' +
							'<td class="text-right">'+ thousands(price) +'</td>' +
							'<td class="text-right"><input data-stocks="'+stocks+'" data-remaining="'+stocks+'" data-id="'+id+'" name="qty" type="text" value="'+quantity+'" class="quantity-box text-right" size="5"></td>' +
							'<td class="text-right"></td>' +
							'<td><span class="remove" style="font-size:12px;"><i class="glyphicon glyphicon-trash" title="Remove"></i></span></td>' +
						'</tr>'
						);
					recount();
					$("payment").val('');
					$("change").val('');
		  	 	}

		  	 	stockCol.text(parseFloat(stocks - 1));

	  	 	}else{
	  	 		$("#error_modal .modal-content .modal-body p.text-center").text("Could not add item to cart");
	    		$("#error_modal").modal('show');
	  	 	}
	 	}else {
	 		$("#error_modal .modal-content .modal-body p.text-center").text("Not enough stocks remaining");
	    	$("#error_modal").modal('show');
	 	}
	});


	function itemExist(itemID,stocks) {
		var table = $("#cart-container tbody tr");
	 	var exist = false;
		$.each(table, function(index) {
			var id = ($(this).find('[name="id"]').val());
			if (id == itemID) {
				qtyCol = $(this).find('[name="qty"]');
				qty = parseInt(qtyCol.val());
				qtyCol.val(qty + 1);
		 		recount();
				exist = true;
			}
		});
		return exist;
	}


	function recount() {
		var row = $("#cart tbody tr").length;
		var total = 0;
		for (i = 0; i < row; i++) {
			var r = $("#cart tbody tr").eq(i).find('td');
			var price = r.eq(1).text().replace(',','');
			var quantity = parseFloat(r.eq(2).find('input').val());
			var subtotal = r.eq(3);
			var subtotalVal = parseFloat(price) * quantity;
			subtotal.text(thousands(subtotalVal.toFixed(2)));
			total += subtotalVal;
		}
		totalAmountDue = total;
		$("#amount-total").text(formatCurrencyVal(totalAmountDue));
	}


	$("#cart").on('click', '.remove',function() {
		var row = $(this).parents('tr');
		var remainingStocks = row.find('.quantity-box').data('stocks');
		var itemID = row.find('.quantity-box').data('id');
		calculateRemainingStocks(remainingStocks, itemID);
		row.remove();
		recount();
	});


	function calculateRemainingStocks(remaining, itemID) {
		var table = $("#item-table > tbody > tr");
		$.each(table, function(key, value) {
			var data = $("#item-table").DataTable().row( $(this) ).data();
			var id = data[0];
			var val = $(value);
			if (id == itemID) {
				return val.find('td').eq(2).text(remaining);
			} 
		});
	}


	$("#cart").on('focusout','.quantity-box',function(e) {
		var quantity = parseFloat($(this).val()); 
		if (isNaN(quantity) || quantity < 0) {
			$(this).val(1);
			calculateRemainingStocks($(this).data('stocks') - 1, $(this).data('id'))
			return quantity = 1; 
		}
	});

	$("#cart").on("blur focusout focus", ".quantity-box", function() {
		if ($(this).val() == "" || isNaN(parseInt($(this).val()))) {
			$(this).val(1);
			var quantity = parseInt(1);
			var currentStocks = $(this).data('stocks');
			var itemID = $(this).data('id'); 
			calculateRemainingStocks(currentStocks - quantity,itemID);
			return recount();
		}
	}); 

	$("#cart").on('input', '.quantity-box', function(e) {
 		if (e.which == 13) {
 			e.stopPropagation();
 			return false;
 		}
		var quantity = parseFloat($(this).val());
		var currentStocks = $(this).data('stocks');
		var itemID = $(this).data('id');
		var remaining = $(this).data('stocks') - quantity;
		$(this).data('remaining', remaining);
		if (isNaN(quantity) || quantity < 0) {
			return quantity = 1; 
		}
		if (!isNaN(quantity) && quantity != 0 || $(this).val() == "") {
			var row = $("#item-table").find('td').text() == itemID;
			if (quantity <= parseInt(currentStocks)) {
				var row = $(this).parents("tr");
				var priceCol = row.find('td').eq(2);
				var price = priceCol.text().substring(1);
				var subtotal = parseInt(quantity) * parseFloat(price);
				calculateRemainingStocks(remaining,itemID);
				return recount();
			}
			$("#error_modal .modal-content .modal-body p.text-center").text('Not enough stocks only ' + currentStocks + ' remaining.');
	    	$("#error_modal").modal('show');
			$(this).val(1);
			calculateRemainingStocks(currentStocks - 1,itemID);
			return recount();
		}
	});


	$("#payment").keyup(function() {
		var payment = parseFloat($(this).val());
		var cart = $("#cart tbody tr").length;
		if (cart) {
			var totalAmountDue = parseFloat($("#amount-total").text().substring(1).replace(',',''));
			if (payment >= totalAmountDue) {
				return $("#change").val(formatCurrencyVal((payment - totalAmountDue).toFixed(2)));
			}
			return $("#change").val('Insufficient Amount');
		} 
		return $(this).val('');
	});


	$("#process-form").submit(function(e) {
		e.preventDefault();
		var row = $("#cart tbody tr").length;
		var sales = [];
		var total_amount = 0;
		var payment = $("#payment").val();
		var change = $("#change").val().replace(',','');
 	 
 		if (row) {
			if (parseFloat(payment) >= parseFloat(totalAmountDue)) {
	 			for (i = 0; i < row; i++) {
					var r = $("#cart tbody tr").eq(i).find('td');
					var quantity = r.eq(2).find('input').val();
					var price = r.eq(1).text().replace(',','');
					var arr = {
							inventory_id : $("#cart tbody tr").eq(i).find('input[name="id"]').val(), 
							item : r.eq(0).text(),
							unit_price : price,
							quantity : quantity, 
							subtotal : parseFloat(price) * parseInt(quantity)
						};
					total_amount += parseFloat(price) * parseInt(quantity);
					sales.push(arr);
				}
				// Receipt Items
				$("#r-items-table tbody").empty();
				$.each(sales, function(key, value) {
					$("#r-items-table tbody").append(
						'<tr>' + 
							'<td>'+value.item +'</td>' +
							'<td class="text-right">'+formatCurrencyVal(value.unit_price) +'</td>' +
							'<td class="text-right">'+value.quantity+'</td>' +
							'<td class="text-right">'+formatCurrencyVal(value.subtotal)+'</td>' +
						'</tr>'
					);
				});

				var data = {};
				data['process_sales'] = true;
				data['grand_total'] = total_amount;
				data['sales'] = sales;
				$.ajax({
					type : 'POST',
					data : data,
					url : index_page + '/sales/add',
					beforeSend : function() {
						$("#btn").button('loading');
					},
					success : function(data) {
						if(data != ''){
							transactionComplete = true;
			 				var total = parseFloat(total_amount);
			 			 	var d = new Date();
			 				$("#payment-modal").modal('toggle');
							$("#loader").hide();
							//Transaction Summary 
							$("#summary-payment").text( formatCurrencyVal(payment));
							$("#summary-change").text( formatCurrencyVal(change.substring(1)));
							$("#summary-total").text( formatCurrencyVal(total_amount))
							
							//Fill In Receipt 
							$("#r-payment").text( formatCurrencyVal(payment));
							$("#r-change").text( formatCurrencyVal(change.substring(1)));
							$("#r-cashier").text(user); 
							$("#r-total-amount").text( formatCurrencyVal(total_amount))
							$("#r-id").text(data);
							$("#r-time").text(d.toLocaleTimeString());

						 	$("#cart tbody").empty();
						 	$("#payment").val('');
						 	$("#change").val('');
						 	$("#amount-due").text(''); 
						 	$("#amount-total").text('');

						 	item_table.ajax.reload();
						 	$("#btn").button('reset');
						 	totalAmountDue = 0;

						}else{
							$("#loader").hide();
						 	$("#btn").button('reset');
						 	$("#error_modal .modal-content .modal-body p.text-center").text('An error was encountered. Failed to save transaction.');
		    				$("#error_modal").modal('show');
						}
		 				
					}
				})
			}else{
				$("#error_modal .modal-content .modal-body p.text-center").text('Insufficient payment amount');
		    	$("#error_modal").modal('show');
			}
 		}else{
	 		$("#error_modal .modal-content .modal-body p.text-center").text('Please add some items');
	    	$("#error_modal").modal('show');
	    }
	});


	$("#print").click(function(){
		$("#receipt").print({
	        	globalStyles: true,
	        	mediaPrint: false,
	        	stylesheet: base_url + '/assets/pos/receipt.css',
	        	noPrintSelector: ".no-print",
	        	iframe: true,
	        	append: null,
	        	prepend: null,
	        	manuallyCopyFormValues: true,
	        	deferred: $.Deferred(),
	        	timeout: 500,
	        	title: 'Receipt',
	        	doctype: '<!doctype html>'
		});
	})



	function formatCurrency(ccy){
		var monetary_value = $(ccy).text();
	    var i = new Intl.NumberFormat('en-PH', { 
	        style: 'currency', 
	        currency: 'PHP' 
	    }).format(monetary_value); 
	    $(ccy).text(i); 
	}

	function formatCurrencyVal(money){
	    var i = new Intl.NumberFormat('en-PH', { 
	        style: 'currency', 
	        currency: 'PHP' 
	    }).format(money); 
	    return i;
	}

	function thousands(str){
	    return str.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}
});