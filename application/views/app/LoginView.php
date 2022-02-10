<?php
defined('BASEPATH') or exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SR Mini Mart</title>

    <!-- css core -->
    <link href="<?= base_url() . "assets/"; ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url() . "assets/"; ?>css/sb-admin-2.css?v=1.0.5" rel="stylesheet">
    <link href="<?= base_url() . "assets/"; ?>vendor/smokejs/css/smoke.min.css" rel="stylesheet">
    <link href="<?= base_url() . "assets/"; ?>css/style.css?v=1.0.2" rel="stylesheet">
</head>

<body class="" id="login">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-8 col-md-8 col-xs-10 mt-5">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0" style="background-image: linear-gradient(to top, #dfe9f3 0%, white 100%);">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block text-center my-auto">
                                <p>
                                    <i class="fas fa-cart-arrow-down text-warning active fa-10x rotate-n-15"></i>
                                </p>
                            </div>
                            <div class="col-lg-6">
                                <div class="p-4">
                                    <img src="<?= base_url(); ?>/files/logo/logo.png" alt="Logo" class="rounded mx-auto d-block img-logo" style="width: 145px; height: 130px;" />
                                    <h3 class="text-primary font-weight-bold text-center mt-2" style="font-family: 'Segoe Script'"><i>SR Mini Mart</i></h3>
                                    <form class="user mt-3" name="frm-login" id="frm-login" method="POST" autocomplete="off" novalidate="off">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" name="Username" id="Username" placeholder="Enter Your ID" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" name="Password" id="Password" placeholder="Enter Password" required>
                                        </div>

                                        <hr>

                                        <button type="submit" class="btn btn-primary btn-user btn-block">Login</button>

                                        <div class="text-center mt-5">
                                            <a class="small">Version 1.0.0 | Last update (16, July 2020)</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- js core -->
    <script src="<?= base_url() . "assets/"; ?>vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url() . "assets/"; ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() . "assets/"; ?>vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="<?= base_url() . "assets/"; ?>js/sb-admin-2.min.js"></script>
    <script src="<?= base_url() . "assets/"; ?>vendor/blockUI/jquery.blockUI.js?v=1.0.0"></script>
    <script src="<?= base_url() . "assets/"; ?>vendor/smokejs/js/smoke.js?v=1.0.5"></script>
    <script src="<?= base_url() . "assets/"; ?>js/global-script.js"></script>

    <script>
        $(document).ready(function() {
            $('form').on('submit', function(e) {
                e.preventDefault();

                if ($(this).smkValidate()) {
                    var formData = $(this).serialize();

                    $.ajax({
                        type: 'POST',
                        url: '<?= base_url('AppController/ExecuteLogin'); ?>',
                        data: formData,
                        beforeSend: function() {
                            blockUI('Checking...');
                        }
                    }).done(function(data) {
                        unblockUI();

                        if (data.status == 'success') {
                            smkAlert(data.message, data.status);

                            if (data.IsSaleman == 1) {
                                window.location = "<?= site_url('TransController/ShopView'); ?>";
                            } else {
                                window.location = "<?= site_url('InitController'); ?>";
                            }
                        } else {
                            smkAlert(data.message, 'danger');
                        }
                    }).fail(function(jqXHR, textStatus, errorThrown) {
                        smkAlert('Something went wrong, please contact IT!', 'danger');
                    });
                }
            });
        });
    </script>

</body>

</html>