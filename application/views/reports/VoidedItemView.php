<section class="mb-1">
    <h5 class="m-0 font-weight-bold text-primary pull-left"><i class="fa fa-th-list"></i> <strong>Voided List</strong></h5>
</section>

<div class="card mb-4 border-top-primary">
    <div class="card-body">
        <div class="table-responsive" style="max-height: 58vh">
            <div id="toolbar">
                <form class="form-inline"  action="#" autocomplete="off" method="POST">
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

            <table class="table table-bordered table-sm" id="dataTable" data-toolbar="#toolbar" data-search="true" data-show-refresh="true" data-show-toggle="true" data-show-fullscreen="true" data-show-columns="true" data-show-columns-toggle-all="true" data-show-export="true" data-minimum-count-columns="2" data-show-pagination-switch="true" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, all]" data-sort-name="TranDocNo" data-sort-order="desc">
                <thead>
                    <tr>
                        <th colspan="16">Mini Mart</th>
                    </tr>
                    <tr>
                        <th colspan="16">Voided Reports</th>
                    </tr>
                    <tr>
                        <th colspan="16">Date : <span id="dateFrom"></span> To <span id="dateTo"></span></th>
                    </tr>
                    <tr>
                        <th data-field="TranCreatedAt" class="text-nowrap text-center" data-formatter="dates">Date</th>
                        <th data-field="TranCreatedAt" class="text-nowrap text-center" data-formatter="times">Time</th>
                        <th data-field="TranDocNo" class="text-nowrap text-center">Check</th>
                        <th data-field="TranCustID" class="text-nowrap text-center">Emp ID</th>
                        <th data-field="TranCustName" class="text-nowrap" data-halign="center">Emp Name</th>
                        <th data-field="TranTotalAmount" class="text-nowrap text-center" data-formatter="money">Total Amount</th>
                        <th data-field="TranDiscPercent" class="text-nowrap text-center" data-formatter="money">Disc Percent</th>
                        <th data-field="TranDiscMoney" class="text-nowrap text-center" data-formatter="money">Disc Money</th>
                        <th data-field="TranAfterDisc" class="text-nowrap text-center" data-formatter="money">After Disc</th>
                        <th data-field="TranTotalPaid" class="text-nowrap text-center" data-formatter="money">Total Paid</th>
                        <th data-field="TranTotalCredit" class="text-nowrap text-center" data-formatter="money">Total Credit</th>
                        <th data-field="TranChangeAmount" class="text-nowrap text-center" data-formatter="money">Change Amount</th>
                        <th data-field="TranPaymentCode" class="text-nowrap text-center">Payment Type</th>
                        <th data-field="TranCreatedBy" class="text-nowrap text-center">Salesman</th>
                        <th data-field="TranUpdatedAt" class="text-nowrap text-center" data-formatter="dateTime">Voided At</th>
                        <th data-field="TranUpdatedBy" class="text-nowrap text-center">Voided By</th>
                    </tr>
                </thead>
            </table>
        </div>

    </div>
</div>

<script>
    var $table = $('#dataTable');

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
            url: "<?= site_url('ReportController/FetchAllVoidedItem') ?>/" + fDate + '/' + tDate,
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
        $table.bootstrapTable('destroy').bootstrapTable({
            data: data,
            exportDataType: 'all',
            exportOptions: {
                fileName: 'Voided Reports'
            }
        })
    }
</script>