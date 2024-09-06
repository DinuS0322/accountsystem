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
$txtInterestWiseReason = filter_var($_POST['txtInterestWiseReason'], FILTER_DEFAULT);
$currDateTime = date('Y-m-d');
try {

    $sqlPMethod = "SELECT * FROM tbl_loan_reschedule where LoanId = $loanId AND status='unpaid'";
    $stmt = $db->prepare($sqlPMethod);
    $stmt->execute();
    $interestwiseam = 0;
    while ($row = $stmt->fetchObject()) {
        $id = $row->id;

        $interest = $row->interest;
        $interest = str_replace(',', '', $interest);
        $interest = (float)$interest;
        $statusUpdate = 'writeoff';

        $amountToPay = $row->amountToPay;
        $amountToPay = str_replace(',', '', $amountToPay);
        $amountToPay = (float)$amountToPay;
        $amountToPay = $amountToPay - $interest;

        $balance = $row->balance;
        $balance = str_replace(',', '', $balance);
        $balance = (float)$balance;
        $balanceCheck = (float)$balance;
        $balance = $balance - $interest;

        $interestUpdate = '0';

        $interestwiseam = $interest + $interestwiseam;

        if ($balanceCheck > 1) {
            $updateSavingStmt = $db->prepare('UPDATE tbl_loan_reschedule SET interest=?, amountToPay=?, balance=? where id = ? ');

            $updateSavingStmt->bindParam(1, $interestUpdate);
            $updateSavingStmt->bindParam(2, $amountToPay);
            $updateSavingStmt->bindParam(3, $balance);
            $updateSavingStmt->bindParam(4, $id);

            $updateSavingStmt->execute();
        } else {
            $updateSavingStmt = $db->prepare('UPDATE tbl_loan_reschedule SET interest=?, amountToPay=? where id = ? ');

            $updateSavingStmt->bindParam(1, $interestUpdate);
            $updateSavingStmt->bindParam(2, $amountToPay);
            $updateSavingStmt->bindParam(3, $id);

            $updateSavingStmt->execute();
        }
    }

    $interestWiseAcc = $db->prepare('INSERT INTO `tbl_interestwise` (date, interestwiseamount, loanId, userName,reason)
    VALUES (:date,:interestwiseamount,:loanId, :userName, :reason) ');

    $interestWiseAcc->execute([
        ':date' => $currDateTime,
        ':interestwiseamount' => (string)$interestwiseam,
        ':loanId' => $loanId,
        ':userName' => $userFirstName,
        ':reason' => $txtInterestWiseReason,
    ]);



    $activityStmt = $db->prepare('INSERT INTO `tbl_activity_log` (userName, currentDate, userEmail, userType, activity, activityPath)
                                        VALUES (:userName,:currentDate,:userEmail,:userType,:activity,:activityPath) ');

    $activityStmt->execute([
        ':userName' => $userFirstName,
        ':currentDate' => $curDate,
        ':userEmail' => $userEmail,
        ':userType' => $userType,
        ':activity' => 'Update status',
        ':activityPath' => 'interest wise - ' . $loanId

    ]);

    echo 'success';
} catch (PDOException $e) {
    echo $e->getMessage();
}
