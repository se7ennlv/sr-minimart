<script>
    var glbPrintCopy = 0;

    function dataFilter(rawStr) {
        var newStr = rawStr.replace('%', '').replace('?', '').replace('+', '').replace(';', '').replace('E', '');
        var empId;

        if (newStr.length == 8) {
            empId = newStr
        } else if (newStr.length > 6) {
            empId = newStr.substr(0, 6);
        } else {
            empId = newStr;
        }

        return empId;
    }

    //================================================== Actions ===================================//
    function deletion(ctrlFnc, id) {
        var siteUrl = "<?= site_url() ?>" + ctrlFnc + "/" + id;

        Swal.fire({
            title: 'Confirm',
            text: "",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#4e73df',
            cancelButtonColor: '#e74a3b',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    method: 'GET',
                    url: siteUrl,
                }).done(function(data) {
                    if (data.status === 'success') {
                        smkAlert(data.message, data.status);
                        $('#dataTable').bootstrapTable('refresh');
                    } else {
                        smkAlert('Something went wrong, please contact IT!', 'danger');
                    }
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    smkAlert('Something went wrong, please contact IT!', 'danger');
                });
            }
        })
    }

    function getInvoiceData(docNo) {
        $.getJSON("<?= site_url('ReportController/FetchBillData'); ?>/" + docNo, function(data) {
            $('#invItems').html('');

            if (!$.isEmptyObject(data.trans)) {
                $('#billHeader').text('Guest Check');

                if (glbPrintCopy == 1) {
                    $('#billHeader').text('Official Check');

                    if (data.trans.TranIsVoid == 1) {
                        $('#billHeader').text('Official (VOIDED)');
                    }
                }

                $('#invDate').text(moment(data.trans.TranCreatedAt).format("Do MMM YY h:mm:ss A"));
                $('#invDocNo').text(data.trans.TranDocNo);
                $('#invSaleBy').text(data.trans.TranCreatedBy);

                if (!$.isEmptyObject(data.trans.TranCustName)) {
                    $('.member').removeClass('d-none');
                    $('#invCust').text(data.trans.TranCustName);
                } else {
                    $('.member').addClass('d-none');
                    $('#invCust').text('');
                }

                $('#invTotal').text(numeral(data.trans.TranTotalAmount).format('0,0.00'));
                $('#invDisc').text(numeral(data.trans.TranDiscPercent).format('0,0'));
                $('#invPaymt').text(data.trans.TranPaymentCode);
                $('#invGrandTotal').text(numeral(data.trans.TranAfterDisc).format('0,0.00'));

                if (!$.isEmptyObject(data.dts)) {
                    $.each(data.dts, function(i, val) {
                        var objs = {
                            itemName: val.DSItemName,
                            itemPrice: numeral(val.DSItemPrice).format('0,0.00'),
                            itemQty: val.DSItemQty,
                            totalPrice: numeral(val.DSTotalPrice).format('0,0.00')
                        }

                        invoiceItemAppending(objs);
                    });
                }

                if (glbPrintCopy <= 1) {
                    printDoc(docNo);
                } else {
                    glbPrintCopy = 0;
                }
            }
        }).fail(function(jqXHR, textStatus, errorThrown) {
            smkAlert('Something went wrong, please contact IT!', 'danger');
        });
    }

    function printDoc(docNo) {
        $('#invoiceBody').printThis({
            importCss: true,
            afterPrint: function() {
                glbPrintCopy = glbPrintCopy + 1;
                getInvoiceData(docNo);
            }
        });
    }

    function invoiceItemAppending(data) {
        var html = Mustache.render(billItemTempl, data);
        $('#invItems').append(html);
    }

    var billItemTempl = [
        '<tr>',
        '<td colspan="2" class="text-truncate" style="max-width: 300px; min-width: 260px">{{itemName}}</td>',
        '<td class="text-right">{{itemPrice}}</td>',
        '<td class="text-center">{{itemQty}}</td>',
        '<td class="text-right">{{totalPrice}}</td>',
        '</tr>'
    ].join("\n");


    //=========================== change password ===========================//
    $(function() {
        $('#frmChgPass').on('submit', function(e) {
            e.preventDefault();

            if ($(this).smkValidate()) {
                var formData = $(this).serialize();

                $.ajax({
                    method: 'POST',
                    url: "<?= site_url('UserController/InitChangePass') ?>",
                    data: formData,
                    beforeSend: function() {
                        blockUI('Loading...');
                    }
                }).done(function(data) {
                    unblockUI();
                    smkAlert(data.message, data.status);
                    $('#changePwdModal').modal('hide');
                    $('#frmData').smkClear();
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    smkAlert('Something went wrong, please contact IT!', 'danger');
                });
            }
        });
    });
</script>