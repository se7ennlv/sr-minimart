<body id="page-top">
    <div id="wrapper">
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="./">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-cart-arrow-down"></i>
                </div>
                <div class="sidebar-brand-text mx-3">SRM</div>
            </a>

            <hr class="sidebar-divider">

            <?php foreach ($mgroups as $mgroup) { ?>
                <li class="nav-item">
                    <a class="nav-link collapsed font-weight-bold" href="#" data-toggle="collapse" data-target="<?= '#collapse' . $mgroup->MGroupID; ?>" aria-expanded="true" aria-controls="<?= 'collapse' . $mgroup->MGroupID; ?>">
                        <i class="<?= $mgroup->MGroupIcons; ?> text-white"></i>
                        <span><?= $mgroup->MGroupName; ?></span>
                    </a>
                    <div id="<?= 'collapse' . $mgroup->MGroupID; ?>" class="collapse <?= $mgroup->MGroupCollapseAction; ?>" aria-labelledby="<?= 'heading' . $mgroup->MGroupID; ?>" data-parent="#accordionSidebar">
                        <div class="bg-gray-100 py-2 collapse-inner rounded">
                            <?php foreach ($menus as $menu) { ?>
                                <?php if ($mgroup->MGroupID == $menu->MenuGroupID) { ?>
                                    <a class="collapse-item" href="#" onclick="<?= $menu->MenuLinkFunction; ?>">
                                        <i class="<?= $menu->MenuIcons; ?>"></i> <?= $menu->MenuName; ?>
                                    </a>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                </li>

                <hr class="sidebar-divider">

            <?php } ?>

            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <h3 class="text-primary font-weight-bold">Savan Resorts Mini Mart</h3>

                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <i class="fas fa-circle text-success"></i> User Online:
                                </span>
                                <div class="topbar-divider d-none d-sm-block"></div>
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <?= $this->session->userdata('userFname'); ?> <?= $this->session->userdata('userLname'); ?>
                                </span>
                                <!-- <img class="img-profile rounded-circle" src="https://source.unsplash.com/QAB-WJcbgJk/60x60"> -->
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
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid" id="mainApp">