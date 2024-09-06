<?php
require '../../config.php';

// CSRF Protection
if (!isset($_POST['CSRF_TOKEN']) || !isset($_SESSION['CSRF_TOKEN']) || ($_POST['CSRF_TOKEN'] <> $_SESSION['CSRF_TOKEN'])) {
    echo '<p class="error">Error: invalid form submission</p>';
    header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
    exit;
}
// CSRF Protection

$userFirstName = $_SESSION['SESS_USER_NAME'];
$userEmail = $_SESSION['SESS_USER_EMAIL'];
$userType = $_SESSION['SESS_USER_TYPE'];
$curDate = date('d-m-Y H:i:s');

$txtPassword = filter_var($_POST['txtPassword'], FILTER_DEFAULT);
$txtConfirmPassword = filter_var($_POST['txtConfirmPassword'], FILTER_DEFAULT);
$userId = filter_var($_POST['userId'], FILTER_DEFAULT);
$currDateTime = date('d-m-Y H:i:s');
$txtPassword = password_hash($txtPassword, PASSWORD_DEFAULT);
try {

    $stmtAccountSavingsGet = $db->prepare('UPDATE tbl_users SET password=? where id = ?');
    $stmtAccountSavingsGet->bindParam(1, $txtPassword);
    $stmtAccountSavingsGet->bindParam(2, $userId);
    $stmtAccountSavingsGet->execute();


    $activityStmt = $db->prepare('INSERT INTO `tbl_activity_log` (userName, currentDate, userEmail, userType, activity, activityPath)
                                        VALUES (:userName,:currentDate,:userEmail,:userType,:activity,:activityPath) ');

    $activityStmt->execute([
        ':userName' => $userFirstName,
        ':currentDate' => $curDate,
        ':userEmail' => $userEmail,
        ':userType' => $userType,
        ':activity' => 'Change Password Client User',
        ':activityPath' => $userId

    ]);
    echo 'success';
} catch (PDOException $e) {
    echo $e->getMessage();
}
