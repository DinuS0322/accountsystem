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

$txtTransferId = filter_var($_POST['txtTransferId'], FILTER_DEFAULT);

try {
    $approvalStatus = 1;
    $updateSavingStmt = $db->prepare('UPDATE tbl_account_transfer SET requestApproval=?, firstApprovalBy=?, firstApprovalDate=? where id = ? ');

    $updateSavingStmt->bindParam(1, $approvalStatus);
    $updateSavingStmt->bindParam(2, $userFirstName);
    $updateSavingStmt->bindParam(3, $curDate);
    $updateSavingStmt->bindParam(4, $txtTransferId);
    $updateSavingStmt->execute();

    $activityStmt = $db->prepare('INSERT INTO `tbl_activity_log` (userName, currentDate, userEmail, userType, activity, activityPath)
    VALUES (:userName,:currentDate,:userEmail,:userType,:activity,:activityPath) ');

    $activityStmt->execute([
        ':userName' => $userFirstName,
        ':currentDate' => $curDate,
        ':userEmail' => $userEmail,
        ':userType' => $userType,
        ':activity' => 'Update Transfer Approval',
        ':activityPath' => "Transection Id:".$txtTransferId

    ]);

    echo 'success';
} catch (PDOException $e) {
    echo $e->getMessage();
}
