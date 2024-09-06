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
$txtFirstName = filter_var($_POST['txtFirstName'], FILTER_DEFAULT);
$txtLastName = filter_var($_POST['txtLastName'], FILTER_DEFAULT);
$txtAdminAddress = filter_var($_POST['txtAdminAddress'], FILTER_DEFAULT);
$txtAdminPhone = filter_var($_POST['txtAdminPhone'], FILTER_DEFAULT);
//Geting Data


try {
    $stmt = $db->prepare('UPDATE tbl_users SET firstName=? , lastName=? , phoneNumber=?, address=? where id = ?');
    $stmt->bindParam(1, $txtFirstName);
    $stmt->bindParam(2, $txtLastName);
    $stmt->bindParam(3, $txtAdminPhone);
    $stmt->bindParam(4, $txtAdminAddress);
    $stmt->bindParam(5, $SESS_USER_ID);
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
