<?php
require_once '../config.php';
$statusCode = 0;
$statusMsg = '';
$SESS_USER_ID = $_SESSION['SESS_USER_ID'];

use Aws\DynamoDb\Exception\DynamoDbException;
// CSRF Protection
if (!isset($_POST['CSRF_TOKEN']) || !isset($_SESSION['CSRF_TOKEN']) || ($_POST['CSRF_TOKEN'] <> $_SESSION['CSRF_TOKEN'])) {
    echo '<p class="error">Error: invalid form submission</p>';
    header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
    exit;
}
// CSRF Protection

//Geting Data
$txtClientFirstName = filter_var($_POST['txtClientFirstName'], FILTER_DEFAULT);
$txtClientLastName = filter_var($_POST['txtClientLastName'], FILTER_DEFAULT);
//Geting Data


try {
    $stmt = $db->prepare('UPDATE tbl_client_users SET firstName=? , lastName=? where id = ?');
    $stmt->bindParam(1, $txtClientFirstName);
    $stmt->bindParam(2, $txtClientLastName);
    $stmt->bindParam(3, $SESS_USER_ID);
    $stmt->execute();
    $statusCode = 200;
    $statusMsg = "success";

} catch (Exception $e) {
    $statusCode = 500;
    $statusMsg = $e->getMessage();
}

$responce = new stdClass();
$responce->code = $statusCode;
$responce->message = $statusMsg;

print_r(json_encode($responce, true));
