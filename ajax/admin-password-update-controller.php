<?php
require_once '../config.php';
$statusCode = 0;
$statusMsg = '';
$SESS_USER_ID = $_SESSION['SESS_USER_ID'];


// CSRF Protection
if (!isset($_POST['CSRF_TOKEN']) || !isset($_SESSION['CSRF_TOKEN']) || ($_POST['CSRF_TOKEN'] <> $_SESSION['CSRF_TOKEN'])) {
    echo '<p class="error">Error: invalid form submission</p>';
    header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
    exit;
}
// CSRF Protection

//Geting Data
$txtCurrentPassword = filter_var($_POST['txtCurrentPassword'], FILTER_DEFAULT);
$txtNewPassword = filter_var($_POST['txtNewPassword'], FILTER_DEFAULT);
$hashPassword = password_hash($txtNewPassword, PASSWORD_BCRYPT);
//Geting Data





$encryptPassword = $db->query("SELECT `password` FROM tbl_users WHERE id = $SESS_USER_ID")->fetchColumn(0);
    if (password_verify($txtCurrentPassword, $encryptPassword)) {
        $stmt = $db->prepare('UPDATE tbl_users SET password=? where id = ?');
        $stmt->bindParam(1, $hashPassword);
        $stmt->bindParam(2, $SESS_USER_ID);
        $stmt->execute();
            $statusCode = 200;
            $statusMsg = "success";
       
    } else {
        $statusCode = 401;
        $statusMsg = 'wrong password';
    }

 

$responce = new stdClass();
$responce->code = $statusCode;
$responce->message = $statusMsg;
print_r(json_encode($responce, true));
