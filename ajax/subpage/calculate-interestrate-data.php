<?php
require '../../config.php';
$statusCode = 0;
$statusMsg = '';

// CSRF Protection
if (!isset($_POST['CSRF_TOKEN']) || !isset($_SESSION['CSRF_TOKEN']) || ($_POST['CSRF_TOKEN'] <> $_SESSION['CSRF_TOKEN'])) {
    echo '<p class="error">Error: invalid form submission</p>';
    header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
    exit;
}
// CSRF Protection

$txtDefaultInterestRate = filter_var($_POST['txtDefaultInterestRate'], FILTER_DEFAULT);
$searchProduct = filter_var($_POST['searchProduct'], FILTER_DEFAULT);

$sql = "SELECT * FROM tbl_loan_product where id=$searchProduct";
$stmt = $db->prepare($sql);
$stmt->execute();

try {

    if ($row = $stmt->fetchObject()) {
        $MinimumInterestRate = $row->MinimumInterestRate;
        $MaximumInterestRate = $row->MaximumInterestRate;
        $MinimumInterestRate = floatval($MinimumInterestRate);
        $MaximumInterestRate = floatval($MaximumInterestRate);
        $txtDefaultInterestRate = floatval($txtDefaultInterestRate);
        if ($MinimumInterestRate <= $txtDefaultInterestRate && $MaximumInterestRate >= $txtDefaultInterestRate) {
            $statusCode = 200;
        } else {
            $statusCode = 502;
        }
    } else {
        $statusCode = 502;
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}


$responce = new stdClass();
$responce->code = $statusCode;
$responce->message = $statusMsg;
$responce->MaximumInterestRate = $MaximumInterestRate;
$responce->MinimumInterestRate = $MinimumInterestRate;

print_r(json_encode($responce, true));
