<script>
    //============================== Menu Links =================================//
    function LinkShop() {
        window.open('<?= site_url('TransController/ShopView') ?>', '_blank');
    }

    function LinkItemGroupManage() {
        $.ajax({
            url: "<?= site_url('ItemController/ItemGroupView') ?>",
            beforeSend: function() {
                blockUI('Loading...');
            }
        }).done(function(data) {
            unblockUI();

            $('#mainApp').html(data);
        });

        return false;
    }

    function LinkItemManage() {
        $.ajax({
            url: "<?= site_url('ItemController/ItemView') ?>",
            beforeSend: function() {
                blockUI('Loading...');
            }
        }).done(function(data) {
            unblockUI();

            $('#mainApp').html(data);
        });

        return false;
    }

    function LinkUserManage() {
        $.ajax({
            url: "<?= site_url('UserController/UserView') ?>",
            beforeSend: function() {
                blockUI('Loading...');
            }
        }).done(function(data) {
            unblockUI();

            $('#mainApp').html(data);
        });

        return false;
    }

    function LinkCreditSetting() {
        $.ajax({
            url: "<?= site_url('AppController/CreditLimitView') ?>",
            beforeSend: function() {
                blockUI('Loading...');
            }
        }).done(function(data) {
            unblockUI();

            $('#mainApp').html(data);
        });

        return false;
    }


    //============================ Reports =========================//
    function LinkItemSales() {
        $.ajax({
            url: "<?= site_url('ReportController/ItemSaleView') ?>",
            beforeSend: function() {
                blockUI('Loading...');
            }
        }).done(function(data) {
            unblockUI();

            $('#mainApp').html(data);
        });

        return false;
    }

    function LinkItemDetailSales() {
        $.ajax({
            url: "<?= site_url('ReportController/ItemDetailSaleView') ?>",
            beforeSend: function() {
                blockUI('Loading...');
            }
        }).done(function(data) {
            unblockUI();

            $('#mainApp').html(data);
        });

        return false;
    }

    function LinkItemSaleByGroup() {
        $.ajax({
            url: "<?= site_url('ReportController/ItemSaleByGroupView') ?>",
            beforeSend: function() {
                blockUI('Loading...');
            }
        }).done(function(data) {
            unblockUI();

            $('#mainApp').html(data);
        }).fail(function(jqXHR, textStatus, errorThrown) {
            SmkAlert('danger', 'Something went wrong, please contact IT!');
        });

        return false;
    }

    function LinkCredit() {
        $.ajax({
            url: "<?= site_url('ReportController/CreditView') ?>",
            beforeSend: function() {
                blockUI('Loading...');
            }
        }).done(function(data) {
            unblockUI();

            $('#mainApp').html(data);
        });

        return false;
    }

    function LinkSalDeduct() {
        $.ajax({
            url: "<?= site_url('ReportController/SalDeductView') ?>",
            beforeSend: function() {
                blockUI('Loading...');
            }
        }).done(function(data) {
            unblockUI();

            $('#mainApp').html(data);
        });

        return false;
    }

    function LinkVoidedItem() {
        $.ajax({
            url: "<?= site_url('ReportController/VoideItemView') ?>",
            beforeSend: function() {
                blockUI('Loading...');
            }
        }).done(function(data) {
            unblockUI();

            $('#mainApp').html(data);
        });

        return false;
    }

    function LinkGraph() {
        $.ajax({
            url: "<?= site_url('ReportController/GraphView') ?>",
        }).done(function(data) {
            $('#mainApp').html(data);
        });

        return false;
    }
</script>