<section class="mb-1">
    <h5 class="m-0 font-weight-bold text-primary pull-left"><i class="fa fa-th-list"></i> <strong>Item Sales Group by Categories</strong></h5>
</section>

<div class="card mb-4 border-top-primary">
    <div class="card-body">
        <div class="table-responsive" style="max-height: 58vh">
            <div id="toolbar" class="mb-3">
                <form class="form-inline" action="#" autocomplete="off" method="POST">
                    <div class="input-group ml-1 mr-1">
                        <input type="text" name="fromDate" id="fromDate" class="form-control date-picker" style="width: 120px;" readonly>
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-calendar-alt mr-1"></i> To <i class="fas fa-calendar-alt ml-1"></i></span>
                        </div>
                        <input type="text" name="toDate" id="toDate" class="form-control date-picker" style="width: 120px;" readonly>
                    </div>
                    <button type="button" class="btn btn-success" onclick="initData($('#fromDate').val(), $('#toDate').val());"><i class="fas fa-sync-alt"></i> Refresh Data</button>
                </form>
            </div>

            <table class="table table-bordered table-sm" id="dataTable" data-toolbar="#toolbar" data-search="true" data-show-toggle="true" data-show-fullscreen="true" data-show-columns="true" data-show-columns-toggle-all="true" data-show-export="true" data-minimum-count-columns="2" data-show-pagination-switch="true" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, all]" data-show-footer="true">
                <thead>
                    <tr>
                        <th colspan="6">Mini Mart</th>
                    </tr>
                    <tr>
                        <th colspan="6">Item Sales Group by Categories Reports</th>
                    </tr>
                    <tr>
                        <th colspan="6">Date : <span id="dateFrom"></span> To <span id="dateTo"></span></th>
                    </tr>
                    <tr>
                        <th data-field="ItemGroupName" class="text-nowrap text-center">Categories</th>
                        <th data-field="ItemCode" class="text-nowrap text-center">Item Code</th>
                        <th data-field="ItemName" data-halign="center">Item Name</th>
                        <th data-field="DSItemPrice" class="text-nowrap text-center" data-formatter="money">Price</th>
                        <th data-field="Qty" class="text-nowrap" data-align="center" data-formatter="numbers" data-footer-formatter="totalText">Qty</th>
                        <th data-field="Amount" class="text-nowrap" data-align="center" data-formatter="money" data-footer-formatter="summary">Total</th>
                    </tr>
                </thead>
            </table>
        </div>

    </div>
</div>

<script>
    var table = $('#dataTable');

    $(function() {
        var currDate = moment().format("YYYY-MM-DD");

        $('#toDate').val(currDate);
        $('#fromDate').val(currDate);

        initData(currDate, currDate);
    });

    $(function() {
        $('.date-picker').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
        })
    });

    function initData(fDate, tDate) {
        $.ajax({
            type: 'GET',
            url: "<?= site_url('ReportController/FetchAllItemSaleByGroup') ?>/" + fDate + '/' + tDate,
            dataType: 'JSON',
            beforeSend: function() {
                blockUI('Loading...');
            }
        }).done(function(data) {
            unblockUI();
            initTable(data);

            $('#dateFrom').text(fDate);
            $('#dateTo').text(tDate);
        });

        return false;
    }

    function initTable(data) {
        table.bootstrapTable('destroy').bootstrapTable({
            data: data,
            exportDataType: 'all',
            exportOptions: {
                fileName: 'Item Sales Group By Categories Reports'
            }
        })
    }
</script>