<div id="lastInvModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Last (5) Invoices</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th class="text-nowrap text-center">Doc No</th>
                            <th class="text-nowrap text-center">Payment Type</th>
                            <th class="text-nowrap text-center">Salesman</th>
                            <th class="text-nowrap text-center">Date Time</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="lastInvItems">
                       <!-- dynamic -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">
                    <i class="fas fa-times"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>