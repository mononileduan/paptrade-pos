$(document).ready(function() {
	var base_url = $("meta[name='base_url']").attr('content');
	var csrfName = $("meta[name='csrfName']").attr('content');
	var csrfHash = $("meta[name='csrfHash']").attr('content');
	var license = $("meta[name='license']").attr('content');
	var totalAmountDue = 0;
	var totalDiscount = 0;
	var transactionComplete = false;
	var currency = 'â‚±';

	var dHeight = parseInt($(document).height());
 	
	dHeight = dHeight - 60;
	$(".header .box").css('height', dHeight + 'px');
	$(".header .box").css('overflow-y', 'auto');
	$("#cart-tbl").css('min-height', (dHeight - (80 + 231 + 25)) + 'px');
	$("#cart-tbl").css('max-height', (dHeight - (80 + 150 + 231)) + 'px');

	/*window.addEventListener('selectstart', function(e){ e.preventDefault(); });
	$(document).pos();
	$(document).on('scan.pos.barcode', function(event){
		if (license === "silver" || license === "gold") {
			if (event.code.length > 5) {
				data = {};
				data[csrfName] = csrfHash;
				data['code'] = event.code;
			
				$.ajax({
					type : 'POST',
					url : base_url + 'items/find',
					data : data,
					success : function(data) {
						if (data) {
							var result = JSON.parse(data);
							var quantity = 1;
						 	var subtotal = parseInt(quantity) * parseFloat($("#price").text().substring(1));
						 	totalAmountDue += parseFloat(subtotal);

						 	if ( parseInt(result.quantity) > 0 ) {
						 		 
					  	 		if (itemExist(result.id,result.quantity) == false) {
						  	 		var quantity = 1;
								 	var subtotal = parseInt(result.quantity) * parseFloat($("#price").text().substring(1));
								 	totalAmountDue += parseFloat(result.subtotal);
									$("#cart tbody").append(
											'<tr>' +
												'<input name="id" type="hidden" value="'+ result.id +'">' +
												'<td>'+ result.name +'</td>' +
												'<td><input data-stocks="'+result.quantity+'" data-remaining="'+result.quantity+'" data-id="'+result.id+'" name="qty" type="text" value="'+quantity+'" class="quantity-box"></td>' +
												'<td> <input type="text" value="0" placeholder="Discount" name="discount" class="discount-input"></td>' +
												'<td>'+ result.price +'</td>' +
									 			
												'<td><span class="remove" style="font-size:12px;"><i class="fa fa-trash" title="Remove"></i></span></td>' +
											'</tr>'
										);
									recount();
									$("payment").val('');
									$("change").val('');

						  	 	}
						  	 	stockCol.text(parseInt(stocks - 1));
						  	  
						 	}else {
						 		alert("Not enough stocks remaining");
						 	}
				 

							recount();
							$("payment").val('');
							$("change").val('');
						}else 
							alert('No item found in the database');
					 
					}
				})
			}
		} else {
			alert("Your license does not support Barcode Feature, Upgrade Now!");
		}
	}); */
	
	//data = {};
	//data[csrfName] = csrfHash;
	var item_table = $('#item-table').DataTable({
        "ajax": {
            url : base_url + '/inventories_branch/inventories_branch_page',
            type : 'GET'
        },
        "columnDefs": [{
        	className: "dt-right",
        	"targets": [-1, -2]
        }]
        
    });
	

	$("#item-table").on('click', 'tbody tr', function(event) {
		var id = $(this).find('td').eq(0).text();
		var name = $(this).find('td').eq(1).text();
		var category = $(this).find('td').eq(2).text();
		var stockCol = $(this).find('td').eq(3);
		var stocks = stockCol.text();
		var price = $(this).find('td').eq(4).text();
		
	 	if ( parseInt(stocks.split(' ').join('')) > 0 ) {
	 		if (id && name && stocks && price) {
	  	 		if (itemExist(id,stocks) == false) {
		  	 		var quantity = 1;
				 	var subtotal = parseInt(quantity) * parseFloat(price);
				 	totalAmountDue += parseFloat(subtotal);
					$("#cart tbody").append(
						'<tr>' +
							'<input name="id" type="hidden" value="'+ id +'">' +
							'<td>'+ name +'</td>' +
							'<td>'+ price +'</td>' +
							'<td><input data-stocks="'+stocks+'" data-remaining="'+stocks+'" data-id="'+id+'" name="qty" type="text" value="'+quantity+'" class="quantity-box" size="5"></td>' +
							/*'<td> <input type="text" value="0" placeholder="Discount" name="discount" class="discount-input"></td>' +*/
							'<td>'+ subtotal.toFixed(2) +'</td>' +
				 			
							'<td><span class="remove" style="font-size:12px;"><i class="fa fa-trash" title="Remove"></i></span></td>' +
						'</tr>'
						);
					recount();
					$("payment").val('');
					$("change").val('');
		  	 	}
		  	 	stockCol.text(parseFloat(stocks - 1));
	  	 	}
	 	}else {
	 		alert("Not enough stocks remaining");
	 	}
  	 	
		
	})

	function itemExist(itemID,stocks) {
		var table = $("#cart-tbl tbody tr");
	 	var exist = false;
		$.each(table, function(index) {
			id = ($(this).find('[name="id"]').val());
			if (id == itemID) {
				qtyCol = $(this).find('[name="qty"]');
				qty = parseInt(qtyCol.val());

				qtyCol.val(qty + 1);
		 		recount();
				 
				
				exist = true;

			}
		})

		return exist;
	}

	$("#process-form").submit(function(e) {
		e.preventDefault();
		var row = $("#cart tbody tr").length;
		var sales = [];
		var customer_id = $("#customer-id").val();
		var total_amount = 0;
		// var discount = $("#amount-discount").text();
		var payment = $("#payment").val();
		var change = $("#change").val();
		var sales_on_hold_id = $("#sales_on_hold_id").val();
 	 
 		if (row) {
 			var totalAmountDue = parseFloat($("#amount-total").text().substring(1).replace(',',''));
	 
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
							/*discount : $("#cart tbody tr").eq(i).find('input[name="discount"]').val()*/
						};
					total_amount += parseFloat(price) * parseInt(quantity);
					sales.push(arr);
				}

				total_amount -= totalDiscount;
				// Receipt Items
				$("#r-items-table tbody").empty();
				$.each(sales, function(key, value) {
			 	 
					$("#r-items-table tbody").append(
							'<tr>' + 
								'<td>'+value.item +'</td>' +
								'<td class="amount">'+formatCurrencyVal(value.unit_price) +'</td>' +
								'<td class="amount">'+value.quantity+'</td>' +
								'<td class="amount">'+formatCurrencyVal(value.subtotal)+'</td>' +
							'</tr>'
						);
				});


				var data = {};
				data['process_sales'] = true;
				data['grand_total'] = total_amount;
				data['sales_on_hold_id'] = sales_on_hold_id;
				data['sales'] = sales;
				$.ajax({
					type : 'POST',
					data : data,
					url : base_url + '/sales/add',
					/*beforeSend : function() {
						$("#btn").button('loading');
					},*/
					success : function(data) { 
		 				transactionComplete = true;
		 				var total = parseFloat(total_amount);
		 			 	var d = new Date();
		 				$("#payment-modal").modal('toggle');
						$("#loader").hide();
						//Transaction Summary 
		
						$("#summary-payment").text( formatCurrencyVal(payment));
						$("#summary-change").text( formatCurrencyVal(change.substring(1)));
					 	$("#summary-discount").text( formatCurrencyVal(totalDiscount));
						$("#summary-total").text( formatCurrencyVal(total_amount) )
						
						//Fill In Receipt 
						$("#r-payment").text( formatCurrencyVal(payment));
						$("#r-change").text( formatCurrencyVal(change.substring(1)));
						$("#r-cashier").text($("#user").text()); 
						$("#r-total-amount").text( formatCurrencyVal(total_amount) )
						$("#r-discount").text(formatCurrencyVal(totalDiscount));
						$("#r-id").text(data);
						$("#r-time").text(d.toLocaleTimeString());

					 	$("#cart tbody").empty();
					 	$("#payment").val('');
					 	$("#change").val('');
					 	$("#amount-due").text(''); 
					 	$("#amount-total").text('');
					 	$("#amount-discount").text('');

					 	item_table.DataTable().clear().draw();
					 	$("#btn").button('reset');
					 	totalAmountDue = 0;  
						totalDiscount = 0
					 	
					}
				})
				return;
			}  
			
			return alert("Insufficient Amount");
 		}
 		
 		return alert('Please add some items');
 		
		
	})

	$("#btn-save").on('click', function(){
		var row = $("#cart tbody tr").length;
		if (row) {
			$("#customer-name-modal").modal('toggle');
		}else{
			alert('Please add some items');
		}
	});

	var pending_sales_table = $('#pending-sales').DataTable({
        "ajax": {
            url : base_url + '/sales_on_hold/sales_on_hold_page',
            type : 'GET'
        },
        "columnDefs": [{
        	className: "dt-right",
        	"targets": [-1, -2]
        }]
        
    });

	$("#btn-view-saved").on('click', function(){
		$("#pending-sales-modal").modal('toggle');
		pending_sales_table.DataTable().clear().draw();
	});

	$("#pending-sales").on('click', 'tbody tr', function(event) {
		var customer_name = $(this).find('td').eq(0).text();
		var grand_total = $(this).find('td').eq(1).text();
		var sales_on_hold_id = null;

		$.getJSON(base_url + '/sales_on_hold_dtls/sales_on_hold_dtls_page/'+customer_name, function(data) {

	        for(i = 0; i < data.recordsFiltered; i++){
				var id = data.data[i][0];
				var name = data.data[i][1];
				var price = data.data[i][2];
				var quantity = data.data[i][3];
				var subtotal = data.data[i][4];
				var stocks= data.data[i][5];
				sales_on_hold_id = data.data[i][6];

				if (stocks >= quantity) {
					var subtotal = parseInt(quantity) * parseFloat(price);
					totalAmountDue += parseFloat(subtotal);
					$("#cart tbody").append(
						'<tr>' +
							'<input name="id" type="hidden" value="'+ id +'">' +
							'<td>'+ name +'</td>' +
							'<td>'+ price +'</td>' +
							'<td><input data-stocks="'+stocks+'" data-remaining="'+stocks+'" data-id="'+id+'" name="qty" type="text" value="'+quantity+'" class="quantity-box" size="5"></td>' +
							/*'<td> <input type="text" value="0" placeholder="Discount" name="discount" class="discount-input"></td>' +*/
							'<td>'+ subtotal.toFixed(2) +'</td>' +
							
							'<td><span class="remove" style="font-size:12px;"><i class="fa fa-trash" title="Remove"></i></span></td>' +
						'</tr>'
						);
					recount();
					$("payment").val('');
					$("change").val('');
				}

				item_table.rows().every( function () {
				    var d = this.data();
				    if(d[0] == id){
					    d[3] = d[3] - quantity; // update data source for the row
					    this.invalidate(); // invalidate the data DataTables has cached for this row
					}
				} );
				item_table.draw();
			}
			$("#sales_on_hold_id").val(sales_on_hold_id);
			
	        
	    });
		
		$("#pending-sales-modal").modal('toggle');
	})



	$("#customer-name-confirm-btn").on('click', function(){
		var customer_name = $("#customer_name").val();
		if(customer_name){
			var row = $("#cart tbody tr").length;
			var sales = [];
			var total_amount = 0;
			if (row) {
	 			var totalAmountDue = parseFloat($("#amount-total").text().substring(1).replace(',',''));
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

				var data = {};
					data['save_sales_on_hold'] = true;
					data['customer_name'] = customer_name;
					data['grand_total'] = total_amount;
					data['sales'] = sales;
					$.ajax({
						type : 'POST',
						data : data,
						url : base_url + '/sales_on_hold/add',
						success : function(data) { 
							if(data == 'OK'){
								alert("Sales on hold for customer " + customer_name);
								$("#customer-name-modal").modal('toggle');
				 				$("#cart tbody").empty();
							 	$("#payment").val('');
							 	$("#change").val('');
							 	$("#amount-due").text(''); 
							 	$("#amount-total").text('');
							 	$("#amount-discount").text('');

							 	item_table.DataTable().clear().draw();
							 	$("#btn").button('reset');
							 	totalAmountDue = 0;  
								totalDiscount = 0
							
							}else{
								alert(data);
							}
			 				
						}
					})
			}
		}else{
			alert("Customer Name is required");
		}
		
	});


	$('#customer-name-modal').on('hidden.bs.modal', function (e) {
	  $(this)
	    .find("input,textarea,select")
	       .val('')
	       .end()
	    .find("input[type=checkbox], input[type=radio]")
	       .prop("checked", "")
	       .end();
	})


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
		 

	})

	$("#cart").on('click', '.remove',function() {
		var row = $(this).parents('tr');
		var remainingStocks = row.find('.quantity-box').data('stocks');
		var itemID = row.find('.quantity-box').data('id');
		calculateRemainingStocks(remainingStocks, itemID);
		row.remove();
		recount();
	})

	$("#cart").on('input, change, keyup', '.discount-input', function(e) {
		if (e.which == 13) {
			e.stopPropagation();
			e.preventDefault();
			return false;
		}

		var row = $(this).parents('tr');

		var total = parseInt(row.find('input[name="qty"]').val()) * parseFloat(row.find('td').eq(3).text().substring(1).replace(',',''));
		var discount = parseInt($(this).val());
	 
		if (discount != "") {
	 
			if (total <= discount) {
				alert('Discount cannot be greater or equal than the item total value');
				$(this).val(0);
			} 

			recount();

		}else {
			$(this).val('');
		}

	})

	$("#cart").on('focusout','.quantity-box',function(e) {
		var quantity = parseFloat($(this).val()); 
		if (isNaN(quantity) || quantity < 0) {
			$(this).val(1);
		 
			calculateRemainingStocks($(this).data('stocks') - 1, $(this).data('id'))
			return quantity = 1; 
		}
	})

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
			
			alert('Not enough stocks only ' + currentStocks + ' remaining.');
			$(this).val(1);
			calculateRemainingStocks(currentStocks - 1,itemID);
			return recount();
		}

		
	})


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


	/*
		1. Accepts Two Arguments
			A. The remaining stocks from Quantity Box Data
			B. The Item ID
		2. Find the item with ID in the table and update the remaining Quantity
	*/
	function calculateRemainingStocks(remaining, itemID) {
		var table = $("#item-table > tbody > tr");
		$.each(table, function(key, value) {
			var val = $(value);
			var id = val.find('td').eq(0).text();
			if (id == itemID) {
				return val.find('td').eq(3).text(remaining);
			} 
		});
	}


	/*
		Function Loop through the cart table
		To calculate the total amount
	*/
	function recount() {
		var row = $("#cart tbody tr").length;
		var total = 0;
		var discountAmount = 0;

		for (i = 0; i < row; i++) {
			var r = $("#cart tbody tr").eq(i).find('td');
			var price = r.eq(1).text().replace(',','');
			var quantity = parseFloat(r.eq(2).find('input').val());
			//var discount = parseInt(r.eq(2).find('input').val());

			var subtotal = r.eq(3);

			total += parseFloat(price) * quantity;

			//discountAmount += isNaN(discount) == true ? 0 : discount ;
			subtotal.text(total.toFixed(2));
		}
		//totalDiscount = discountAmount;
		totalAmountDue = total - discountAmount;
		
		//$("#amount-discount").text(currency + totalDiscount.toFixed(2));
		$("#amount-total").text(formatCurrencyVal(totalAmountDue));
	}

 

	$("#print").click(function(){
		$("#receipt").print({
	        	globalStyles: true,
	        	mediaPrint: false,
	        	stylesheet: base_url + 'assets/receipt.css',
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


})

 

function number_format(number, decimals, dec_point, thousands_point) {

    if (number == null || !isFinite(number)) {
        throw new TypeError("number is not valid");
    }

    if (!decimals) {
        var len = number.toString().split('.').length;
        decimals = len > 1 ? len : 0;
    }

    if (!dec_point) {
        dec_point = '.';
    }

    if (!thousands_point) {
        thousands_point = ',';
    }

    number = parseFloat(number).toFixed(decimals);

    number = number.replace(".", dec_point);

    var splitNum = number.split(dec_point);
    splitNum[0] = splitNum[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousands_point);
    number = splitNum.join(dec_point);

    return number;
}