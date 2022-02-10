<!-- employees modal -->
<div id="empModal" class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-search"></i> Find Employees</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" id="frmFindEmp" method="POST" autocomplete="off" novalidate>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">EMP ID</span>
                            </div>
                            <input type="text" name="empId" id="empId" class="form-control" placeholder="Enter Emp ID" autofocus>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">EMP Name</span>
                            </div>
                            <input type="text" name="empName" id="empName" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Credit Balance</span>
                            </div>
                            <input type="text" name="credBalance" id="credBalance" class="form-control" readonly>
                            <input type="hidden" id="credLimited">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-lg" onclick="getEmpEntered();"><i class="fas fa-check-circle"></i> Confirm</button>
                    <button type="button" class="btn btn-danger btn-lg" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('#empModal').on('shown.bs.modal', function() {
        $('#empId').trigger('focus');
    });
</script>