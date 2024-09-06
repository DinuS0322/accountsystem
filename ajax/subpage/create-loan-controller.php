<?php
require '../../config.php';
$statusCode = 0;
$statusMsg = '';

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

$searchClient = filter_var($_POST['searchClient'], FILTER_DEFAULT);
$searchProduct = filter_var($_POST['searchProduct'], FILTER_DEFAULT);
$txtfund = filter_var($_POST['txtfund'], FILTER_DEFAULT);
$txtDefaultPrincipal = filter_var($_POST['txtDefaultPrincipal'], FILTER_DEFAULT);
$txtDefaultLoanTerm = filter_var($_POST['txtDefaultLoanTerm'], FILTER_DEFAULT);
$txtDefaultInterestRate = filter_var($_POST['txtDefaultInterestRate'], FILTER_DEFAULT);
$interestPer = filter_var($_POST['interestPer'], FILTER_DEFAULT);
$txtRepaymentFrequency = filter_var($_POST['txtRepaymentFrequency'], FILTER_DEFAULT);
$txtrepaymentType = filter_var($_POST['txtrepaymentType'], FILTER_DEFAULT);
$txtCreditChecks = filter_var($_POST['txtCreditChecks'], FILTER_DEFAULT);
$txtGurantors = filter_var($_POST['txtGurantors'], FILTER_DEFAULT);
$txtLoanOfficerId = filter_var($_POST['txtLoanOfficerId'], FILTER_DEFAULT);
$txtLoanPurpose = filter_var($_POST['txtLoanPurpose'], FILTER_DEFAULT);
$txtFundSource = filter_var($_POST['txtFundSource'], FILTER_DEFAULT);
$interestType = filter_var($_POST['interestType'], FILTER_DEFAULT);
$txtGurantorsFromClient = filter_var($_POST['txtGurantorsFromClient'], FILTER_DEFAULT);
$txtExpectedFirstRepaymentdDate = filter_var($_POST['txtExpectedFirstRepaymentdDate'], FILTER_DEFAULT);

$clientName = $db->query("SELECT `firstName` FROM tbl_client WHERE id = $searchClient")->fetchColumn(0);

// Get the maximum value of the column
$clientSql = "SELECT MAX(id) AS max_value FROM tbl_loan";
$cilentStmt = $db->prepare($clientSql);
$cilentStmt->execute();

// Fetch the result
$clientResult = $cilentStmt->fetch(PDO::FETCH_ASSOC);

$maxValue = $clientResult['max_value'];

$maxValue = (int)$maxValue + 1;

$loanNo = "loan No-" . $maxValue;

$loanRandomeId = randomCode(10);

try {

    $stmt = $db->prepare('INSERT INTO `tbl_loan` (date,clientId,productId,fund,principal,longTerm,interestRate,interestPer,repaymentFreq,repaymentType,creditCheck,gurantor,loanOfficerId,loanPurpose,firstPaymentDate,newLoan, fundSource, gurantorClient,aprovalStatus,interestRateType,requestLoan, approvedusers, loanRandomId)
                                        VALUES (:date,:clientId,:productId,:fund,:principal,:longTerm,:interestRate,:interestPer,:repaymentFreq,:repaymentType,:creditCheck,:gurantor,:loanOfficerId,:loanPurpose,:firstPaymentDate,:newLoan,:fundSource,:gurantorClient,:aprovalStatus,:interestRateType, :requestLoan, :approvedusers, :loanRandomId)');

    $stmt->execute([
        ':date' => $curDate,
        ':clientId' => (int)$searchClient,
        ':productId' => (int)$searchProduct,
        ':fund' => $txtfund,
        ':principal' => $txtDefaultPrincipal,
        ':longTerm' => $txtDefaultLoanTerm,
        ':interestRate' => $txtDefaultInterestRate,
        ':interestPer' => $interestPer,
        ':repaymentFreq' => $txtRepaymentFrequency,
        ':repaymentType' => $txtrepaymentType,
        ':creditCheck' => $txtCreditChecks,
        ':gurantor' => $txtGurantors,
        ':loanOfficerId' => (int)$txtLoanOfficerId,
        ':loanPurpose' => $txtLoanPurpose,
        ':firstPaymentDate' => $txtExpectedFirstRepaymentdDate,
        ':newLoan' => $loanNo,
        ':fundSource' => $txtFundSource,
        ':gurantorClient' => $txtGurantorsFromClient,
        ':aprovalStatus' => 'pending',
        ':approvedusers' => 0,
        ':interestRateType' => $interestType,
        ':requestLoan' => 0,
        ':loanRandomId' => $loanRandomeId
    ]);

    $activityStmt = $db->prepare('INSERT INTO `tbl_activity_log` (userName, currentDate, userEmail, userType, activity, activityPath)
                                        VALUES (:userName,:currentDate,:userEmail,:userType,:activity,:activityPath) ');

    $activityStmt->execute([
        ':userName' => $userFirstName,
        ':currentDate' => $curDate,
        ':userEmail' => $userEmail,
        ':userType' => $userType,
        ':activity' => 'Create Loan',
        ':activityPath' =>'Client -'. $clientName

    ]);
  echo 'pass';
} catch (PDOException $e) {
    echo $e->getMessage();

}



