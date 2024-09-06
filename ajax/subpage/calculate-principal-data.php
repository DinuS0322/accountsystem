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

$txtDefaultPrincipal = filter_var($_POST['txtDefaultPrincipal'], FILTER_DEFAULT);
$searchProduct = filter_var($_POST['searchProduct'], FILTER_DEFAULT);

$sql = "SELECT * FROM tbl_loan_product where id=$searchProduct";
$stmt = $db->prepare($sql);
$stmt->execute();

try {

    if ($row = $stmt->fetchObject()) {
        $minimumPrincipal = $row->minimumPrincipal;
        $maximumPrincipal = $row->maximumPrincipal;
        $minimumPrincipal = floatval($minimumPrincipal);
        $maximumPrincipal = floatval($maximumPrincipal);
        $txtDefaultPrincipal = floatval($txtDefaultPrincipal);
        if($minimumPrincipal <= $txtDefaultPrincipal && $maximumPrincipal >= $txtDefaultPrincipal){
            $statusCode = 200;
        }else{
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
$responce->maximumPrincipal = $maximumPrincipal;
$responce->minimumPrincipal = $minimumPrincipal;

print_r(json_encode($responce, true));
