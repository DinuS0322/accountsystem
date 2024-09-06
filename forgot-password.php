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
    <title>MedicalPro | Forgot Password</title>

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
                        <div class="col-sm-5">
                            <div class="card card-raised shadow-10 mt-5 mt-xl-10 mb-4">
                                <div class="row g-0">
                                    <div class="col-xl-12">
                                        <div class="card-body p-5">

                                            <!--Logo-->
                                            <div class="text-center">
                                                <img class="mb-3 register-logo" src="/images/food-club-logo.png" alt="System Logo" />
                                            </div>
                                            <!--Logo-->

                                            <div id="gbsfd-form">

                                                <div id="partOne">
                                                    <div class="mb-4 form-floating gbsfd-username">
                                                        <input id="txtForgotEmail" type="email" class="form-control no-space" placeholder="Email Address" autocomplete="off">
                                                        <label for="txtForgotEmail">Email Address</label>
                                                    </div>
                                                    <div class="text-center">
                                                        <button id="btnResetPassword" class="btn btn-primary">
                                                            Reset password
                                                        </button>
                                                    </div>
                                                </div>

                                                <div id="partTwo" class="hidden">
                                                    <div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show" id="otpSuccessSentAlert" role="alert">
                                                        OTP Sent Successfully
                                                    </div>
                                                    <p>
                                                        Please enter the OTP (One-Time Password) sent to your registered email address in the field below to complete your Password reset.
                                                    </p>
                                                    <div class="mb-4 form-floating gbsfd-username">
                                                        <input id="txtVerifyOtp" type="text" class="form-control no-space" placeholder="Enter OTP" autocomplete="off">
                                                        <label for="txtVerifyOtp">Enter OTP</label>
                                                    </div>
                                                    <div class="text-center">
                                                        <button id="btnVerifyOTP" class="btn btn-primary">
                                                            Verify OTP
                                                        </button>
                                                    </div>
                                                </div>

                                                <div id="partThree" class="hidden">
                                                    <div class="mb-4 form-floating gbsfd-password">
                                                        <input class="form-control" id="txtNewPassword" type="password" placeholder="Password" autocomplete="off">
                                                        <label for="txtNewPassword">New Password</label>
                                                        <small id="passwordHelpInline" class="text-muted"> (Must be at least 8 characters long)</small>
                                                        <i class="material-icons gbsfd-visibility passwordVisibility" data-visibility='0' data-target='#txtNewPassword'>visibility_off</i>
                                                    </div>

                                                    <div class="mb-4 form-floating gbsfd-password">
                                                        <input class="form-control" id="txtReNewPassword" type="password" placeholder="Password" autocomplete="off">
                                                        <label for="txtReNewPassword">Retype New Password</label>
                                                        <i class="material-icons gbsfd-visibility passwordVisibility" data-visibility='0' data-target='#txtReNewPassword'>visibility_off</i>
                                                    </div>

                                                    <div class="text-center">
                                                        <button id="btnUpdatePassword" class="btn btn-primary">
                                                            Update password
                                                        </button>
                                                    </div>
                                                </div>

                                                <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                                    <span>
                                                        Already have an account?
                                                        <a class="text-decoration-none login-here" href="/login.php">Login here </a>
                                                    </span>
                                                </div>
                                            </div>

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

        <!-- Layout footer-->
        <div id="layoutAuthentication_footer" style="z-index:9;">
            <footer class="p-4">
                <div class="d-flex flex-column flex-sm-row align-items-center justify-content-between small">
                    <div class="me-sm-3 mb-2 mb-sm-0">
                        <div class="fw-500 text-white">MedicalPro 2023 | Genesis Logistics Marketing &amp; Technologies Pte Ltd</div>
                    </div>
                    <div class="ms-sm-3">
                        <a class="fw-500 text-decoration-none link-white" href="https://medicalproasia.com/privacy-policy/">Privacy Policy</a>
                        <a class="fw-500 text-decoration-none link-white mx-4" href="https://medicalproasia.com/terms-of-use/">Terms of use</a>
                    </div>
                </div>
            </footer>
        </div>
        <!-- Layout footer-->

    </div>

    <!-- CSRF Protection -->
    <input type="hidden" name="CSRF_TOKEN" id="CSRF_TOKEN" value="<?= isset($_SESSION['CSRF_TOKEN']) ? $_SESSION['CSRF_TOKEN'] : '' ?>">
    <!-- CSRF Protection -->
</body>

<?php
require_once 'common-footer.php';
?>
<!-- Custom JS -->
<script src="js/custom/forgot-password.js?v=<?= $cashClear ?>"></script>
<!-- Custom JS -->

</html>