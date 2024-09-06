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

$txtBranchId = filter_var($_POST['txtBranchId'], FILTER_DEFAULT);
$clientId = filter_var($_POST['clientId'], FILTER_DEFAULT);
$txtTitle = filter_var($_POST['txtTitle'], FILTER_DEFAULT);
$txtFirstName = filter_var($_POST['txtFirstName'], FILTER_DEFAULT);
$txtLastName = filter_var($_POST['txtLastName'], FILTER_DEFAULT);
$txtAddress = filter_var($_POST['txtAddress'], FILTER_DEFAULT);
$txtGender = filter_var($_POST['txtGender'], FILTER_DEFAULT);
$txtMaritalStatus = filter_var($_POST['txtMaritalStatus'], FILTER_DEFAULT);
$txtPhoneNumber = filter_var($_POST['txtPhoneNumber'], FILTER_DEFAULT);
$txtOldAccountNumber = filter_var($_POST['txtOldAccountNumber'], FILTER_DEFAULT);
$txtProfession = filter_var($_POST['txtProfession'], FILTER_DEFAULT);
$txtLoanOfficerId = filter_var($_POST['txtLoanOfficerId'], FILTER_DEFAULT);
$folowerName = filter_var($_POST['folowerName'], FILTER_DEFAULT);
$followerAddress = filter_var($_POST['followerAddress'], FILTER_DEFAULT);
$currDateTime = date('Y-m-d');
try {
    $updateSavingStmt = $db->prepare('UPDATE tbl_client SET branchId=?, title=?, firstName=?, lastName=?, cientAddress=?, gender=?, maritalStatus=?, phoneNumber=?, oldAccountNumber=?, profession=?, loanOfficerId=?, folowerName=?, followerAddress=? where id = ? ');

    $updateSavingStmt->bindParam(1, $txtBranchId);
    $updateSavingStmt->bindParam(2, $txtTitle);
    $updateSavingStmt->bindParam(3, $txtFirstName);
    $updateSavingStmt->bindParam(4, $txtLastName);
    $updateSavingStmt->bindParam(5, $txtAddress);
    $updateSavingStmt->bindParam(6, $txtGender);
    $updateSavingStmt->bindParam(7, $txtMaritalStatus);
    $updateSavingStmt->bindParam(8, $txtPhoneNumber);
    $updateSavingStmt->bindParam(9, $txtOldAccountNumber);
    $updateSavingStmt->bindParam(10, $txtProfession);
    $updateSavingStmt->bindParam(11, $txtLoanOfficerId);
    $updateSavingStmt->bindParam(12, $folowerName);
    $updateSavingStmt->bindParam(13, $followerAddress);
    $updateSavingStmt->bindParam(14, $clientId);
    $updateSavingStmt->execute();

    $activityStmt = $db->prepare('INSERT INTO `tbl_activity_log` (userName, currentDate, userEmail, userType, activity, activityPath)
                                        VALUES (:userName,:currentDate,:userEmail,:userType,:activity,:activityPath) ');

    $activityStmt->execute([
        ':userName' => $userFirstName,
        ':currentDate' => $curDate,
        ':userEmail' => $userEmail,
        ':userType' => $userType,
        ':activity' => 'Update Client',
        ':activityPath' => $txtFirstName

    ]);

    echo 'success';
} catch (PDOException $e) {
    echo $e->getMessage();
}
