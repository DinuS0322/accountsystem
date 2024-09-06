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
$currentDate = date('Y-m-d');


$txtSelectAccount = filter_var($_POST['txtSelectAccount'], FILTER_DEFAULT);
$txtDepositAmount = filter_var($_POST['txtDepositAmount'], FILTER_DEFAULT);
$balance = $db->query("SELECT `balance` FROM tbl_account WHERE id = $txtSelectAccount")->fetchColumn(0);
$accountName = $db->query("SELECT `accountName` FROM tbl_account WHERE id = $txtSelectAccount")->fetchColumn(0);

$balance = (float)$balance;
$txtDepositAmount = (float)$txtDepositAmount;

$lastTotal = $balance + $txtDepositAmount;
$lastTotal = (string)$lastTotal;

try {

    $updateSavingStmt = $db->prepare('UPDATE tbl_account SET balance=? where id = ? ');

    $updateSavingStmt->bindParam(1, $lastTotal);
    $updateSavingStmt->bindParam(2, $txtSelectAccount);
    $updateSavingStmt->execute();


    $stmtTRansferFrom = $db->prepare('INSERT INTO `tbl_transfer_history` (transferDate, account, accountStatus, reason, accountBalance, transferAmount )
    VALUES (:transferDate, :account, :accountStatus,  :reason, :accountBalance, :transferAmount)');

    $stmtTRansferFrom->execute([
        ':transferDate' => $currentDate,
        ':account' => $txtSelectAccount,
        ':accountStatus' => 'Credit',
        ':reason' => 'Deposit' ,
        ':accountBalance' => $lastTotal,
        ':transferAmount' => $txtDepositAmount,
    ]);

    $activityStmt = $db->prepare('INSERT INTO `tbl_activity_log` (userName, currentDate, userEmail, userType, activity, activityPath)
                                        VALUES (:userName,:currentDate,:userEmail,:userType,:activity,:activityPath) ');

    $activityStmt->execute([
        ':userName' => $userFirstName,
        ':currentDate' => $curDate,
        ':userEmail' => $userEmail,
        ':userType' => $userType,
        ':activity' => 'Update account balance',
        ':activityPath' => $accountName . '-' . $txtDepositAmount

    ]);
    echo 'success';
} catch (PDOException $e) {
    echo $e->getMessage();
}
