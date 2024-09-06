<?php
require_once 'config.php';
// CSRF Protection
if (strtoupper($_SERVER['REQUEST_METHOD']) === 'GET') {
    $_SESSION['CSRF_TOKEN'] =  md5(uniqid(mt_rand(), true));
}
// CSRF Protection

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">
    <title>Account System | Login</title>

    <?php
    require_once 'common-header.php';
    ?>
</head>

<body id="gbsfd-body-wrap" class="nav-fixed bg-light page-5 gbsfd-bg-main gbsfd-dashboard-wrap gbsfd-bg-main gbsfd-have-bg gbsfd_dashboard">
    <!-- Layout wrapper-->
    <div id="layoutAuthentication">
        <!-- Layout content-->
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-sm-5 col-md-6 col-lg-5">
                            <div class="card card-raised shadow-10 mt-5 mt-xl-10 mb-4">
                                <div class="row g-0">
                                    <div class="col-xl-12">
                                        <div class="card-body p-5" id="divLoginFormCard">

                                            <!--Logo-->
                                            <div class="text-center">
                                                <img class="mb-3 login-logo" src="/images/logo.png" alt="System Logo" height="50%" width="50%" />
                                            </div>
                                            <!--Logo-->

                                            <!-- Login submission form-->
                                            <div id="login-form">
                                                <div class="mb-4 form-floating">
                                                    <input class="form-control no-space" id="txtLoginEmail" type="text" placeholder="Email" autocomplete="off">
                                                    <label for="txtLoginEmail">Email</label>
                                                </div>
                                                <div class="input-group mb-4">
                                                    <div class="form-floating">
                                                        <input class="form-control" id="txtLoginPassword" type="password" placeholder="Password" autocomplete="off">
                                                        <label for="txtLoginPassword">Password</label>
                                                    </div>
                                                    <span class="input-group-text passwordVisibility" data-visibility='0' data-target='#txtLoginPassword'>
                                                        <i class="material-icons">visibility_off</i>
                                                    </span>
                                                </div>
                                                <div class="mb-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input" id="checkLoginRemeber" type="checkbox" value="1">
                                                        <label class="form-check-label" for="gbsfd-remmber-me">Remember password</label>
                                                    </div>
                                                </div>

                                                <div class="form-group d-flex align-items-center justify-content-center mt-4 mb-0">
                                                    <button id="btnLogin" class="btn btn-success">
                                                        Login
                                                    </button>
                                                </div>
                                            </div>
                                            <!-- Login submission form-->

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <!-- Layout content-->

        
    </div>

    <!-- CSRF Protection -->
    <input type="hidden" name="CSRF_TOKEN" id="CSRF_TOKEN" value="<?= isset($_SESSION['CSRF_TOKEN']) ? $_SESSION['CSRF_TOKEN'] : '' ?>">
    <!-- CSRF Protection -->
</body>

<?php
require_once 'common-footer.php';
?>

<!-- Custom JS -->
<script src="js/custom/login.js?v=<?= $cashClear ?>"></script>
<!-- Custom JS -->

</html>