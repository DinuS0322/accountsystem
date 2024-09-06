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
$SESS_USER_ID = $_SESSION['SESS_USER_ID'];
$curDate = date('d-m-Y H:i:s');
$currentDate = date('Y-m-d');

$txtSelectCollectionAccount = filter_var($_POST['txtSelectCollectionAccount'], FILTER_DEFAULT);
$txtCollectionDepositAmount = filter_var($_POST['txtCollectionDepositAmount'], FILTER_DEFAULT);
$txtCollectionPayAmount = filter_var($_POST['txtCollectionPayAmount'], FILTER_DEFAULT);
$txtFieldOfficerId = filter_var($_POST['txtFieldOfficerId'], FILTER_DEFAULT);

$balance = $db->query("SELECT `balance` FROM tbl_account WHERE id = '$txtSelectCollectionAccount'")->fetchColumn(0);

$txtCollectionPayAmount = str_replace(',', '', $txtCollectionPayAmount);
$txtCollectionPayAmount = (float)$txtCollectionPayAmount;

$balance = (float)$balance;
$finalCollection = $balance + $txtCollectionPayAmount;


try {
    $sqlPMethod = "SELECT * FROM tbl_collection where officerId = '$txtFieldOfficerId'";
    $stmt = $db->prepare($sqlPMethod);
    $stmt->execute();
    $a = 0;
    while ($row = $stmt->fetchObject()) {
        $a++;
    }

    if ($a == 0) {
        $stmt = $db->prepare('INSERT INTO `tbl_collection` (officerId, date, amount )
        VALUES (:officerId,:date, :amount)');

        $stmt->execute([
            ':officerId' => $txtFieldOfficerId,
            ':date' => $currentDate,
            ':amount' => (string)$txtCollectionPayAmount
        ]);

        $stmtHistory = $db->prepare('INSERT INTO `tbl_transfer_history` (date, account, accountStatus, transferAmount, reason, accountBalance )
        VALUES (:date, :account, :accountStatus, :transferAmount, :reason, :accountBalance)');

        $stmtHistory->execute([
            ':date' => $currentDate,
            ':account' => $txtSelectCollectionAccount,
            ':accountStatus' => 'Credit',
            ':transferAmount' => (string)$txtCollectionPayAmount,
            ':reason' => 'Collection',
            ':accountBalance' => (string)$finalCollection
        ]);

        $stmtHis = $db->prepare('INSERT INTO `tbl_deposit_history` (officerId, date, amount )
        VALUES (:officerId,:date, :amount)');

        $stmtHis->execute([
            ':officerId' => $txtFieldOfficerId,
            ':date' => $currentDate,
            ':amount' => (string)$txtCollectionPayAmount
        ]);

    }else{
        $amountGet = $db->query("SELECT `amount` FROM tbl_collection WHERE officerId = '$txtFieldOfficerId'")->fetchColumn(0);
        $lastTotal = (float)$amountGet + (float)$txtCollectionPayAmount;
        $updateCollectionStmt = $db->prepare('UPDATE tbl_collection SET amount=? where officerId = ? ');
        $updateCollectionStmt->bindParam(1, $lastTotal);
        $updateCollectionStmt->bindParam(2, $txtFieldOfficerId);
        $updateCollectionStmt->execute();

        $stmtHis = $db->prepare('INSERT INTO `tbl_deposit_history` (officerId, date, amount )
        VALUES (:officerId,:date, :amount)');

        $stmtHis->execute([
            ':officerId' => $txtFieldOfficerId,
            ':date' => $currentDate,
            ':amount' => (string)$txtCollectionPayAmount
        ]);
    }

    $stmtHistory = $db->prepare('INSERT INTO `tbl_transfer_history` (date, account, accountStatus, transferAmount, reason, accountBalance )
    VALUES (:date, :account, :accountStatus, :transferAmount, :reason, :accountBalance)');

    $stmtHistory->execute([
        ':date' => $currentDate,
        ':account' => $txtSelectCollectionAccount,
        ':accountStatus' => 'Credit',
        ':transferAmount' => (string)$txtCollectionPayAmount,
        ':reason' => 'Collection',
        ':accountBalance' => (string)$finalCollection
    ]);

    $updateSavingStmt = $db->prepare('UPDATE tbl_account SET balance=?, date=? where id = ? ');

    $updateSavingStmt->bindParam(1, $finalCollection);
    $updateSavingStmt->bindParam(2, $currentDate);
    $updateSavingStmt->bindParam(3, $txtSelectCollectionAccount);
    $updateSavingStmt->execute();



    $activityStmt = $db->prepare('INSERT INTO `tbl_activity_log` (userName, currentDate, userEmail, userType, activity, activityPath)
                                        VALUES (:userName,:currentDate,:userEmail,:userType,:activity,:activityPath) ');

    $activityStmt->execute([
        ':userName' => $userFirstName,
        ':currentDate' => $curDate,
        ':userEmail' => $userEmail,
        ':userType' => $userType,
        ':activity' => 'Create Collection',
        ':activityPath' => $txtFieldOfficerId . '-' . $txtCollectionPayAmount

    ]);
    echo 'success';
} catch (PDOException $e) {
    echo $e->getMessage();
}
