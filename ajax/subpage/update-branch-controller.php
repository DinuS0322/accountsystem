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

$txtBranchName = filter_var($_POST['txtBranchName'], FILTER_DEFAULT);
$branchId = filter_var($_POST['branchId'], FILTER_DEFAULT);
$txtNotes = filter_var($_POST['txtNotes'], FILTER_DEFAULT);
$txtActive = filter_var($_POST['txtActive'], FILTER_DEFAULT);
$txtBinNumber = filter_var($_POST['txtBinNumber'], FILTER_DEFAULT);
$currDateTime = date('Y-m-d');
try {
    $updateSavingStmt = $db->prepare('UPDATE tbl_branch SET branchName=?, notes=?, binNumber=?, active=? where id = ? ');

    $updateSavingStmt->bindParam(1, $txtBranchName);
    $updateSavingStmt->bindParam(2, $txtNotes);
    $updateSavingStmt->bindParam(3, $txtBinNumber);
    $updateSavingStmt->bindParam(4, $txtActive);
    $updateSavingStmt->bindParam(5, $branchId);
    $updateSavingStmt->execute();

    $activityStmt = $db->prepare('INSERT INTO `tbl_activity_log` (userName, currentDate, userEmail, userType, activity, activityPath)
                                        VALUES (:userName,:currentDate,:userEmail,:userType,:activity,:activityPath) ');

    $activityStmt->execute([
        ':userName' => $userFirstName,
        ':currentDate' => $curDate,
        ':userEmail' => $userEmail,
        ':userType' => $userType,
        ':activity' => 'Update Branch',
        ':activityPath' => $txtBranchName

    ]);

    echo 'success';
} catch (PDOException $e) {
    echo $e->getMessage();
}
