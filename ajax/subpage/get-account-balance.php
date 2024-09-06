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

$txtFromAccount = filter_var($_POST['txtFromAccount'], FILTER_DEFAULT);

try {

    $balance = $db->query("SELECT `balance` FROM tbl_account WHERE id = $txtFromAccount")->fetchColumn(0);
    $balance = number_format($balance, 2);
    $statusCode = 200;


} catch (PDOException $e) {
    echo $e->getMessage();
}


$responce = new stdClass();
$responce->code = $statusCode;
$responce->message = $statusMsg;
$responce->balance = $balance;

print_r(json_encode($responce, true));
