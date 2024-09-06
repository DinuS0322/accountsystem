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

$txtChargeName = filter_var($_POST['txtChargeName'], FILTER_DEFAULT);
$txtChargesType = filter_var($_POST['txtChargesType'], FILTER_DEFAULT);
$txtAmount = filter_var($_POST['txtAmount'], FILTER_DEFAULT);
$txtChargeOption = filter_var($_POST['txtChargeOption'], FILTER_DEFAULT);
$txtPenalty = filter_var($_POST['txtPenalty'], FILTER_DEFAULT);
$txtOverride = filter_var($_POST['txtOverride'], FILTER_DEFAULT);
$txtActive = filter_var($_POST['txtActive'], FILTER_DEFAULT);

try {
    $stmt = $db->prepare('INSERT INTO `tbl_loan_charge` (date,chargeName,chargeType,amount,chargeOption,penalty,override,active )
                                        VALUES (:date,:chargeName, :chargeType, :amount, :chargeOption, :penalty, :override, :active)');

    $stmt->execute([
        ':date' => $curDate,
        ':chargeName' => $txtChargeName,
        ':chargeType' => $txtChargesType,
        ':amount' => (int)$txtAmount,
        ':chargeOption' => $txtChargeOption,
        ':penalty' => $txtPenalty,
        ':override' => $txtOverride,
        ':active' => $txtActive
    ]);

    $activityStmt = $db->prepare('INSERT INTO `tbl_activity_log` (userName, currentDate, userEmail, userType, activity, activityPath)
                                        VALUES (:userName,:currentDate,:userEmail,:userType,:activity,:activityPath) ');

    $activityStmt->execute([
        ':userName' => $userFirstName,
        ':currentDate' => $curDate,
        ':userEmail' => $userEmail,
        ':userType' => $userType,
        ':activity' => 'Create Charge Data',
        ':activityPath' => $txtChargeName

    ]);
    echo 'success';
} catch (PDOException $e) {
    echo $e->getMessage();
}
