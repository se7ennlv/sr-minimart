<style>
	/* width */
	::-webkit-scrollbar {
		width: 22px;
	}

	/* Track */
	::-webkit-scrollbar-track {
		box-shadow: inset 0 0 5px grey;
		border-radius: 10px;
	}

	/* Handle */
	::-webkit-scrollbar-thumb {
		background: #858796;
		border-radius: 10px;
	}

	/* Handle on hover */
	::-webkit-scrollbar-thumb:hover {
		background: #717384;
	}

	.table-money th,
	.table-money td {
		padding: 0rem;
	}
</style>

<body id="page-top">
	<div id="wrapper">
		<div id="content-wrapper" class="d-flex flex-column">
			<div id="content">
				<nav class="navbar navbar-expand navbar-light bg-white mb-2 static-top shadow py-0">
					<button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
						<i class="fa fa-bars"></i>
					</button>

					<h3 class="text-primary font-weight-bold">SR Mini Mart</h3>&emsp13;&emsp13;
					<i class="fas fa-grip-lines-vertical fa-2x"></i>
					<div>
						<a class="btn smk-fullscreen" href="#"><span class="fas fa-compress fa-2x"></span></a>
					</div>

					<ul class="navbar-nav ml-auto">
						<li class="nav-item dropdown no-arrow">
							<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown">
								<span class="text-gray-600">
									<i class="fas fa-circle text-success"></i> User Online: <?= $this->session->userdata('userFname'); ?> <?= $this->session->userdata('userLname'); ?>
								</span>
							</a>
							<div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
								<a class="dropdown-item" href="#" data-toggle="modal" data-target="#changePwdModal">
									<i class="fas fa-key fa-sm fa-fw mr-2 text-gray-400"></i>
									Change Password
								</a>

								<a class="dropdown-item" href="<?= site_url('AppController/ExecuteLogout'); ?>">
									<i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
									Logout
								</a>
							</div>
						</li>
					</ul>
				</nav>

				<div class="container-fluid mb-2">
					<div class="row">
						<div class="col-xl-7 col-md-7">
							<div class="card border-left-primary shadow">
								<div class="card-body">
									<div class="row">
										<div class="col-md-4">
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text text-primary"><i class="fas fa-th-large"></i></span>
												</div>
												<select name="itemGroupId" id="itemGroupId" class="form-control" onchange="getItems();">
													<option value="">All</option>
													<?php foreach ($groups as $group) { ?>
														<option value="<?= $group->ItemGroupID; ?>"><?= $group->ItemGroupName; ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class="col-md-4">
											<div class="input-group mb-3">
												<div class="input-group-prepend">
													<span class="input-group-text text-primary"><i class="fas fa-binoculars"></i></span>
												</div>
												<input type="text" name="searchItem" id="searchItem" class="form-control" placeholder="Item name" autocomplete="off">
											</div>
										</div>
										<div class="col-md-4">
											<div class="input-group mb-3">
												<div class="input-group-prepend">
													<span class="input-group-text text-primary"><i class="fas fa-barcode"></i></span>
												</div>
												<input type="text" name="searchByBarcode" id="searchByBarcode" class="form-control" placeholder="Barcode" autocomplete="off">
											</div>
										</div>
									</div>

									<div class="overflow-auto">
										<div style="max-height: 68vh" id="itemList">
											<!-- dynamic data -->
										</div>
									</div>

								</div>
							</div>
						</div>

						<div class="col-xl-5 col-md-5">
							<div class="card border-right-primary shadow h-100" style="background-image: linear-gradient(-225deg, #FFFEFF 0%, #D7FFFE 100%);">
								<div class="card-body">
									<div class="row">
										<table class="table table-responsive table-no-border table-sm table-money mb-0">
											<tbody>
												<tr>
													<td class="text-right" data-toggle="modal" data-target="#empModal">
														<h3 class="hand"><span class="badge badge-info"><i class="fas fa-users"></i> EMP:</span></h3>
													</td>
													<td>
														<h5><span class="badge text-info" title="" id="empInfo"></span></h6>
													</td>
												</tr>
												<tr>
													<td>
														<select name="discType" id="discType" class="form-control" onchange="onDiscChange();">
															<option value="0">Disc %</option>
															<option value="1">Disc Baht(THB)</option>
														</select>
													</td>
													<td>
														<h4 data-toggle="modal" data-target="#numeralModal" data-btn="disc" class="hand">
															<span class="badge text-secondary" id="discTotal">0</span>
														</h4>
													</td>
												</tr>
												<tr>
													<td class="text-right">
														<h4><span class="badge badge-warning">Grand Total:</span></h4>
													</td>
													<td>
														<h2>
															<span class="badge text-success" id="grandTotalAfterDisc">0.00</span>
															<s class="badge text-danger d-none" id="grandTotal">0.00</s>
														</h2>
													</td>
												</tr>
											</tbody>
										</table>
									</div>

									<div class="row">
										<div class="col">
											<button class="btn btn-success btn-lg btn-block" onclick="showPaymentModal();">Payments</button>
										</div>
									</div>

									<div class="row mt-3">
										<div class="col overflow-auto" style="height: 43vh">
											<table class="table table-item table-sm mb-0">
												<tbody id="itemSales">
													<!-- dynamic data -->
												</tbody>
											</table>
										</div>
									</div>

									<hr class="mt-0">

									<div class="row">
										<div class="col">
											<div class="btn-group">
												<div class="btn-group" role="group">
													<a href="#" class="btn btn-secondary btn-icon-split btn-lg dropdown-toggle" id="btnGroupDrop1" data-toggle="dropdown">
														<span class="icon text-white-50">
															<i class="fab fa-hire-a-helper"></i>
														</span>
														<span class="text">Helpers</span>
													</a>
													<div class="dropdown-menu text-center p-2" style="min-width: 12rem;">
														<a class="btn btn-secondary btn-lg mb-3" href="#" data-toggle="modal" data-target="#lastInvModal">Last (5) Invoice</a>
														<a class="btn btn-secondary btn-lg" href="#" onclick="confirmPass();">Open Cash DW</a>
													</div>
												</div>
											</div>
											<a href="#" onclick="removeAllItem();" class="btn btn-danger btn-lg btn-icon-split float-right">
												<span class="icon text-white-50">
													<i class="fas fa-sync-alt"></i>
												</span>
												<span class="text">Clear</span>
											</a>
										</div>
									</div>

								</div>
							</div>
						</div>

					</div>
				</div>
			</div>

			<footer class="sticky-footer bg-white py-0">
				<div class="container-fluid fixed-bottom py-3">
					<div class="copyright text-center">
						<strong class="float-left">Version 1.0.0</strong>
						<strong class="float-right">Developed by IT</strong>
					</div>
				</div>
			</footer>

			<div id="changePwdModal" class="modal fade" tabindex="-1" role="dialog">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Change Password</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form action="#" name="frmChgPass" id="frmChgPass" method="POST" autocomplete="off" novalidate>
							<div class="modal-body">
								<div class="form-group">
									<input type="password" class="form-control" name="NewPass" placeholder="Enter New Password" required>
								</div>
							</div>
							<div class="modal-footer">
								<button type="submit" class="btn btn-primary btn-lg">Save changes</button>
								<button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Close</button>
							</div>
						</form>
					</div>
				</div>
			</div>

		</div>

	</div>

	<a class="scroll-to-top rounded" href="#page-top">
		<i class="fas fa-angle-up"></i>
	</a>

</body>

</html>