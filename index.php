<?php
// hello
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

require_once 'config.php';


if (!isset($_SESSION['SESS_USER_ID'])) {
	header('Location: logout.php');
}

// CSRF Protection
if (strtoupper($_SERVER['REQUEST_METHOD']) === 'GET') {
	$_SESSION['CSRF_TOKEN'] =  md5(uniqid(mt_rand(), true));
}
// CSRF Protection

$SESS_USER_ID = $_SESSION['SESS_USER_ID'];
$SESS_USER_NAME = $_SESSION['SESS_USER_NAME'];
$SESS_USER_LAST_NAME = $_SESSION['SESS_USER_LAST_NAME'];
$SESS_USER_EMAIL = $_SESSION['SESS_USER_EMAIL'];
$SESS_USER_TYPE = $_SESSION['SESS_USER_TYPE'];
$SESS_USER_NIC = $_SESSION['SESS_USER_NIC'];
$SESS_USER_BRANCH = $_SESSION['SESS_USER_BRANCH'];
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
	<title>Account System</title>

	<!-- Custom fonts for this template-->
	<link href="css/googleFonts.css" rel="stylesheet" type="text/css">
	<link href="source/fontawesome-free/css/all.min.css" rel="stylesheet">
	<link href="source/layout/assets/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
	<link href="source/layout/assets/boxicons/css/boxicons.min.css" rel="stylesheet">
	<link href="source/layout/assets/remixicon/remixicon.css" rel="stylesheet">
	<link href="source/login-theme/login-theme-icon.css" rel="stylesheet">
	<!-- Custom fonts for this template-->

	<!-- Bootsrap CSS -->
	<link href="source/layout/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="source/layout/css/style.css" rel="stylesheet">
	<!-- Bootsrap CSS -->

	<!-- Confirm Js CSS -->
	<link href="source/confirm/confirm.min.css" rel="stylesheet">

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">

	<!-- Selectize CSS -->
	<link href="source/selectize/css/selectize.bootstrap5.css" rel="stylesheet">

	<!-- Select2 CSS -->
	<link href="source/select2/css/select2.min.css" rel="stylesheet">

	<!--Nice Select2 CSS -->
	<link href="source/niceSelect2/css/nice-select2.css" rel="stylesheet">

	<!-- Country Select CSS -->
	<link href="source/country-select/css/countrySelect.css" rel="stylesheet">

	<!-- Telephone Select CSS -->
	<link href="source/telephone-select/css/intlTelInput.css" rel="stylesheet">

	<!--Toastify-->
	<link rel="stylesheet" href="source/toastify/toastify.css">

	<!--WaitMe-->
	<link rel="stylesheet" href="source/waitMe-31/waitMe.css">

	<!--Cropper CSS-->
	<link rel="stylesheet" href="source/cropper/croppie.css">

	<!-- include summernote css/js -->
	<link rel="stylesheet" href="source/summernote/summernote-lite.min.css">

	<!-- data tables css  -->
	<link rel="stylesheet" type="text/css" href="source/datatables/datatables.min.css" />

	<!-- Jquery-ui css  -->
	<link rel="stylesheet" type="text/css" href="source/jquery-ui/jquery-ui.css" />

	<!--Custom CSS File Add-->
	<link href='css/custom.css?v=<?= $cashClear ?>' rel='stylesheet' />

	<!-- include Basic-Canvas-Paint css/js -->
	<link rel="stylesheet" href="source/Basic-Canvas-Paint/css/bcPaint.css">
	<link rel="stylesheet" href="source/Basic-Canvas-Paint/css/bcPaint.mobile.css">
	<link rel="stylesheet" href="source/Basic-Canvas-Paint/css/demo-page.css">


	<!-- covert excel and pdf in table  -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>

</head>

<body>

	<!-- ======= Header ======= -->
	<?php
	if ($SESS_USER_TYPE == 'superAdmin'  || $SESS_USER_TYPE == 'admin' || $SESS_USER_TYPE == 'branchOfficer' || $SESS_USER_TYPE == 'director' || $SESS_USER_TYPE == 'financeManager') {
		include 'include/admin-top-bar.php';
	} else  if ($SESS_USER_TYPE == 'fieldOfficer') {
		include 'include/fieldofficer-top-bar.php';
	} else  if ($SESS_USER_TYPE == 'Client') {
		include 'include/client-top-bar.php';
	}
	?>
	<!-- ======= End Header =======  -->

	<!-- ======= Sidebar ======= -->
	<?php
	if ($SESS_USER_TYPE == 'superAdmin' || $SESS_USER_TYPE == 'admin' || $SESS_USER_TYPE == 'director' || $SESS_USER_TYPE == 'financeManager' || $SESS_USER_TYPE == 'branchOfficer') {
		include 'include/admin-side-bar.php';
	} else if ($SESS_USER_TYPE == 'fieldOfficer') {
		include 'include/fieldofficer-side-bar.php';
	} else if ($SESS_USER_TYPE == 'Client') {
		include 'include/client-side-bar.php';
	}
	?>
	<!-- End Sidebar-->

	<!-- Main JS Files -->
	<script src="source/layout/assets/apexcharts/apexcharts.min.js"></script>
	<script src="source/layout/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="source/jquery/jquery.min.js"></script>
	<script src="source/jquery-easing/jquery.easing.min.js"></script>
	<script src="source/layout/assets/chart.js/chart.min.js"></script>
	<script src="source/layout/assets/echarts/echarts.min.js"></script>
	<script src='js/moment.min.js'></script>
	<script src="source/layout/js/main.js"></script>
	<!-- Main JS Files -->

	<!-- Google Charts -->
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<!-- Google Charts -->

	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

	<!-- Confirm JS -->
	<script src="source/confirm/confirm.min.js"></script>

	<!-- Selectize JS -->
	<script src="source/selectize/js/standalone/selectize.js"></script>

	<!-- Select2 JS -->
	<script src="source/select2/js/select2.min.js"></script>

	<!-- Nice Select2 JS -->
	<script src="source/niceSelect2/js/nice-select2.js"></script>

	<!-- Country Select JS -->
	<script src="source/country-select/js/countrySelect.js"></script>

	<!-- Telephone Select JS -->
	<script src="source/telephone-select/js/intlTelInput.js"></script>

	<!--Toastify-->
	<script src="source/toastify/toastify.js"></script>

	<!--WaitMe-->
	<script src="source/waitMe-31/waitMe.js"></script>

	<!--Cropper Js-->
	<script src="source/cropper/croppie.js"></script>

	<!-- signature pad -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.3.4/signature_pad.js" integrity="sha512-j36pYCzm3upwGd6JGq6xpdthtxcUtSf5yQJSsgnqjAsXtFT84WH8NQy9vqkv4qTV9hK782TwuHUTSwo2hRF+/A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.3.4/signature_pad.min.js" integrity="sha512-Mtr2f9aMp/TVEdDWcRlcREy9NfgsvXvApdxrm3/gK8lAMWnXrFsYaoW01B5eJhrUpBT7hmIjLeaQe0hnL7Oh1w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

	<!--Fullcalendar Js-->
	<script src="source/full-calendar/dist/index.global.min.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/vfs_fonts.js"></script>

	<!-- summernote Js -->
	<script src="source/summernote/summernote-lite.min.js"></script>

	<!-- Typed Js -->
	<script src="source/typed/typed.min.js"></script>

	<!-- Datatable Js -->
	<script type="text/javascript" src="source/datatables/datatables.min.js"></script>

	<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>


	<!-- Basic-Canvas-Paint Js -->
	<script type="text/javascript" src="source/Basic-Canvas-Paint/js/bcPaint.js"></script>

	<!-- Jquery-ui Js -->
	<script type="text/javascript" src="source/jquery-ui/jquery-ui.js"></script>

	<!-- Custom JS -->
	<script src='js/custom/custom-functions.js?v=<?= $cashClear ?>'></script>
	<!-- Custom JS -->

	<!--Loaders-->
	<div id="mainloader" class="loader">
		<div class="load-spinner">
			<span class="spinner"></span>
		</div>
	</div>
	<!--Loaders-->

	<main id="main" class="main">
		<div class="container-fluid">
			<?php
			if (isset($_GET['page'])) {
				$page = filter_var($_GET['page'], FILTER_SANITIZE_URL);
				if (file_exists("pages/$page.php")) {
					// $access	= $LMS->authorization($userType, $userId, $page);
					$access = true;
					if ($access == true) {
						include("pages/$page.php");
					} else {
						include("404.php");
					}
				} else {
					include("404.php");
				}
			} else {
				include("pages/dashboard.php");
			}
			?>
		</div>
		<br> <br>
	</main>
	<!-- CSRF Protection -->
	<input type="hidden" name="CSRF_TOKEN" id="CSRF_TOKEN" value="<?= isset($_SESSION['CSRF_TOKEN']) ? $_SESSION['CSRF_TOKEN'] : '' ?>">
	<!-- CSRF Protection -->

	<!-- <footer class="footer custom-footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <p class="text-muted">© <?php echo date("Y"); ?> account system. All Rights Reserved.</p>
            </div>
        </div>
    </div>
</footer> -->
	
</body>

</html>