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
    $approvalStatus = 2;
    $updateSavingStmt = $db->prepare('UPDATE tbl_account_transfer SET requestApproval=?, secoundApprovalBy=?, secoundApprovalDate=? where id = ? ');

    $updateSavingStmt->bindParam(1, $approvalStatus);
    $updateSavingStmt->bindParam(2, $userFirstName);
    $updateSavingStmt->bindParam(3, $curDate);
    $updateSavingStmt->bindParam(4, $txtTransferId);
    $updateSavingStmt->execute();

    $sqlPMethod = "SELECT * FROM tbl_account_transfer where id= $txtTransferId";
    $stmt = $db->prepare($sqlPMethod);
    $stmt->execute();
    if ($row = $stmt->fetchObject()) {
        $id = $row->id;
        $transferDate = $row->transferDate;
        $fromAccount = $row->fromAccount;
        $fromAccountStatus = $row->fromAccountStatus;
        $toAccount = $row->toAccount;
        $requestApproval = $row->requestApproval;
        $transferAmount = $row->transferAmount;
        $reason = $row->reason;
        $transferNote = $row->transferNote;
        $firstApprovalDate = $row->firstApprovalDate;
        $firstApprovalBy = $row->firstApprovalBy;
        $secoundApprovalDate = $row->secoundApprovalDate;
        $secoundApprovalBy = $row->secoundApprovalBy;
        $toAccount = $row->toAccount;
        $toAccountStatus = $row->toAccountStatus;
    }

    $frombalance = $db->query("SELECT `balance` FROM tbl_account WHERE id = $fromAccount")->fetchColumn(0);
    $tobalance = $db->query("SELECT `balance` FROM tbl_account WHERE id = $toAccount")->fetchColumn(0);

    $frombalance = (float)$frombalance;
    $tobalance = (float)$tobalance;

    $finaltransferAmount = (float)$transferAmount;

    $finalfrombalance = $frombalance - $finaltransferAmount;
    $finaltobalance = $tobalance + $finaltransferAmount;

    $finalfrombalance = (string)$finalfrombalance;
    $finaltobalance = (string)$finaltobalance;

    $updateFromStmt = $db->prepare('UPDATE tbl_account SET balance=? where id = ? ');

    $updateFromStmt->bindParam(1, $finalfrombalance);
    $updateFromStmt->bindParam(2, $fromAccount);
    $updateFromStmt->execute();

    $updateToStmt = $db->prepare('UPDATE tbl_account SET balance=? where id = ? ');

    $updateToStmt->bindParam(1, $finaltobalance);
    $updateToStmt->bindParam(2, $toAccount);
    $updateToStmt->execute();


    $stmtTRansferFrom = $db->prepare('INSERT INTO `tbl_transfer_history` (date, account, accountStatus, transferAmount, transferNote, reason, transferDate, firstApprovalBy, firstApprovalDate, secoundApprovalBy, secoundApprovalDate, accountBalance )
    VALUES (:date, :account, :accountStatus, :transferAmount, :transferNote, :reason, :transferDate, :firstApprovalBy, :firstApprovalDate, :secoundApprovalBy, :secoundApprovalDate, :accountBalance)');

    $stmtTRansferFrom->execute([
        ':date' => $curDate,
        ':account' => $fromAccount,
        ':accountStatus' => $fromAccountStatus,
        ':transferAmount' => $transferAmount,
        ':transferNote' => $transferNote,
        ':reason' => $reason,
        ':transferDate' => $transferDate,
        ':firstApprovalBy' => $firstApprovalBy,
        ':firstApprovalDate' => $firstApprovalDate,
        ':secoundApprovalBy' => $secoundApprovalBy,
        ':secoundApprovalDate' => $secoundApprovalDate,
        ':accountBalance' => $finalfrombalance
    ]);

    $stmtTRansferTo = $db->prepare('INSERT INTO `tbl_transfer_history` (date, account, accountStatus, transferAmount, transferNote, reason, transferDate, firstApprovalBy, firstApprovalDate, secoundApprovalBy, secoundApprovalDate, accountBalance )
    VALUES (:date, :account, :accountStatus, :transferAmount, :transferNote, :reason, :transferDate, :firstApprovalBy, :firstApprovalDate, :secoundApprovalBy, :secoundApprovalDate, :accountBalance)');

    $stmtTRansferTo->execute([
        ':date' => $curDate,
        ':account' => $toAccount,
        ':accountStatus' => $toAccountStatus,
        ':transferAmount' => $transferAmount,
        ':transferNote' => $transferNote,
        ':reason' => $reason,
        ':transferDate' => $transferDate,
        ':firstApprovalBy' => $firstApprovalBy,
        ':firstApprovalDate' => $firstApprovalDate,
        ':secoundApprovalBy' => $secoundApprovalBy,
        ':secoundApprovalDate' => $secoundApprovalDate,
        ':accountBalance' => $finaltobalance
    ]);

  

    $activityStmt = $db->prepare('INSERT INTO `tbl_activity_log` (userName, currentDate, userEmail, userType, activity, activityPath)
    VALUES (:userName,:currentDate,:userEmail,:userType,:activity,:activityPath) ');

    $activityStmt->execute([
        ':userName' => $userFirstName,
        ':currentDate' => $curDate,
        ':userEmail' => $userEmail,
        ':userType' => $userType,
        ':activity' => 'Update Transfer Approval',
        ':activityPath' => "Transection Id:" . $txtTransferId

    ]);

    echo 'success';
} catch (PDOException $e) {
    echo $e->getMessage();
}
