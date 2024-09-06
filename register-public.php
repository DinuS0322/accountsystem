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
    <title>Food Club Asia | Register</title>

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
                        <div class="col-xxl-7 col-xl-10">
                            <div class="card card-raised shadow-10 mt-5 mt-xl-10 mb-5">
                                <div class="card-body p-5">

                                    <!--Logo-->
                                    <div class="text-center">
                                        <img class="mb-3 register-logo" src="/images/food-club-logo.png" alt="System Logo" />
                                        <h4 class="strong">Public Registration</h4>
                                    </div>
                                    <!--Logo-->

                                    <!-- Submission form-->
                                    <div id="gbsfd-form" class="mb-5">
                                        <div class="row">
                                            <div class="mb-2 col-md-6">
                                                <label for="txtPublicFirstName" class="col-md-12 pl-0 pt-2 strong">
                                                    First Name <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" id="txtPublicFirstName" class="form-control" autocomplete="off">
                                            </div>
                                            <div class="mb-2 col-md-6">
                                                <label for="txtPublicLastName" class="col-md-12 pl-0 pt-2 strong">
                                                    Last Name <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" id="txtPublicLastName" class="form-control" autocomplete="off">
                                            </div>
                                            <div class="mb-2 col-md-6">
                                                <label for="txtPublicEmail" class="col-md-12 pl-0 pt-2 strong">
                                                    Email <span class="text-danger">*</span>
                                                </label>
                                                <input type="email" id="txtPublicEmail" class="form-control no-space" autocomplete="off">
                                            </div>
                                            <div class="mb-2 col-md-6">
                                                <label for="txtPublicPhone" class="col-md-12 pl-0 pt-2 strong">
                                                    Phone
                                                </label>
                                                <input type="text" id="txtPublicPhone" class="form-control teleSelector" autocomplete="off">
                                            </div>
                                            <div class="mb-2 col-md-6">
                                                <label for="txtPublicCountry" class="col-md-12 pl-0 pt-2 strong">
                                                    Country
                                                </label>
                                                <input type="text" id="txtPublicCountry" class="form-control countrySelector" autocomplete="off">
                                            </div>
                                            <div class="mb-2 col-md-6">
                                                <label for="txtPublicCity" class="col-md-12 pl-0 pt-2 strong">
                                                    City / Location
                                                </label>
                                                <select type="text" id="txtPublicCity" class="form-control">
                                                </select>
                                            </div>
                                            <div class="mb-2 col-md-6">
                                                <label for="txtPublicPostCode" class="col-md-12 pl-0 pt-2 strong">
                                                    Postal Code
                                                </label>

                                                <div class="input-group">
                                                    <input type="number" id="txtPublicPostCode" class="form-control" autocomplete="off">
                                                    <span class="input-group-text pointer" id="btnSyncSglocate">
                                                        <i class="fas fa-sync-alt"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mb-2 col-md-6">
                                                <label for="txtPublicAddress" class="col-md-12 pl-0 pt-2 strong">
                                                    Address
                                                </label>
                                                <input type="text" id="txtPublicAddress" class="form-control" autocomplete="off">
                                            </div>
                                            <!-- <div class="mb-2 col-md-6">
                                                <label for="txtMainSpec" class="col-md-12 pl-0 pt-2 strong">
                                                    Main Specialization <span class="text-danger">*</span>
                                                </label>
                                                <select type="text" id="txtMainSpec" class="form-control selectize">
                                                    <option value="" readonly>-- Select --</option>
                                                    <?php
                                                    // $dirCatPath = 'json/dircat.json';
                                                    // $dirCatFile = fopen($dirCatPath, 'r');
                                                    // $dirCat = fread($dirCatFile, filesize($dirCatPath));
                                                    // fclose($dirCatFile);
                                                    // $dirCatJson = json_decode($dirCat, true);

                                                    // foreach ($dirCatJson as $cat) {
                                                    //     $catogery = $cat['catName'];
                                                    //     echo "<option value='$catogery'>$catogery</option>";
                                                    // }
                                                    ?>
                                                </select>
                                            </div> -->
                                            <!-- <div class="mb-2 col-md-6">
                                                <label for="txtSubSpec" class="col-md-12 pl-0 pt-2 strong">
                                                    Sub Specialization
                                                </label>
                                                <input type="text" id="txtSubSpec" class="form-control" autocomplete="off">
                                            </div> -->

                                            <div class="col-lg-6 float-left mb-2">
                                                <label for="txtPublicPassword" class="strong pt-2">
                                                    Password
                                                </label>
                                                <!-- <small id="passwordHelpInline" class="text-muted"> (Must be at least 8 characters long)</small> -->

                                                <div class="input-group">
                                                    <input type="password" id="txtPublicPassword" class="form-control" autocomplete="off">
                                                    <span class="input-group-text passwordVisibility" data-visibility='0' data-target='#txtPublicPassword'>
                                                        <i class="material-icons">visibility_off</i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 float-left mb-2">
                                                <label for="txtPublicRePassword" class="strong pt-2">
                                                    Retype Password
                                                </label>

                                                <div class="input-group">
                                                    <input type="password" id="txtPublicRePassword" class="form-control" autocomplete="off">
                                                    <span class="input-group-text passwordVisibility" data-visibility='0' data-target='#txtPublicRePassword'>
                                                        <i class="material-icons">visibility_off</i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 mt-2 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="checkPublicAgree" value="agree">
                                                    <label class="form-check-label align-middle" for="checkPublicAgree">
                                                        I agree to the <a href="#" target="_blank" class="text-decoration-none fw-500">Terms and Conditions</a>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <div class="col">
                                                <span class="d-block">
                                                    Already have an account?
                                                    <a class="text-decoration-none login-here" href="/login.php">Login here </a>
                                                </span>
                                            </div>
                                            <div class="col text-end">
                                                <button id="btnCreatePublicAccount" class="btn btn-success" disabled>Create Account</button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Submission form-->

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <!-- Layout content-->

        <!-- Layout footer-->
        <!-- <div id="layoutAuthentication_footer" style="z-index:9;">
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
        </div> -->
        <!-- Layout footer-->

    </div>

    <!-- CSRF Protection -->
    <input type="hidden" name="CSRF_TOKEN" id="CSRF_TOKEN" value="<?= isset($_SESSION['CSRF_TOKEN']) ? $_SESSION['CSRF_TOKEN'] : '' ?>">
    <!-- CSRF Protection -->

    <input type="hidden" id='recaptchaResponse'>
    <input type="hidden" id='recaptchaSiteKey' value='<?= G_CAPTCHA_SITE_KEY ?>'>

    <!-- google v3 recaptcha -->
    <script src="https://www.google.com/recaptcha/api.js?render=<?= G_CAPTCHA_SITE_KEY ?>"></script>
    <!-- google v3 recaptcha -->
</body>

<?php
require_once 'common-footer.php';
?>

<!-- Custom JS -->
<script src="js/custom/register-public.js?v=<?= $cashClear ?>"></script>
<!-- Custom JS -->

</html>