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

$txtTransferReason = filter_var($_POST['txtTransferReason'], FILTER_DEFAULT);
$txtFromAccount = filter_var($_POST['txtFromAccount'], FILTER_DEFAULT);
$txtToAccount = filter_var($_POST['txtToAccount'], FILTER_DEFAULT);
$txtAvailableBalance = filter_var($_POST['txtAvailableBalance'], FILTER_DEFAULT);
$txtTransferAmount = filter_var($_POST['txtTransferAmount'], FILTER_DEFAULT);
$txtTransferNote = filter_var($_POST['txtTransferNote'], FILTER_DEFAULT);
$txtTransferDate = filter_var($_POST['txtTransferDate'], FILTER_DEFAULT);
$fromAccountName = $db->query("SELECT `accountName` FROM tbl_account WHERE id = $txtFromAccount")->fetchColumn(0);
$toAccountName = $db->query("SELECT `accountName` FROM tbl_account WHERE id = $txtToAccount")->fetchColumn(0);
$currDateTime = date('Y-m-d');
try {
    $stmt = $db->prepare('INSERT INTO `tbl_account_transfer` (date, reason, fromAccount, fromAccountStatus, toAccount, toAccountStatus, availableBalance, transferAmount, transferNote, transferDate, requestApproval)
                                        VALUES (:date, :reason,  :fromAccount, :fromAccountStatus, :toAccount, :toAccountStatus, :availableBalance, :transferAmount, :transferNote, :transferDate, :requestApproval) ');

    $stmt->execute([
        ':date' => $curDate,
        ':reason' => $txtTransferReason,
        ':fromAccount' => $txtFromAccount,
        ':fromAccountStatus' => 'Debit',
        ':toAccount' => $txtToAccount,
        ':toAccountStatus' => 'Credit',
        ':availableBalance' => $txtAvailableBalance,
        ':transferAmount' => $txtTransferAmount,
        ':transferNote' => $txtTransferNote,
        ':transferDate' => $txtTransferDate,
        ':requestApproval' => 0,
    ]);

    $activityStmt = $db->prepare('INSERT INTO `tbl_activity_log` (userName, currentDate, userEmail, userType, activity, activityPath)
                                        VALUES (:userName,:currentDate,:userEmail,:userType,:activity,:activityPath) ');

    $activityStmt->execute([
        ':userName' => $userFirstName,
        ':currentDate' => $curDate,
        ':userEmail' => $userEmail,
        ':userType' => $userType,
        ':activity' => 'Create Transfer',
        ':activityPath' => 'From -' . $fromAccountName . ' To -' . $toAccountName
    ]);

    echo 'success';
} catch (PDOException $e) {
    echo $e->getMessage();
}
