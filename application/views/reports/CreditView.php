<section class="mb-1">
    <h5 class="m-0 font-weight-bold text-primary pull-left"><i class="fa fa-th-list"></i> <strong>Employees Credit List</strong></h5>
</section>

<div class="card mb-4 border-top-primary">
    <div class="card-body">
        <div class="table-responsive" style="max-height: 58vh">
            <div id="toolbar" class="mb-2">
                <form class="form-inline" action="#" autocomplete="off" method="POST">
                    <div class="input-group ml-1 mr-1">
                        <input type="text" name="fromDate" id="fromDate" class="form-control date-picker" style="width: 120px;" readonly>
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-calendar-alt mr-1"></i> To <i class="fas fa-calendar-alt ml-1"></i></span>
                        </div>
                        <input type="text" name="toDate" id="toDate" class="form-control date-picker" style="width: 120px;" readonly>
                    </div>
                    <select name="payGroup" id="payGroup" class="form-control ml-1 mr-1">
                        <option value="0">All</option>
                        <?php foreach ($pgroups as $pgroup) : ?>
                            <option value="<?= $pgroup->GroupCode; ?>"><?= $pgroup->GroupCode; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="button" class="btn btn-success" onclick="initData($('#fromDate').val(), $('#toDate').val());"><i class="fas fa-sync-alt"></i> Refresh Data</button>
                </form>
            </div>

            <table class="table table-bordered table-sm" id="dataTable" data-toolbar="#toolbar" data-search="true" data-show-toggle="true" data-show-fullscreen="true" data-show-columns="true" data-show-columns-toggle-all="true" data-show-export="true" data-minimum-count-columns="2" data-show-pagination-switch="true" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, all]" data-show-footer="true">
                <thead>
                    <tr>
                        <th colspan="5">Mini Mart</th>
                    </tr>
                    <tr>
                        <th colspan="5">Credit List Reports</th>
                    </tr>
                    <tr>
                        <th colspan="5">Date : <span id="dateFrom"></span> To <span id="dateTo"></span></th>
                    </tr>
                    <tr>
                        <th data-field="TranCustID" class="text-nowrap text-center">Emp ID</th>
                        <th data-field="TranCustName" class="text-nowrap" data-halign="center">Emp Name</th>
                        <th data-field="Dept" class="text-nowrap" data-halign="center">Dept</th>
                        <th data-field="Positions" class="text-nowrap" data-halign="center" data-footer-formatter="totalText">Position</th>
                        <th data-field="TotalCredit" class="text-nowrap text-center" data-formatter="money" data-footer-formatter="summary">Credit Balance</th>
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
        var pgroup = $('#payGroup').val();

        $.ajax({
            type: 'GET',
            url: "<?= site_url('ReportController/FetchAllCredit') ?>/" + fDate + '/' + tDate + '/' + pgroup,
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
                fileName: 'Credit Reports'
            }
        })
    }
</script>