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

$txtProductName = filter_var($_POST['txtProductName'], FILTER_DEFAULT);
$txtShortName = filter_var($_POST['txtShortName'], FILTER_DEFAULT);
$txtDescription = filter_var($_POST['txtDescription'], FILTER_DEFAULT);
$txtFund = filter_var($_POST['txtFund'], FILTER_DEFAULT);
$txtDefaultPrincipal = filter_var($_POST['txtDefaultPrincipal'], FILTER_DEFAULT);
$txtMinimumPrincipal = filter_var($_POST['txtMinimumPrincipal'], FILTER_DEFAULT);
$txtMaximumPrincipal = filter_var($_POST['txtMaximumPrincipal'], FILTER_DEFAULT);
$txtDefaultLoanTerm = filter_var($_POST['txtDefaultLoanTerm'], FILTER_DEFAULT);
$txtMinimumLoanTerm = filter_var($_POST['txtMinimumLoanTerm'], FILTER_DEFAULT);
$txtMaximumLoanTerm = filter_var($_POST['txtMaximumLoanTerm'], FILTER_DEFAULT);
$txtRepaymentFrequency = filter_var($_POST['txtRepaymentFrequency'], FILTER_DEFAULT);
$txtType = filter_var($_POST['txtType'], FILTER_DEFAULT);
$txtDefaultInterestRate = filter_var($_POST['txtDefaultInterestRate'], FILTER_DEFAULT);
$txtMinimumInterestRate = filter_var($_POST['txtMinimumInterestRate'], FILTER_DEFAULT);
$txtMaximumInterestRate = filter_var($_POST['txtMaximumInterestRate'], FILTER_DEFAULT);
$txtInterestPer = filter_var($_POST['txtInterestPer'], FILTER_DEFAULT);
$txtCharges = filter_var($_POST['txtCharges'], FILTER_DEFAULT);
$txtCreditChecks = filter_var($_POST['txtCreditChecks'], FILTER_DEFAULT);
$txtActive = filter_var($_POST['txtActive'], FILTER_DEFAULT);
$txtInterestType = filter_var($_POST['txtInterestType'], FILTER_DEFAULT);

try {
    $stmt = $db->prepare('INSERT INTO `tbl_loan_product` (date,productName,shortName,description,fund,defaultPrincipal,minimumPrincipal,maximumPrincipal,DefaultLoanTerm,MinimumLoanTerm,MaximumLoanTerm,RepaymentFrequency,DefaultInterestRate,MinimumInterestRate,MaximumInterestRate,InterestPer,Charges,CreditChecks,Active,repaymentType, interestRate)
                                        VALUES (:date,:productName,:shortName,:description,:fund,:defaultPrincipal,:minimumPrincipal,:maximumPrincipal,:DefaultLoanTerm,:MinimumLoanTerm,:MaximumLoanTerm,:RepaymentFrequency,:DefaultInterestRate,:MinimumInterestRate,:MaximumInterestRate,:InterestPer,:Charges,:CreditChecks,:Active,:repaymentType,:interestRate)');

    $stmt->execute([
        ':date' => $curDate,
        ':productName' => $txtProductName,
        ':shortName' => $txtShortName,
        ':description' => $txtDescription,
        ':fund' => $txtFund,
        ':defaultPrincipal' => $txtDefaultPrincipal,
        ':minimumPrincipal' => $txtMinimumPrincipal,
        ':maximumPrincipal' => $txtMaximumPrincipal,
        ':DefaultLoanTerm' => $txtDefaultLoanTerm,
        ':MinimumLoanTerm' => $txtMinimumLoanTerm,
        ':MaximumLoanTerm' => $txtMaximumLoanTerm,
        ':RepaymentFrequency' => $txtRepaymentFrequency,
        ':DefaultInterestRate' => $txtDefaultInterestRate,
        ':MinimumInterestRate' => $txtMinimumInterestRate,
        ':MaximumInterestRate' => $txtMaximumInterestRate,
        ':InterestPer' => $txtInterestPer,
        ':Charges' => $txtCharges,
        ':CreditChecks' => $txtCreditChecks,
        ':Active' => $txtActive,
        ':repaymentType' => $txtType,
        ':interestRate' => $txtInterestType
    ]);

    $activityStmt = $db->prepare('INSERT INTO `tbl_activity_log` (userName, currentDate, userEmail, userType, activity, activityPath)
                                        VALUES (:userName,:currentDate,:userEmail,:userType,:activity,:activityPath) ');

    $activityStmt->execute([
        ':userName' => $userFirstName,
        ':currentDate' => $curDate,
        ':userEmail' => $userEmail,
        ':userType' => $userType,
        ':activity' => 'Create Product',
        ':activityPath' => $txtProductName

    ]);
    echo 'success';
} catch (PDOException $e) {
    echo $e->getMessage();
}
