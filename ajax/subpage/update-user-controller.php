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

$txtFirstName = filter_var($_POST['txtFirstName'], FILTER_DEFAULT);
$txtLastName = filter_var($_POST['txtLastName'], FILTER_DEFAULT);
$txtGender = filter_var($_POST['txtGender'], FILTER_DEFAULT);
$txtNumber = filter_var($_POST['txtNumber'], FILTER_DEFAULT);
$txtUserId = filter_var($_POST['txtUserId'], FILTER_DEFAULT);
$txtAddress = filter_var($_POST['txtAddress'], FILTER_DEFAULT);
$currDateTime = date('Y-m-d');
try {
    $updateSavingStmt = $db->prepare('UPDATE tbl_users SET firstName=?, lastName=?, gender=?, phoneNumber=?, address=? where id = ? ');

    $updateSavingStmt->bindParam(1, $txtFirstName);
    $updateSavingStmt->bindParam(2, $txtLastName);
    $updateSavingStmt->bindParam(3, $txtGender);
    $updateSavingStmt->bindParam(4, $txtNumber);
    $updateSavingStmt->bindParam(5, $txtAddress);
    $updateSavingStmt->bindParam(6, $txtUserId);

    $updateSavingStmt->execute();

    $activityStmt = $db->prepare('INSERT INTO `tbl_activity_log` (userName, currentDate, userEmail, userType, activity, activityPath)
                                        VALUES (:userName,:currentDate,:userEmail,:userType,:activity,:activityPath) ');

    $activityStmt->execute([
        ':userName' => $userFirstName,
        ':currentDate' => $curDate,
        ':userEmail' => $userEmail,
        ':userType' => $userType,
        ':activity' => 'Update User',
        ':activityPath' => $txtFirstName

    ]);

    echo 'success';
} catch (PDOException $e) {
    echo $e->getMessage();
}
