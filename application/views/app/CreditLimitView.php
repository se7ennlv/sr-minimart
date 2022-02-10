<section>
    <h3 class="text-primary">Credit Limitation</h3>
</section>

<div class="card mb-4 py-3 border-top-primary">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-3 col-md-3">
                <form action="#" name="frmData" id="frmData" method="POST" novalidate>
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Credit Amount</span>
                            </div>
                            <input type="text" class="form-control" name="OptVal" id="OptVal" placeholder="Enter amount to limit" required data-smk-type="currency">
                            <div class="input-group-prepend">
                                <span class="input-group-text">฿</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group float-right">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        initData();
    });

    function initData() {
        $.getJSON("<?= site_url('AppController/FetchCreditLimitInfo'); ?>", function(data) {
            if (!$.isEmptyObject(data)) {
                $('#OptVal').val(numeral(data.OptValue).format('0,0.00'));
            };
        });
    }

    $(function() {
        $('#frmData').on('submit', function(e) {
            e.preventDefault();

            if ($(this).smkValidate()) {
                var formData = $(this).serialize();

                $.ajax({
                    type: 'POST',
                    url: "<?= site_url('AppController/InitInserCreditLimit'); ?>",
                    data: formData,
                    dataType: 'json'
                }).done(function(data) {
                    if (data.status === "success") {
                        smkAlert(data.message, data.status);
                    } else {
                        smkAlert('Something went wrong, Please contact IT!', 'danger');
                    }
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    smkAlert('Something went wrong, Please contact IT!', 'danger');
                });
            }
        });
    });
</script>