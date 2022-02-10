<script>
	//============= plublic variable for discount function ===================//
	var glbGrandTotal = 0;
	var glbDiscPercent = 0;
	var glbDiscMoney = 0;
	var glbTotalAfterDisc = 0;

	//============= plublic variable for numeral modal ===================//
	var glbItemId;
	var glbItemPrice;
	var glbQtyEntry = '0';
	var glbMdType;

	//============= plublic variable for payments modal ===================//
	var glbDocNo;
	var glbMoneyEntry = 0;
	var glbPaymt;

	//============================== general ================================//
	$(document).ready(function() {
		getItems();
		getDocNo();
	});

	function getDocNo() {
		$.getJSON("<?= site_url('TransController/FetchDocNo') ?>", function(data) {
			$('#docNo').text(data.DocNo);
			glbDocNo = data.DocNo;
		});
	}
	//============================== end ================================//


	//================== search item from database by keyword ==================//
	$(function() {
		$('#searchItem').keyup(function() {
			clearTimeout($.data(this, 'timer'));
			var wait = setTimeout(getItems, 100);
			$(this).data('timer', wait);
		});
	});

	$(function() {
		$('#searchByBarcode').bind("enterKey", function(e) {
			getItemByBarcode();
		});
	});

	$(function() {
		$('#searchByBarcode').keyup(function(e) {
			if (e.keyCode == 13) {
				$(this).trigger("enterKey");
			}
		});
	});
	//======================================== end ============================================//


	//========================== select item from database and loop show on the box ====================//
	function getItemByBarcode() {
		var params = {
			barcode: $('#searchByBarcode').val()
		}

		$.ajax({
			method: 'POST',
			url: "<?= site_url('ItemController/FetchItemByBarcode') ?>",
			data: $.param(params),
			dataType: 'JSON'
		}).done(function(data) {
			if (!$.isEmptyObject(data)) {
				$.each(data, function(i, val) {
					addItemSales(val.ItemID, val.ItemName, val.ItemPrice, 1);
				});
			}
		}).fail(function(jqHRX, textStatus, errorThrown) {
			smkAlert('Something went wrong, please contact IT!', 'danger');
		});
	}

	function getItems() {
		var params = {
			groupId: $('#itemGroupId').val(),
			itemData: $('#searchItem').val()
		}

		$.ajax({
			method: 'POST',
			url: "<?= site_url('ItemController/FetchItemByItemGroup') ?>",
			data: $.param(params),
			dataType: 'JSON'
		}).done(function(data) {
			$('#itemList').html('');

			if (!$.isEmptyObject(data)) {
				$.each(data, function(i, val) {
					var objs = {
						itemId: val.ItemID,
						itemName: val.ItemName,
						dispPrice: numeral(val.ItemPrice).format('0,0.00'),
						valPrice: val.ItemPrice
					}

					itemAppending(objs);
				});
			}
		}).fail(function(jqHRX, textStatus, errorThrown) {
			smkAlert('Something went wrong, please contact IT!', 'danger');
		});
	}

	var ItemTempl = [
		"<div class='row mt-2 hand' onclick='addItemSales({{itemId}}, \"{{itemName}}\", {{valPrice}}, 0);'>",
		"<div class='media'>",
		"<div class='media-body ml-4'>",
		"<h6 class='m-0 text-truncate' title='{{itemName}}' style='max-width: 240px; mix-width: 150px'>{{itemName}}</h6>",
		"<small>{{dispPrice}}</small>",
		"<hr class='m-0'>",
		"</div>",
		"</div>",
		"</div>"
	].join("\n");

	function itemAppending(data) {
		var html = Mustache.render(ItemTempl, data);
		$('#itemList').append(html);
	}
	//=================================== end =================================//


	//=================================== add items for sales =================================//
	function addItemSales(itemId, itemName, valPrice, textBoxType) {
		var objs = {
			itemId: itemId,
			itemName: itemName,
			dispPrice: numeral(valPrice).format('0,0.00'),
			valPrice: valPrice
		}

		var html = Mustache.render(itemSalesTmpl, objs);
		var filterUniqueItem = $('#itemSales tr[id=item_' + itemId + ']').length;

		if (filterUniqueItem >= 1) {
			var currentQty = parseInt($('#itemSales tr[id=item_' + itemId + ']').find('td').eq(2).find('u').text());
			var currentPrice = parseFloat($('#itemSales tr[id=item_' + itemId + '] td').eq(1).data('item-price'));
			var newQty = parseInt(currentQty + 1);
			var totalPrice = currentPrice * newQty;

			$('#itemSales tr[id=item_' + itemId + '] u').text(newQty);
			$('#itemSales tr[id=item_' + itemId + '] td').eq(1).text(numeral(totalPrice).format('0,0.00'));
		} else {
			$('#itemSales').append(html);
		}

		if (textBoxType == 0) {
			$('#searchItem').val('').focus();
		} else {
			$('#searchByBarcode').val('').focus();
		}


		discount();
	}

	var itemSalesTmpl = [
		'<tr id="item_{{itemId}}">',
		'<td class="text-truncate" style="max-width: 90px;" title="{{itemName}}" data-item-code="{{itemId}}">{{itemName}}</td>',
		'<td class="text-center" data-item-price="{{valPrice}}">{{dispPrice}}</td>',
		'<td class="text-center text-nowrap hand" data-toggle="modal" data-target="#numeralModal" data-btn="qty" data-item-code="{{itemId}}">',
		'x <span class="font-weight-bold text-primary"><u>1</u></span></td>',
		'<td clas="text-center">',
		'<button onclick="removeOneItem();" class="btn btn-danger btn-sm del-item"><i class="fas fa-times"></i></button>',
		'</td>',
		'</tr>'
	].join("\n");
	//========================================== end ========================================//


	//=========================== remove one and all item from the list on selling panel ============//
	function removeOneItem() {
		$('#itemSales').on('click', '.del-item', function() {
			$(this).closest('tr').remove();
			var isEmptyItemSales = $('#itemSales tr').length;

			if (isEmptyItemSales <= 0) {
				resetSelling();
			}

			discount();
		});
	}

	function removeAllItem() {
		$('#itemSales tr').remove();
		$('#grandTotal').addClass('d-none').text(0);

		resetSelling();
	}

	function resetSelling() {
		$('#discTotal').text(0);
		$('#empInfo').text('').attr('title', '');
		$('#grandTotalAfterDisc').text('0.00');
		$('#grandTotal').addClass('d-none');

		glbDiscMoney = 0;
		glbDiscPercent = 0;
	}
	//======================================== end ========================================//


	//=========================== update grand total from any event changed ============//
	function getGrandTotal() {
		var itemTotalPrice = 0;

		$('#itemSales').find('tr').each(
			function() {
				var priceFormat = $(this).find('td').eq(1).text().replace(/,/g, '');
				itemTotalPrice += parseFloat(priceFormat);
			}
		);

		$('#grandTotalAfterDisc').text(numeral(itemTotalPrice).format('0,0.00'));

		return itemTotalPrice;
	}
	//==================================== end ========================================//


	//=================================== numeral modal on show and hide =================================//
	$(function() {
		$('#numeralModal').on('show.bs.modal keydown', function(e) {
			var related = $(e.relatedTarget);
			var current = $(this);
			var itemId = related.data('item-code');

			glbMdType = related.data('btn');

			if (glbMdType === 'qty') {
				var getQty = parseInt($('#itemSales tr[id=item_' + itemId + '] u').text());
				var valPrice = parseFloat($('#itemSales tr[id=item_' + itemId + '] td').eq(1).data('item-price'));

				current.find('.header-title').text('Quantity');
				glbItemId = itemId;
				glbItemPrice = valPrice;

				updateNumberScreen(getQty);
			} else {
				current.find('.header-title').text('Discount');
				updateNumberScreen(0);
			}

			if ((e.keyCode >= 96 && e.keyCode <= 105) || (e.keyCode == 8 || e.keyCode == 67)) {
				getNumberStrKey(e.key);
			}
		});
	})

	$(function() {
		$('#numeralModal').on('hide.bs.modal', function() {
			glbQtyEntry = '0';
		});
	});

	function getNumberStrKey(keyStr) {
		if (!$.isEmptyObject(keyStr)) {
			if (keyStr === "c") {
				glbQtyEntry = '0';
			} else if (keyStr === "Backspace") {
				glbQtyEntry = glbQtyEntry.substring(0, glbQtyEntry.length - 1);

				if ($.isEmptyObject(glbQtyEntry)) glbQtyEntry = '0';
			} else {
				if (glbQtyEntry === '0') glbQtyEntry = keyStr;
				else glbQtyEntry = glbQtyEntry + keyStr;
			}

			updateNumberScreen(glbQtyEntry);
		}
	}

	$(function() {
		$('.number-clicked').on('click', function() {
			var getClicked = $(this).data('val').toString();
			getNumberStrKey(getClicked)
		});
	});

	function updateNumberScreen(getVal) {
		var dispVal = getVal.toString();
		$('.number-screen').text(numeral(dispVal.substring(0, 10)).format('0,0'));
	};

	function getNumberEntered() {
		var numberEntered = parseFloat($('.number-screen').text().replace(/,/g, ''));
		var total = parseFloat(getGrandTotal());
		var discType = $('#discType').val();

		if (discType == 1 && numberEntered > total) {
			smkAlert('You entered number > total', 'danger');
		} else {
			if (glbMdType === 'qty') {
				updateItemPrice(numberEntered);
			} else {
				getDiscEntered(discType, numberEntered);
			}

			discount();
		}
	}
	//=================================== end =================================//


	//=================================== discount action =================================//
	function getDiscEntered(discType, discEntered) {
		if (discType == 0 && discEntered > 100) {
			discEntered = 100;
		}

		$('#discTotal').text(numeral(discEntered).format('0,0'));
		$('#numeralModal').modal('hide');
	}

	function discount() {
		var discEntered = parseFloat($('#discTotal').text().replace(/,/g, ''));

		if (discEntered > 0) {
			glbGrandTotal = getGrandTotal();
			var discType = $('#discType').val();

			if (discType == 0) { //get money from %
				if (discEntered > 100) {
					discEntered = 100;
				}

				glbDiscPercent = discEntered;
				glbDiscMoney = ((discEntered * glbGrandTotal) / 100);
				glbTotalAfterDisc = (glbGrandTotal - glbDiscMoney);
			} else { //get % from money
				glbDiscPercent = ((100 * discEntered) / glbGrandTotal);
				glbDiscMoney = discEntered;
				glbTotalAfterDisc = (glbGrandTotal - glbDiscMoney);
			}

			$('#grandTotalAfterDisc').text(numeral(glbTotalAfterDisc).format('0,0.00'));
			$('#grandTotal').removeClass('d-none').text(numeral(glbGrandTotal).format('0,0.00'));
		} else {
			$('#grandTotalAfterDisc').text(numeral(getGrandTotal()).format('0,0.00'));
			$('#grandTotal').addClass('d-none').text(0);
			glbGrandTotal = getGrandTotal();
			glbTotalAfterDisc = getGrandTotal();
		}
	}

	function updateItemPrice() {
		var lastQty = parseInt($('.number-screen').text());
		var totalItemPrice = (glbItemPrice * lastQty);

		$('#itemSales tr[id=item_' + glbItemId + '] u').text(lastQty);
		$('#itemSales tr[id=item_' + glbItemId + '] td').eq(1).text(numeral(totalItemPrice).format('0,0.00'));
		$('#numeralModal').modal('hide');

		if (lastQty === 0) {
			$('#itemSales tr[id=item_' + glbItemId + ']').closest('tr').remove();
		}

		$('#grandTotalAfterDisc').text(numeral(getGrandTotal()).format('0,0.00'));
	}
	//=================================== end =================================//


	//========================================= payment modal ==================================//
	function showPaymentModal() {
		var checkItemList = $('#itemSales tr').length;

		if (checkItemList <= 0) {
			smkAlert('No orders!', 'danger');
		} else {
			$('#paymentModal').modal('show');
			updateMoneyScreen(0);
		}
	}

	$(function() {
		$('#paymentModal').on('show.bs.modal keydown', function(e) {
			getPaymentType();
			glbPaymt = 1;

			if ((e.keyCode >= 96 && e.keyCode <= 105) || (e.keyCode == 8 || e.keyCode == 67 || e.keyCode == 110)) {
				getMoneyStrKey(e.key);
			}
		});
	})

	$(function() {
		$('#paymentModal').on('hide.bs.modal', function() {
			glbMoneyEntry = 0;
		});
	});

	function getMoneyStrKey(keyStr, isMoney) {
		if (keyStr === 'c') {
			glbMoneyEntry = 0;
		} else if (keyStr === "Backspace") {
			var moneyStr = glbMoneyEntry.toString();
			glbMoneyEntry = moneyStr.substring(0, moneyStr.length - 1);

			if ($.isEmptyObject(glbMoneyEntry)) {
				glbMoneyEntry = 0;
			}
		} else if (keyStr === 'full') {
			glbMoneyEntry = glbTotalAfterDisc;
		} else {
			if (glbMoneyEntry == 0) {
				glbMoneyEntry = keyStr;
			} else {
				if (isMoney == 1) {
					glbMoneyEntry = parseFloat(glbMoneyEntry) + parseFloat(keyStr);
				} else {
					glbMoneyEntry = glbMoneyEntry + keyStr;
				}
			}
		}

		var lastMoney = parseFloat(glbMoneyEntry);
		updateMoneyScreen(lastMoney);
	}

	function updateMoneyScreen(getVal) {
		var custInfo = $('#empInfo').text();
		var dispVal = getVal.toString();
		var totalAmount = parseFloat($('#grandTotalAfterDisc').text().replace(/,/g, ''));
		var totalPaid = parseFloat(dispVal.replace(/,/g, ''));
		var btnState;

		$('.money-screen').html(numeral(dispVal).format('0,0'));

		if (glbPaymt == 1) {
			if ((totalPaid < totalAmount)) {
				btnState = true;
			} else {
				btnState = false;
			}
		} else {
			if (!$.isEmptyObject(custInfo)) {
				btnState = false;
			} else {
				swalAlert('Please enter the customer info!', 'warning');
				btnState = true;
			}
		}

		$('#btnSubmit').attr('disabled', btnState);
	};

	$(function() {
		$('.money-clicked').on('click', function() {
			if (glbPaymt == 1) {
				var getClicked = $(this).data('val').toString();
				var isMoney = $(this).data('money');

				getMoneyStrKey(getClicked, isMoney);
			}
		});
	});
	//========================================= end ==================================//


	//========================================= emp modal ==================================//
	$(function() {
		$('#empModal').on('show.bs.modal', function(e) {
			$('#frmFindEmp').smkClear();
		});
	});

	$(function() {
		$('#empId').on('keyup', function(e) {
			e.preventDefault();

			var rawStr = $(this).val();
			var empId = dataFilter(rawStr);

			if (!$.isEmptyObject(empId)) {
				getPatientsInfo(empId);
			}
		})
	});

	function getPatientsInfo(empId) {
		$('#empId').val(empId);

		$.getJSON("<?= site_url('EmpController/FetchOneEmp') ?>/" + empId, function(data) {
			if (!$.isEmptyObject(data.empInfo)) {
				$('#empName').val(data.empInfo.FullName);
				$('#credBalance').val(numeral(data.credBlance.CreditBalance).format('0,0.00'));
				$('#credLimited').val(data.credBlance.CreditLimited);
			} else {
				$('#empName').val('');
			}
		});

		return false;
	}

	function getEmpEntered() {
		var empId = $('#empId').val();
		var empName = $('#empName').val();

		if ($.isEmptyObject(empName)) {
			swalAlert('Please enter Emp ID', 'error');
		} else {
			var credLimited = parseFloat($('#credLimited').val());
			var credBalance = parseFloat($('#credBalance').val());
			var newCredit = parseFloat(glbTotalAfterDisc);
			var totalCredit = (credBalance + newCredit);

			if (totalCredit > credLimited) {
				swalAlert('Over limited (' + credLimited + ') ?', 'error');
			} else {
				$('#empInfo').text(empId).attr('title', empName);
				$('#empModal').modal('hide');
			}
		}
	}
	//========================================= end ========================================//


	//========================================= payment submition ==================================//
	function submitPayment() {
		var totalChange = 0;
		var totalAmount = glbGrandTotal;
		var totalPaid = $('.money-screen').text().replace(/,/g, '');

		if (glbPaymt == 1) {
			totalChange = (totalPaid - glbTotalAfterDisc);
			isCredit = 1;
		}

		var params = {
			docNo: glbDocNo,
			custId: $('#empInfo').text(),
			custName: $('#empInfo').attr('title'),
			amount: parseFloat(totalAmount).toFixed(2),
			paid: parseFloat(totalPaid).toFixed(2),
			disPercent: parseFloat(glbDiscPercent).toFixed(2),
			disMoney: parseFloat(glbDiscMoney).toFixed(2),
			afterDis: parseFloat(glbTotalAfterDisc).toFixed(2),
			changeAmount: parseFloat(totalChange).toFixed(2),
			paymtCode: $('#paymt').find(':selected').data('paymt-code')
		}

		$.ajax({
			method: 'POST',
			url: "<?= site_url('TransController/InitInsertTrans') ?>",
			data: $.param(params),
		}).done(function(data) {
			insertDetailSales();
			smkAlert(data.message, data.status);
			removeAllItem();

			$('#empInfo').text('').attr('title', '');
			$('#paymentModal').modal('hide');

			Swal.fire({
				title: 'Change Amount',
				text: numeral(params.changeAmount).format('0,0.00'),
				icon: 'success',
				confirmButtonColor: '#4e73df',
				confirmButtonText: 'print'
			}).then((result) => {
				if (result.value) {
					getInvoiceData(params.docNo);
				}
			});

			getDocNo();
		}).fail(function(jqHRX, textStatus, errorThrown) {
			smkAlert('Something went wrong, please contact IT!', 'danger');
		});

	}

	function insertDetailSales() {
		$('#itemSales').find('tr').each(
			function() {
				var params = {
					docNo: glbDocNo,
					itemSaleCode: $(this).find('td').eq(0).data('item-code'),
					itemSaleName: $(this).find('td').eq(0).text(),
					itemSalePrice: $(this).find('td').eq(1).data('item-price'),
					itemSaleqty: $(this).find('td').eq(2).find('u').text(),
					totalSales: (parseFloat($(this).find('td').eq(1).data('item-price')) * parseInt($(this).find('td').eq(2).find('u').text()))
				}

				$.ajax({
					type: 'POST',
					url: "<?= site_url('TransController/InitInsertDetailSales'); ?>",
					data: $.param(params),
					async: false
				}).done(function(data) {
					//CutStock
				}).fail(function(jqXHR, textStatus, errorThrown) {
					smkAlert('Something went wrong, please contact IT!', 'danger');
				});
			}
		);

		return false;
	}

	// function CutStock(itemCode, saleQty) {
	// 	$.ajax({
	// 		type: "POST",
	// 		url: "<?= site_url('TransController/InitCutStock'); ?>",
	// 		data: {
	// 			itemCode: itemCode,
	// 			saleQty: saleQty
	// 		}
	// 	}).fail(function(jqXHR, textStatus, errorThrown) {
	// 		SmkDangerAlert('Something went wrong, please contact IT!');
	// 	});

	// 	return false;
	// }
	//========================================= end ==================================//


	//========================================= show payment type on selection ==================================//
	function getPaymentType() {
		$('#paymt').html('');

		$.getJSON("<?= site_url('TransController/FetchAllPaymentTypes') ?>", function(data) {
			if (!$.isEmptyObject(data)) {
				$.each(data, function(i, val) {
					paymtAppending(val);
				});
			};
		});
	}

	function paymtAppending(data) {
		var html = Mustache.render(paymtTempl, data);
		$('#paymt').append(html);
	}

	var paymtTempl = '<option data-paymt-code="{{PaymtCode}}" value="{{PaymtID}}">{{PaymtCode}}-{{PaymtDesc}}</option>';
	//========================================= end ==================================//


	//========================================= clear money entered on paymt change ==================================//
	function paymtOnChange(paymtVal) {
		glbMoneyEntry = 0;
		glbPaymt = paymtVal;
		updateMoneyScreen(0);

	}
	//========================================= end ==================================//


	//========================================= small functions ==========================//
	function onDiscChange() {
		$('#discTotal').text(0);
		discount();
	}
	//========================================= end ==========================//


	//=============================== last invoice modal ===============================//
	$(function() {
		$('#lastInvModal').on('show.bs.modal', function() {
			getLastInvoice();
		});
	});

	function getLastInvoice() {
		$('#lastInvItems').html('');

		$.getJSON("<?= site_url('ReportController/FetchLastInvoice') ?>", function(data) {
			if (!$.isEmptyObject(data)) {
				$.each(data, function(i, val) {
					invoiceAppending(val);
				});
			};
		});
	}

	function invoiceAppending(data) {
		var html = Mustache.render(invTempl, data);
		$('#lastInvItems').append(html);
	}

	var invTempl = [
		'<tr><td class="text-nowrap text-center">{{TranDocNo}}</td>',
		'<td class="text-center">{{TranPaymentCode}}</td>',
		'<td class="text-nowrap text-center">{{TranCreatedBy}}</td>',
		'<td class="text-nowrap text-center">{{CreatedAt}}</td>',
		'<td class="text-nowrap text-center"><a href="#" class="btn btn-secondary" id="{{TranDocNo}}" onclick="getInvoiceData(this.id);"><i class="fas fa-print"></i> re-print</a>',
		'</td></tr>'
	].join("\n");
	//================================ end =============================================//


	//================ confirm pass to open cash drawer ======================//
	function confirmPass() {
		Swal.fire({
			title: 'Password Confirmation',
			input: 'password',
			inputAttributes: {
				autocapitalize: 'off',
				placeholder: 'Enter your password',
				required: true
			},
			showCancelButton: true,
			confirmButtonText: 'OK',
			confirmButtonColor: '#4e73df',
			cancelButtonColor: '#e74a3b',
		}).then((result) => {
			if (result.value) {
				var usr = "<?= $this->session->userdata('username') ?>";
				var pwd = result.value;

				$.getJSON("<?= site_url('AppController/CheckAccount') ?>/" + usr + '/' + pwd, function(data) {
					if (!$.isEmptyObject(data)) {
						openCashDW();
					} else {
						smkAlert("Incorrect password", 'danger');
					}
				}).fail(function(jqXHR, textStatus, errorThrown) {
					smkAlert("Something went wrong, please contact IT!", 'danger');
				});
			}
		})
	}

	function openCashDW() {
		$.ajax({
			url: "<?= site_url('TransController/ExecuteOpenCashDW'); ?>"
		}).fail(function(jqXHR, textStatus, errorThrown) {
			smkAlert('Something went wrong, please contact IT!', 'danger');
		});
	}
</script>