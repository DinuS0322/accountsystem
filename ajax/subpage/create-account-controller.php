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

$txtAccountName = filter_var($_POST['txtAccountName'], FILTER_DEFAULT);
$txtBranchName = filter_var($_POST['txtBranchName'], FILTER_DEFAULT);
$txtAccountNumber = filter_var($_POST['txtAccountNumber'], FILTER_DEFAULT);
$txtRegisterDate = filter_var($_POST['txtRegisterDate'], FILTER_DEFAULT);
$txtStatus = filter_var($_POST['txtStatus'], FILTER_DEFAULT);
$txtNote = filter_var($_POST['txtNote'], FILTER_DEFAULT);

try {
    $stmt = $db->prepare('INSERT INTO `tbl_account` (date, accountName, branchName, accountNumber, registerDate, accountStatus, notes, defaultStatus, balance )
                                        VALUES (:date,:accountName, :branchName, :accountNumber, :registerDate, :accountStatus, :notes, :defaultStatus, :balance)');

    $stmt->execute([
        ':date' => $curDate,
        ':accountName' => $txtAccountName,
        ':branchName' => $txtBranchName,
        ':accountNumber' => $txtAccountNumber,
        ':registerDate' => $txtRegisterDate,
        ':accountStatus' => $txtStatus,
        ':notes' => $txtNote,
        ':defaultStatus' => 0,
        ':balance' => "0"
    ]);

    $activityStmt = $db->prepare('INSERT INTO `tbl_activity_log` (userName, currentDate, userEmail, userType, activity, activityPath)
                                        VALUES (:userName,:currentDate,:userEmail,:userType,:activity,:activityPath) ');

    $activityStmt->execute([
        ':userName' => $userFirstName,
        ':currentDate' => $curDate,
        ':userEmail' => $userEmail,
        ':userType' => $userType,
        ':activity' => 'Create Account',
        ':activityPath' => $txtAccountName

    ]);
    echo 'success';
} catch (PDOException $e) {
    echo $e->getMessage();
}
