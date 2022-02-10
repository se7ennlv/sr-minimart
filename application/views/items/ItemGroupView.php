<div class="row">
    <div class="col">
        <section>
            <h3 class="text-primary"><i class="fas fa-th-large"></i> Item Group Management</h3>
        </section>

        <div class="card mb-4 border-top-primary mt-2">
            <div class="card-body">
                <div class="table-responsive">
                    <div id="toolbar">
                        <button class="btn btn-success" onclick="onAdd();"><i class="fas fa-plus-circle"></i> Add New Item</button>
                    </div>

                    <table class="table table-bordered table-sm" id="dataTable" data-url="<?= site_url('ItemController/FetchAllItemGroups'); ?>" data-toolbar="#toolbar" data-search="true" data-show-refresh="true" data-show-toggle="true" data-show-fullscreen="true" data-show-columns="true" data-show-columns-toggle-all="true" data-show-export="true" data-minimum-count-columns="2" data-show-pagination-switch="true" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, all]" data-sort-name="ItemGroupID" data-sort-order="desc">
                        <thead class="thead-light">
                            <tr>
                                <th data-formatter="runnings" data-halign="center" class="text-center">#</th>
                                <th data-field="ItemGroupID" data-halign="center" class="text-center">Group ID</th>
                                <th data-field="ItemGroupName" data-halign="center">Group Name</th>
                                <th data-field="ItemGroupLowStockAlert" data-halign="center" class="text-center" data-formatter="badgeVal">Low Stock Alert</th>
                                <th data-field="ItemGroupUpdatedAt" data-halign="center" class="text-center" data-formatter="dateTime">Last Updated</th>
                                <th class="text-center" data-halign="center" data-formatter="udOperates" data-events="operateEvents">Operates</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- itemGroup modal -->
<div id="itemGroupModal" class="modal fade itemGroupModal" tabindex="-1" role="dialog" aria-labelledby="itemGroupModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary" id="itemGroupModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" id="frmItemGroup" method="POST" autocomplete="off" novalidate>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" name="ItemGroupName" id="ItemGroupName" class="form-control" placeholder="Enter group name" required>
                    </div>
                    <div class="form-group">
                        <input type="number" name="ItemGroupLowStockAlert" id="ItemGroupLowStockAlert" class="form-control" placeholder="Enter low stock alert">
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="ItemGroupID" id="ItemGroupID">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end -->

<script>
    //=================== initail ==================//
    var table = $('#dataTable');
    var actions;

    function initTable() {
        table.bootstrapTable('destroy').bootstrapTable({
            exportDataType: 'all',
            exportOptions: {
                ignoreColumn: [5],
                fileName: 'item-groups'
            }
        })
    }

    $(function() {
        initTable();
    });


    //======================== operates ==========================//
    window.operateEvents = {
        'click .btn-edit': function(e, value, row, index) {
            var itemId = row.ItemGroupID;
            onUpdate(itemId);
        },

        'click .btn-del': function(e, value, row, index) {
            var itemId = row.ItemGroupID;
            onDelete(itemId);
        }
    }

    function onAdd() {
        actions = 'add';

        $('#itemGroupModal').modal('show');
        $('.modal-title').html('<i class="fas fa-plus-circle"></i> Add New Item Group');
    }

    function onUpdate(itemId) {
        actions = 'update';

        $.getJSON("<?= site_url('ItemController/FetchOneItemGroup') ?>/" + itemId, function(data) {
            if (!$.isEmptyObject(data)) {
                $('#itemGroupModal').modal('show');
                $('.modal-title').html('<i class="fas fa-edit"></i> Update Item Group');
                $('#ItemGroupID').val(data.ItemGroupID);
                $('#ItemGroupName').val(data.ItemGroupName);
                $('#ItemGroupLowStockAlert').val(data.ItemGroupLowStockAlert);
            }
        });
    }

    function onDelete(itemId) {
        deletion('ItemController/InitDeleteItemGroup', itemId);
    }

    $(function() {
        $('#itemGroupModal').on('shown.bs.modal', function() {
            $('#ItemGroupName').trigger('focus');
        });
    });

    $(function() {
        $('#itemGroupModal').on('hide.bs.modal', function() {
            $('#frmItemGroup').smkClear();
        });
    });


    $(function() {
        $('#frmItemGroup').submit(function(e) {
            e.preventDefault();

            if ($(this).smkValidate()) {
                var formData = $(this).serialize();
                var url;

                if (actions === 'update') {
                    url = "<?= site_url('ItemController/InitUpdateItemGroup') ?>";
                } else {
                    url = "<?= site_url('ItemController/InitInsertItemGroup') ?>";
                }

                $.ajax({
                    method: 'POST',
                    url: url,
                    data: formData
                }).done(function(data) {
                    if (data.status === 'success') {
                        smkAlert(data.message, data.status);
                        $('#itemGroupModal').modal('hide');
                        table.bootstrapTable('refresh');
                    } else {
                        smkAlert('Something went wrong, please contact IT!', 'danger');
                    }
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    smkAlert('Something went wrong, please contact IT!', 'danger');
                });
            }
        })
    });
</script>