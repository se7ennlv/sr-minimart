<section>
	<h3 class="text-primary"><i class="fas fa-users-cog"></i> User Management</h3>
	<hr>
</section>

<div class="row">
	<div class="col">
		<div class="card mb-4 border-left-warning">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-primary mb-1">
							<h5>General Info</h5>
						</div>
						<hr class="sidebar-divider">
					</div>

					<div class="col-auto">
						<i class="fas fa-user-circle fa-2x text-gray-300"></i>
					</div>
				</div>
				<form action="#" name="frmData" id="frmData" method="POST" novalidate autocomplete="off">
					<div class="form-group">
						<input type="text" name="UserEmpID" id="UserEmpID" class="form-control" placeholder="Emp ID" required>
					</div>
					<div class="form-group">
						<input type="text" name="UserUsername" id="UserUsername" class="form-control" placeholder="User name" required readonly>
					</div>
					<div class="form-group">
						<input type="text" name="UserPassword" id="UserPassword" class="form-control" placeholder="Password" required>
					</div>
					<div class="form-group">
						<input type="text" name="UserFname" id="UserFname" class="form-control" placeholder="First Name" required readonly>
					</div>
					<div class="form-group">
						<input type="text" name="UserLname" id="UserLname" class="form-control" placeholder="Last Name" required readonly>
					</div>
					<div class="form-group">
						<select name="UserOrgID" id="UserOrgID" class="form-control" required>
							<option value="">Select Dept</option>
							<?php foreach ($depts as $dept) : ?>
								<option value="<?= $dept->OrgID; ?>"><?= $dept->DeptName; ?></option>
							<?php endforeach; ?>
						</select>
					</div>

					<hr class="sidebar-divider">

					<div class="form-group">
						<p class="float-left">
							<label class="radio-inline">
								<input type="radio" name="UserIsSaleman" value="1"> Salesman
							</label>
							<label class="radio-inline">
								<input type="radio" name="UserIsSaleman" value="0" checked> Not Salesman
							</label>
						</p>

						<p class="float-right">
							<label class="radio-inline">
								<input type="radio" name="UserIsActive" value="1" checked> Enable
							</label>
							<label class="radio-inline">
								<input type="radio" name="UserIsActive" value="0"> Disable
							</label>
						</p>
					</div>

				</form>
			</div>
		</div>
	</div>
	<div class="col">
		<div class="card mb-4">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-primary mb-1">
							<h5>Role of Menus Access </h5>
						</div>
						<hr class="sidebar-divider">
					</div>

					<div class="col-auto">
						<i class="fas fa-user-shield fa-2x text-gray-300"></i>
					</div>
				</div>
				<div class="form-group">
					<ul class="pl-0" style="list-style:none; cursor: pointer;">
						<?php foreach ($mgroups as $mg) : ?>
							<li class="mb-2">
								<input type="checkbox" name="MGroupID[]" id="<?= $mg->MGroupID; ?>" value="<?= $mg->MGroupID; ?>" onchange="onGroupChecked(this.id);"> <span class="text-secondary font-weight-bold" required><?= $mg->MGroupName; ?></span>
								<ul style="list-style:none;">
									<?php foreach ($menus as $mn) : ?>
										<?php if ($mg->MGroupID == $mn->MenuGroupID) : ?>
											<li>
												<input type="checkbox" name="MenuID[]" class="<?= trim('group' . $mg->MGroupID); ?>" value="<?= $mn->MenuID; ?>" onchange="onMenuChecked(<?= $mg->MGroupID; ?>);" required> <?= $mn->MenuName; ?>
											</li>
										<?php endif ?>
									<?php endforeach ?>
								</ul>
							</li>
						<?php endforeach ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="col">
		<div class="card mb-4 border-right-warning">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-primary mb-1">
							<h5>Action Granting</h5>
						</div>
						<hr class="sidebar-divider">
					</div>

					<div class="col-auto">
						<i class="fas fa-user-tag fa-2x text-gray-300"></i>
					</div>
				</div>
				<div class="form-group">
					<ul class="pl-0" style="list-style:none; cursor: pointer;">
						<?php foreach ($actions as $act) : ?>
							<li class="mb-2">
								<input type="checkbox" name="Action[]" value="<?= $act->ActID; ?>"> <span class="text-secondary font-weight-bold" required><?= $act->ActName; ?></span>
							</li>
						<?php endforeach ?>
					</ul>
				</div>

				<hr>

				<div class="form-group">
					<button type="button" class="btn btn-primary" onclick="onSave();"><i class="fas fa-save"></i> Save</button>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		$("#UserEmpID").trigger('focus');
	});

	function onMenuChecked(groupId) {
		$('input[id=' + groupId + ']').prop('checked', true);
	}

	function onGroupChecked(groupId) {
		if ($('input[id=' + groupId + ']').prop('checked') == true) {
			$('.group' + groupId).prop('checked', true)
		} else {
			$('.group' + groupId).prop('checked', false)
		}
	}

	$('#UserEmpID').on('keyup', function() {
		var empId = $.trim($(this).val()).toString();

		if (empId.length > 0) {
			$.ajax({
				method: 'POST',
				url: "<?= site_url('EmpController/FetchOneEmp') ?>/" + empId
			}).done(function(data) {
				if (!$.isEmptyObject(data.empInfo)) {
					$('#UserUsername').val(data.empInfo.EmpID);
					$('#UserPassword').val('a123456');
					$('#UserFname').val(data.empInfo.Fname);
					$('#UserLname').val(data.empInfo.Lname);
					$('#UserOrgID').val(data.empInfo.OrgID);
				} else {
					clearData();
				}
			}).fail(function(jqXHR, textStatus, errorThrown) {
				smkAlert('Something went wrong, please contact IT!', 'danger');
			});
		}
	});

	function onSave() {
		if ($('#frmData').smkValidate()) {
			var formData = $('#frmData').serialize();
			var mgArray = [];
			var mnArray = [];
			var actArray = [];

			$("input:checked[name='MGroupID[]']").each(function() {
				mgArray.push($(this).val());
			});

			$("input:checked[name='MenuID[]']").each(function() {
				mnArray.push($(this).val());
			});

			$("input:checked[name='Action[]']").each(function() {
				actArray.push($(this).val());
			});

			var params = {
				mgroupId: mgArray.join(','),
				menuId: mnArray.join(','),
				actions: actArray.join(',')
			}

			$.ajax({
				method: 'POST',
				url: "<?= site_url('UserController/InitInsertUser') ?>",
				data: formData + '&' + $.param(params),
				beforeSend: function() {
					blockUI('Processing...');
				}
			}).done(function(data) {
				if (data.status === 'success') {
					smkAlert(data.message, data.status);
					clearData();
				}
			}).fail(function(jqXHR, textStatus, errorThrown) {
				smkAlert('Something went wrong, please contact IT', 'danger');
			});

			unblockUI();
		}
	};

	function clearData() {
		//$('#UserUsername').val('').trigger('focus');
		$('#UserPassword').val('');
		$('#UserFname').val('');
		$('#UserLname').val('');
		$('#UserOrgID').val('');
		$('input:checkbox').prop('checked', false);
	}
</script>