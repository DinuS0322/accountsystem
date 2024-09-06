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

$loanId = filter_var($_POST['loanId'], FILTER_DEFAULT);
$writeoffReason = filter_var($_POST['writeoffReason'], FILTER_DEFAULT);
$currDateTime = date('Y-m-d');
try {

    $sqlPMethod = "SELECT * FROM tbl_loan_reschedule where LoanId = $loanId AND status='unpaid'";
    $stmt = $db->prepare($sqlPMethod);
    $stmt->execute();
    while ($row = $stmt->fetchObject()) {
        $id = $row->id;
        $statusUpdate = 'writeoff';
        $updateSavingStmt = $db->prepare('UPDATE tbl_loan_reschedule SET status=? where id = ? ');

        $updateSavingStmt->bindParam(1, $statusUpdate);
        $updateSavingStmt->bindParam(2, $id);

        $updateSavingStmt->execute();
    }

    $interestWiseAcc = $db->prepare('INSERT INTO `tbl_writeoff` (date, loanId, userName,reason)
    VALUES (:date,:loanId, :userName, :reason) ');

    $interestWiseAcc->execute([
        ':date' => $currDateTime,
        ':loanId' => $loanId,
        ':userName' => $userFirstName,
        ':reason' => $writeoffReason,
    ]);


    $activityStmt = $db->prepare('INSERT INTO `tbl_activity_log` (userName, currentDate, userEmail, userType, activity, activityPath)
                                        VALUES (:userName,:currentDate,:userEmail,:userType,:activity,:activityPath) ');

    $activityStmt->execute([
        ':userName' => $userFirstName,
        ':currentDate' => $curDate,
        ':userEmail' => $userEmail,
        ':userType' => $userType,
        ':activity' => 'Update status',
        ':activityPath' => 'writeOff - ' . $loanId

    ]);

    echo 'success';
} catch (PDOException $e) {
    echo $e->getMessage();
}
