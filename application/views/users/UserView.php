<div class="row">
	<div class="col">
		<section>
			<h3 class="text-primary"><i class="fas fa-users-cog"></i> User Management</h3>
		</section>
		<div class="card md-4 border-top-primary mt-2">
			<div class="card-body">
				<div class="table-responsive">
					<div id="toolbar">
						<button class="btn btn-primary" onclick="onAdd();"><i class="fas fa-plus-circle"></i> Add New User</button>
					</div>

					<table class="table table-bordered table-sm" id="dataTable" data-toolbar="#toolbar" data-url="<?= site_url('UserController/FetchAllUsers'); ?>" data-toolbar="#toolbar" data-search="true" data-show-refresh="true" data-show-toggle="true" data-show-fullscreen="true" data-show-columns="true" data-show-columns-toggle-all="true" data-show-export="true" data-minimum-count-columns="2" data-show-pagination-switch="true" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, all]" data-sort-name="UserID" data-sort-order="desc">
						<thead class="thead-light">
							<tr>
								<th data-formatter="runnings" class="text-center">#</th>
								<th data-field="UserEmpID" class="text-center">EmpID</th>
								<th data-field="UserUsername" class="text-center">Username</th>
								<th data-field="UserFname">First Name</th>
								<th data-field="UserLname">Last Name</th>
								<th data-field="DeptCode" class="text-center">Dept</th>
								<th data-field="UserUpdatedAt" data-formatter="dateTime" class="text-center">Last Updated</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	//=================== initail ==================//
	var table = $('#dataTable');
	var actions;

	function initTable() {
		table.bootstrapTable('destroy').bootstrapTable({
			exportDataType: 'all',
			exportOptions: {
				ignoreColumn: [5],
				fileName: 'users'
			}
		})
	}

	$(function() {
		initTable();
	});

	function onAdd() {
		$.ajax({
			url: "<?= site_url('UserController/UserAddView') ?>",
		}).done(function(data) {
			$('#mainApp').html(data);
		});
	}
</script>