<?php
require '../../config.php';

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
$curDate = date('Y-m-d');

$searchMember = filter_var($_POST['searchMember'], FILTER_DEFAULT);
$savingAccount = filter_var($_POST['savingAccount'], FILTER_DEFAULT);
$txtAmount = filter_var($_POST['txtAmount'], FILTER_DEFAULT);
$txtReason = filter_var($_POST['txtReason'], FILTER_DEFAULT);
$randomeCode = randomCode(10);
$currDateTime = date('d-m-Y H:i:s');
try {

    $savingAmount = $db->query("SELECT `savingAmount` FROM tbl_savings WHERE savingId = $savingAccount")->fetchColumn(0);
    $savingAmount = (float)$savingAmount;

    if ($savingAmount > (float)$txtAmount) {
        $productId = $db->query("SELECT `productId` FROM tbl_savings WHERE savingId = $savingAccount")->fetchColumn(0);
        $years = $db->query("SELECT `years` FROM tbl_savings_product WHERE id = $productId")->fetchColumn(0);
        if ($years == '') {
            $stmt = $db->prepare('INSERT INTO `tbl_savings_withdrawal` (date,withdrawalId, clientId, savingId, amount, reason, status, officerId,firstApprovalOfficerId, firstreason,secondApprovalOfficerId, secondReason,thirdApprovalOfficerId, accountId,thridReason,chequeNo)
            VALUES (:date,:withdrawalId, :clientId, :savingId, :amount, :reason, :status, :officerId, :firstApprovalOfficerId, :firstreason, :secondApprovalOfficerId, :secondReason, :thirdApprovalOfficerId , :accountId, :thridReason, :chequeNo )');

            $stmt->execute([
                ':date' => $curDate,
                ':withdrawalId' => $randomeCode,
                ':clientId' =>$searchMember,
                ':savingId' => $savingAccount,
                ':amount' => $txtAmount,
                ':reason' => $txtReason,
                ':status' => 0,
                ':officerId' => $SESS_USER_ID,
                ':firstApprovalOfficerId' => '',
                ':firstreason' => '',
                ':secondApprovalOfficerId' => '',
                ':secondReason' => '',
                ':thirdApprovalOfficerId' => '',
                ':accountId' => '',
                ':thridReason' => '',
                ':chequeNo' => ''
            ]);

            $activityStmt = $db->prepare('INSERT INTO `tbl_activity_log` (userName, currentDate, userEmail, userType, activity, activityPath)
            VALUES (:userName,:currentDate,:userEmail,:userType,:activity,:activityPath) ');

            $activityStmt->execute([
                ':userName' => $userFirstName,
                ':currentDate' => $curDate,
                ':userEmail' => $userEmail,
                ':userType' => $userType,
                ':activity' => 'Create Withdrawal',
                ':activityPath' => 'WIthdrawal Id - ' . $randomeCode

            ]);
            echo 'success';
        } else {
            $savingDate = $db->query("SELECT `date` FROM tbl_savings WHERE savingId = $savingAccount")->fetchColumn(0);
            $date1 = new DateTime($savingDate);
            $currentDate = new DateTime($curDate);
            $interval = $date1->diff($currentDate);
            $totalYears = $interval->y;
            if ($totalYears >= $years) {
                $stmt = $db->prepare('INSERT INTO `tbl_savings_withdrawal` (date,withdrawalId, clientId, savingId, amount, reason, status, officerId,firstApprovalOfficerId, firstreason,secondApprovalOfficerId, secondReason,thirdApprovalOfficerId, accountId,thridReason,chequeNo)
                VALUES (:date,:withdrawalId, :clientId, :savingId, :amount, :reason, :status, :officerId, :firstApprovalOfficerId, :firstreason, :secondApprovalOfficerId, :secondReason, :thirdApprovalOfficerId , :accountId, :thridReason, :chequeNo )');
    
                $stmt->execute([
                    ':date' => $curDate,
                    ':withdrawalId' =>$randomeCode,
                    ':clientId' => $searchMember,
                    ':savingId' => $savingAccount,
                    ':amount' => $txtAmount,
                    ':reason' => $txtReason,
                    ':status' => 0,
                    ':officerId' => $SESS_USER_ID,
                    ':firstApprovalOfficerId' => '',
                    ':firstreason' => '',
                    ':secondApprovalOfficerId' => '',
                    ':secondReason' => '',
                    ':thirdApprovalOfficerId' => '',
                    ':accountId' => '',
                    ':thridReason' => '',
                    ':chequeNo' => ''
                ]);
    
                $activityStmt = $db->prepare('INSERT INTO `tbl_activity_log` (userName, currentDate, userEmail, userType, activity, activityPath)
                VALUES (:userName,:currentDate,:userEmail,:userType,:activity,:activityPath) ');
    
                $activityStmt->execute([
                    ':userName' => $userFirstName,
                    ':currentDate' => $curDate,
                    ':userEmail' => $userEmail,
                    ':userType' => $userType,
                    ':activity' => 'Create Withdrawal',
                    ':activityPath' => 'WIthdrawal Id - ' . $randomeCode
    
                ]);
                echo 'success';
            }else{
                echo 'error years';
            }
        }
    } else {
        echo 'error amount';
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
