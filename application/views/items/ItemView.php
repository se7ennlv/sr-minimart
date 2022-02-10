<div class="row">
	<div class="col">
		<section>
			<h3 class="text-primary"><i class="fas fa-th"></i> Item Management</h3>
		</section>
		<div class="card mb-4 border-top-primary mt-2">
			<div class="card-body">
				<div class="table-responsive">
					<div id="toolbar">
						<button class="btn btn-success" onclick="onAdd();"><i class="fas fa-plus-circle"></i> Add New Item</button>
					</div>

					<table class="table table-bordered table-sm" id="dataTable" data-toolbar="#toolbar" data-url="<?= site_url('ItemController/FetchAllItems'); ?>" data-toolbar="#toolbar" data-search="true" data-show-refresh="true" data-show-toggle="true" data-show-fullscreen="true" data-show-columns="true" data-show-columns-toggle-all="true" data-show-export="true" data-minimum-count-columns="2" data-show-pagination-switch="true" data-pagination="true" data-id-field="id" data-page-list="[10, 25, 50, 100, all]" data-sort-name="ItemID" data-sort-order="desc">
						<thead class="thead-light">
							<tr>
								<th data-formatter="runnings" class="text-center">#</th>
								<th data-field="ItemID" class="text-center">Item ID</th>
								<th data-field="ItemCode" class="text-center">Item Code</th>
								<th data-field="ItemBarcode" class="text-center">Barcode</th>
								<th data-field="ItemName" data-halign="center">Item Name</th>
								<th data-field="ItemCost" class="text-center" data-formatter="money">Cost</th>
								<th data-field="ItemPrice" class="text-center" data-formatter="money">Sale Prices</th>
								<th data-field="ItemGroupName" class="text-center">Item Group</th>
								<th data-field="ItemStock" class="text-center" data-formatter="badgeVal">Stock</th>
								<th data-field="ItemCreatedAt" class="text-center" data-formatter="dateTime">Created At</th>
								<th data-field="ItemUpdatedAt" class="text-center" data-formatter="dateTime">Last Updated</th>
								<th class="text-center" data-formatter="udOperates" data-events="operateEvents">Operates</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- items modal -->
<div id="itemModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="itemModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title text-primary" id="itemModalLabel"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="frmItem" method="POST" autocomplete="off" novalidate>
				<div class="modal-body">
					<div class="form-group">
						<input type="text" name="ItemBarcode" id="ItemBarcode" class="form-control" placeholder="Enter barcode">
					</div>
					<div class="form-group">
						<input type="text" name="ItemCode" id="ItemCode" class="form-control" placeholder="Enter item code">
					</div>
					<div class="form-group">
						<input type="text" name="ItemName" id="ItemName" class="form-control" placeholder="Enter item name" required>
					</div>
					<div class="form-group input-group mb-3">
						<div class="input-group-prepend">
							<span class="input-group-text">฿</span>
						</div>
						<input type="text" name="ItemCost" id="ItemCost" class="form-control" data-smk-type="currency" placeholder="Enter cost">
					</div>
					<div class="form-group input-group mb-3">
						<div class="input-group-prepend">
							<span class="input-group-text">฿</span>
						</div>
						<input type="text" name="ItemPrice" id="ItemPrice" class="form-control" data-smk-type="currency" required placeholder="Enter sale prices" required>
					</div>
					<div class="form-group">
						<select name="ItemGroupID" id="ItemGroupID" class="form-control" required>
							<option value="">Select Item Group</option>
							<?php foreach ($groups as $group) { ?>
								<option value="<?= $group->ItemGroupID; ?>"><?= $group->ItemGroupName; ?></option>
							<?php  } ?>
						</select>
					</div>
					<div class="form-group">
						<input type="number" name="ItemStock" id="ItemStock" class="form-control" placeholder="Enter stock (can be blank)">
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="ItemID" id="ItemID">
					<button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- end -->

<script>
	//========================== initail ===========================//
	var table = $('#dataTable');
	var actions;

	function initTable() {
		table.bootstrapTable('destroy').bootstrapTable({
			exportDataType: 'all',
			exportOptions: {
				ignoreColumn: [11],
				fileName: 'items'
			}
		})
	}

	$(function() {
		initTable();
	});


	//========================= operates ===============================//
	window.operateEvents = {
		'click .btn-edit': function(e, value, row, index) {
			var itemId = row.ItemID;
			onUpdate(itemId);
		},

		'click .btn-del': function(e, value, row, index) {
			var itemId = row.ItemID;
			onDelete(itemId);
		}
	}

	function onAdd() {
		actions = 'add';

		$('#itemModal').modal('show');
		$('.modal-title').html('<i class="fas fa-plus-circle"></i> Add New Item');
	}

	function onUpdate(ItemId) {
		actions = 'update';

		$.getJSON("<?= site_url('ItemController/FetchOneItem') ?>/" + ItemId, function(data) {
			if (!$.isEmptyObject(data)) {
				$('#itemModal').modal('show');
				$('.modal-title').html('<i class="fas fa-edit"></i> Update Item');
				$('#ItemID').val(data.ItemID);
				$('#ItemCode').val(data.ItemCode);
				$('#ItemBarcode').val(data.ItemBarcode);
				$('#ItemName').val(data.ItemName);
				$('#ItemCost').val(numeral(data.ItemCost).format('0,0.00'));
				$('#ItemPrice').val(numeral(data.ItemPrice).format('0,0.00'));
				$('#ItemGroupID').val(data.ItemGroupID);
				$('#ItemStock').val(data.ItemStock);
			}
		});
	}

	function onDelete(ItemID) {
		deletion('ItemController/InitDeleteItem', ItemID);
	}

	$(function() {
		$('#frmItem').submit(function(e) {
			e.preventDefault();

			if ($(this).smkValidate()) {
				var formData = $(this).serialize();
				var url;

				if (actions == 'update') {
					url = "<?= site_url('ItemController/InitUpdateItem') ?>";
				} else {
					url = "<?= site_url('ItemController/InitInsertItem') ?>";
				}

				$.ajax({
					method: 'POST',
					url: url,
					data: formData
				}).done(function(data) {
					if (data.status === 'success') {
						smkAlert(data.message, data.status);
						$('#itemModal').modal('hide');
						table.bootstrapTable('refresh');
					} else {
						smkAlert('Something went wrong, please contact IT!', 'danger');
					}
				}).fail(function(jqXHR, textStatus, errorThrown) {
					smkAlert('Something went wrong, please contact IT!', 'danger');
				});
			}
		});
	});


	$(function() {
		$('#itemModal').on('hide.bs.modal', function() {
			$('#frmItem').smkClear();
		});
	});
</script>