<section class="mb-1">
    <h5 class="m-0 font-weight-bold text-primary pull-left"><i class="fa fa-th-list"></i> <strong>Item Detail Sales</strong></h5>
</section>

<div class="card mb-4 border-top-primary">
    <div class="card-body">
        <form class="form-inline mb-3" action="#" autocomplete="off" method="POST">
            <div class="input-group ml-1 mr-1">
                <input type="text" name="fromDate" id="fromDate" class="form-control date-picker" style="width: 120px;" readonly>
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-calendar-alt mr-1"></i> To <i class="fas fa-calendar-alt ml-1"></i></span>
                </div>
                <input type="text" name="toDate" id="toDate" class="form-control date-picker" style="width: 120px;" readonly>
            </div>
            <button type="button" class="btn btn-info" onclick="initData();"><i class="fas fa-sync-alt"></i> Refresh Data</button>
            <i class="fas fa-grip-lines-vertical fa-2x ml-1 mr-1"></i>
            <button type="button" class="btn btn-success" onclick="onExport();"><i class="fas fa-file-excel"></i> Export to Excel</i></button>
        </form>

        <div id="dynamicData" class="table-responsive overflow-auto" style="height: 570px;">
            <!-- dynamic data -->
        </div>

    </div>
</div>

<script>
    $(document).ready(function() {
        $(function() {
            var currDate = moment().format("YYYY-MM-DD");

            $('#toDate').val(currDate);
            $('#fromDate').val(currDate);

            initData();
        });

        $(function() {
            $('.date-picker').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            })
        });
    });

    function initData() {
        var formData = $('form').serialize();

        $.ajax({
            type: 'POST',
            url: "<?= site_url('ReportController/FetchAllItemDetailSale') ?>",
            data: formData,
            beforeSend: function() {
                blockUI('Loading...');
            }
        }).done(function(data) {
            unblockUI();

            $('#dynamicData').html(data);
        });

        return false;
    }
</script>