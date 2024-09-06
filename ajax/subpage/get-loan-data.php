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

$searchProduct = filter_var($_POST['searchProduct'], FILTER_DEFAULT);
$searchClient = filter_var($_POST['searchClient'], FILTER_DEFAULT);

if($searchProduct == ''){
    $statusCode = 502;
    $shortName = '';
    $description ='';
    $defaultPrincipal ='';
    $DefaultLoanTerm ='';
    $DefaultInterestRate = '';
    $InterestPer = '';
    $RepaymentFrequency = '';
    $repaymentType ='';
    $fund = '';
    $CreditChecks = '';
    $loanOfficerId = '';
    $interestRateType = '';
}else{
    $sql = "SELECT * FROM tbl_loan_product where id=$searchProduct";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    $clientSql = "SELECT * FROM tbl_client where id=$searchClient";
    $clientStmt = $db->prepare($clientSql);
    $clientStmt->execute();

    try {

        if ($row = $stmt->fetchObject()) {
            $shortName = $row->shortName;
            $description = $row->description;
            $defaultPrincipal = $row->defaultPrincipal;
            $DefaultLoanTerm = $row->DefaultLoanTerm;
            $DefaultInterestRate = $row->DefaultInterestRate;
            $InterestPer = $row->InterestPer;
            $RepaymentFrequency = $row->RepaymentFrequency;
            $repaymentType = $row->repaymentType;
            $fund = $row->fund;
            $interestRate = $row->interestRate;
            $CreditChecks = $row->CreditChecks;
            if ($clientRow = $clientStmt->fetchObject()) {
                $loanOfficerId = $clientRow->loanOfficerId;
                $statusCode = 200;

            }
            if($interestRate == 'Flate Rate'){
                $interestRate .= "<option value='$interestRate' selected>$interestRate</option>";
                $interestRate .= "<option value='Reduce Amount'>Reduce Amount</option>"; 
            }else{
                $interestRate .= "<option value='$interestRate' selected>$interestRate</option>";
                $interestRate .= "<option value='Flate Rate'>Flate Rate</option>"; 
            }
            $statusCode = 200;
        } else {
            $statusCode = 502;
        }
    } catch (PDOException $e) {
        $statusMsg = $e->getMessage();
    }
}


$responce = new stdClass();
$responce->code = $statusCode;
$responce->shortName = $shortName;
$responce->description = $description;
$responce->defaultPrincipal = $defaultPrincipal;
$responce->DefaultLoanTerm = $DefaultLoanTerm;
$responce->DefaultInterestRate = $DefaultInterestRate;
$responce->InterestPer = $InterestPer;
$responce->RepaymentFrequency = $RepaymentFrequency;
$responce->repaymentType = $repaymentType;
$responce->fund = $fund;
$responce->CreditChecks = $CreditChecks;
$responce->interestRate = $interestRate;
$responce->message = $statusMsg;
$responce->loanOfficerId = $loanOfficerId;

print_r(json_encode($responce, true));