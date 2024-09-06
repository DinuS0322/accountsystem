<?php
require '../../config.php';

$sqlPMethod = "SELECT * FROM tbl_account_settings  where accountType = 'DEFAULT_ACCOUNT'";
$stmtCount = $db->prepare($sqlPMethod);
$stmtCount->execute();

if ($row = $stmtCount->fetchObject()) {
    $accountId = $row->accountId;
}

if ($stmtCount->rowCount() > 0) {

    // CSRF Protection
    if (!isset($_POST['CSRF_TOKEN']) || !isset($_SESSION['CSRF_TOKEN']) || ($_POST['CSRF_TOKEN'] <> $_SESSION['CSRF_TOKEN'])) {
        echo '<p class="error">Error: invalid form submission</p>';
        header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
        exit;
    }
    // CSRF Protection
    $SESS_USER_ID = $_SESSION['SESS_USER_ID'];
    $userFirstName = $_SESSION['SESS_USER_NAME'];
    $userEmail = $_SESSION['SESS_USER_EMAIL'];
    $userType = $_SESSION['SESS_USER_TYPE'];
    $curDate = date('d-m-Y H:i:s');
    $cDate = date('Y-m-d');

    $txtApprovalStatus = filter_var($_POST['txtApprovalStatus'], FILTER_DEFAULT);
    $txtApprovedReason = filter_var($_POST['txtApprovedReason'], FILTER_DEFAULT);
    $withdrawalIdView = filter_var($_POST['withdrawalIdView'], FILTER_DEFAULT);
    try {



        if ($txtApprovalStatus == 'approved') {

            $txtCheqeNo = filter_var($_POST['txtCheqeNo'], FILTER_DEFAULT);
            $txtSelectAccount = filter_var($_POST['txtSelectAccount'], FILTER_DEFAULT);
            $accountBalance = $db->query("SELECT `balance` FROM tbl_account WHERE id = $txtSelectAccount")->fetchColumn(0);
            $amount = $db->query("SELECT `amount` FROM tbl_savings_withdrawal WHERE withdrawalId = $withdrawalIdView")->fetchColumn(0);
            $clientId = $db->query("SELECT `clientId` FROM tbl_savings_withdrawal WHERE withdrawalId = $withdrawalIdView")->fetchColumn(0);
            $savingAmountTotal = $db->query("SELECT `savingAmountTotal` FROM tbl_savings_total WHERE clientId = $clientId")->fetchColumn(0);
            $savingId = $db->query("SELECT `savingId` FROM tbl_savings_withdrawal WHERE withdrawalId = $withdrawalIdView")->fetchColumn(0);
            $savingAmount = $db->query("SELECT `savingAmount` FROM tbl_savings WHERE savingId = $savingId")->fetchColumn(0);
            $productId = $db->query("SELECT `productId` FROM tbl_savings WHERE savingId = $savingId")->fetchColumn(0);

            if ((float)$accountBalance > (float)$amount) {
                $finalAccountBalance = (float)$accountBalance - (float)$amount;
                $finalAccountBalance = (string)$finalAccountBalance;

                $finalSavingAmountGet = (float)$savingAmount - (float)$amount;
                $finalSavingAmountGet = (string)$finalSavingAmountGet;

                $finalSavingAmount = (float)$savingAmountTotal - (float)$amount;
                $finalSavingAmount = (string)$finalSavingAmount;

                $stmtAccountSavingsGet = $db->prepare('UPDATE tbl_savings SET savingAmount=? where savingId = ?');
                $stmtAccountSavingsGet->bindParam(1, $finalSavingAmountGet);
                $stmtAccountSavingsGet->bindParam(2, $savingId);
                $stmtAccountSavingsGet->execute();


                $stmtAccountSavings = $db->prepare('UPDATE tbl_savings_total SET savingAmountTotal=? where clientId = ?');
                $stmtAccountSavings->bindParam(1, $finalSavingAmount);
                $stmtAccountSavings->bindParam(2, $clientId);
                $stmtAccountSavings->execute();

                $stmtAccount = $db->prepare('UPDATE tbl_account SET balance=? where id = ?');
                $stmtAccount->bindParam(1, $finalAccountBalance);
                $stmtAccount->bindParam(2, $txtSelectAccount);
                $stmtAccount->execute();

                $savingTransferStmt = $db->prepare('INSERT INTO `tbl_savings_history` (date, clientId, savingAmount, paymentStatus, productId, savingId)
                VALUES (:date, :clientId, :savingAmount, :paymentStatus, :productId, :savingId) ');

                $savingTransferStmt->execute([
                    ':date' => $cDate,
                    ':clientId' => $clientId,
                    ':savingAmount' => $amount,
                    ':paymentStatus' => 'Debit',
                    ':productId' => $productId,
                    ':savingId' => $savingId,

                ]);

                $accountTransferStmt = $db->prepare('INSERT INTO `tbl_transfer_history` (transferDate, account, accountStatus, transferAmount, accountBalance, reason)
            VALUES (:transferDate, :account, :accountStatus, :transferAmount, :accountBalance, :reason) ');

                $accountTransferStmt->execute([
                    ':transferDate' => $cDate,
                    ':account' => $txtSelectAccount,
                    ':accountStatus' => 'Debit',
                    ':transferAmount' => $amount,
                    ':accountBalance' => $finalAccountBalance,
                    ':reason' => 'withdrawal ID - '.$withdrawalIdView,

                ]);

                $stmt = $db->prepare('UPDATE tbl_savings_withdrawal SET status=? , thirdApprovalDate=? , thirdApprovalOfficerId=?, thridReason=?, chequeNo=?, accountId=? where withdrawalId = ?');
                $approvedusers = 4;
                $stmt->bindParam(1, $approvedusers);
                $stmt->bindParam(2, $cDate);
                $stmt->bindParam(3, $SESS_USER_ID);
                $stmt->bindParam(4, $txtApprovedReason);
                $stmt->bindParam(5, $txtCheqeNo);
                $stmt->bindParam(6, $txtSelectAccount);
                $stmt->bindParam(7, $withdrawalIdView);
                $stmt->execute();

                echo 'success';

                $activityStmt = $db->prepare('INSERT INTO `tbl_activity_log` (userName, currentDate, userEmail, userType, activity, activityPath)
                VALUES (:userName,:currentDate,:userEmail,:userType,:activity,:activityPath) ');

                $activityStmt->execute([
                    ':userName' => $userFirstName,
                    ':currentDate' => $curDate,
                    ':userEmail' => $userEmail,
                    ':userType' => $userType,
                    ':activity' => 'Update Withdrawal Status',
                    ':activityPath' => $withdrawalIdView

                ]);
            } else {
                echo 'Insufficient Balance try again';
            }
        } else if ($txtApprovalStatus == 'firstAproved') {
            $stmt = $db->prepare('UPDATE tbl_savings_withdrawal SET status=? , firstApprovalDate=? , firstApprovalOfficerId=?, firstreason=? where withdrawalId = ?');
            $approvedusers = 2;
            $stmt->bindParam(1, $approvedusers);
            $stmt->bindParam(2, $cDate);
            $stmt->bindParam(3, $SESS_USER_ID);
            $stmt->bindParam(4, $txtApprovedReason);
            $stmt->bindParam(5, $withdrawalIdView);
            $stmt->execute();
            echo 'success';

            $activityStmt = $db->prepare('INSERT INTO `tbl_activity_log` (userName, currentDate, userEmail, userType, activity, activityPath)
            VALUES (:userName,:currentDate,:userEmail,:userType,:activity,:activityPath) ');

            $activityStmt->execute([
                ':userName' => $userFirstName,
                ':currentDate' => $curDate,
                ':userEmail' => $userEmail,
                ':userType' => $userType,
                ':activity' => 'Update Withdrawal Status',
                ':activityPath' => $withdrawalIdView

            ]);
        } else if ($txtApprovalStatus == 'secondApproved') {
            $stmt = $db->prepare('UPDATE tbl_savings_withdrawal SET status=? , secondApprovalDate=? , secondApprovalOfficerId=?, secondReason=? where withdrawalId = ?');
            $approvedusers = 3;
            $stmt->bindParam(1, $approvedusers);
            $stmt->bindParam(2, $cDate);
            $stmt->bindParam(3, $SESS_USER_ID);
            $stmt->bindParam(4, $txtApprovedReason);
            $stmt->bindParam(5, $withdrawalIdView);
            $stmt->execute();
            echo 'success';

            $activityStmt = $db->prepare('INSERT INTO `tbl_activity_log` (userName, currentDate, userEmail, userType, activity, activityPath)
            VALUES (:userName,:currentDate,:userEmail,:userType,:activity,:activityPath) ');

            $activityStmt->execute([
                ':userName' => $userFirstName,
                ':currentDate' => $curDate,
                ':userEmail' => $userEmail,
                ':userType' => $userType,
                ':activity' => 'Update Withdrawal Status',
                ':activityPath' => $withdrawalIdView

            ]);
        } else if ($txtApprovalStatus == 'cancel') {
            $stmt = $db->prepare('UPDATE tbl_savings_withdrawal SET status=? , cancelDate=? , cancelOfficerId=?, cancelreason=? where withdrawalId = ?');
            $approvedusers = 5;
            $stmt->bindParam(1, $approvedusers);
            $stmt->bindParam(2, $cDate);
            $stmt->bindParam(3, $SESS_USER_ID);
            $stmt->bindParam(4, $txtApprovedReason);
            $stmt->bindParam(5, $withdrawalIdView);
            $stmt->execute();
            echo 'success';

            $activityStmt = $db->prepare('INSERT INTO `tbl_activity_log` (userName, currentDate, userEmail, userType, activity, activityPath)
            VALUES (:userName,:currentDate,:userEmail,:userType,:activity,:activityPath) ');

            $activityStmt->execute([
                ':userName' => $userFirstName,
                ':currentDate' => $curDate,
                ':userEmail' => $userEmail,
                ':userType' => $userType,
                ':activity' => 'Update Withdrawal Status',
                ':activityPath' => $withdrawalIdView

            ]);
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
} else {
    echo 0;
}
