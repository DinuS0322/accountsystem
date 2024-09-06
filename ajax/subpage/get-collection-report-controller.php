<?php
require '../../config.php';
$statusCode = 0;
$statusMsg = '';
$arreasReport = '';
$totalPaymentsReport = '';

// CSRF Protection
if (!isset($_POST['CSRF_TOKEN']) || !isset($_SESSION['CSRF_TOKEN']) || ($_POST['CSRF_TOKEN'] <> $_SESSION['CSRF_TOKEN'])) {
    echo '<p class="error">Error: invalid form submission</p>';
    header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
    exit;
}
// CSRF Protection

$txtEndDate = filter_var($_POST['txtEndDate'], FILTER_DEFAULT);
$txtStartDate = filter_var($_POST['txtStartDate'], FILTER_DEFAULT);
$selectLoanOfficer = filter_var($_POST['selectLoanOfficer'], FILTER_DEFAULT);
try {
    $totalPaymentsByDate = [];
    $arreasReport .= " <div class='row  mt-3'>
    <table class='table table-striped table-align-left' id='collectionReports'>
        <thead>
            <tr>
                <th>#</th>
                <th>Loan Id</th>
                <th>Client Name</th>
                <th>Loan Amount</th>
                <th>Loan Date</th>
                <th>Payment Date</th>
                <th>Re-Payment Date</th>
                <th>Principal Amount</th>
                <th>Interest Amount</th>
                <th>Total Payment</th>
            </tr>
        </thead>
        <tbody>";

        $sqlPMethod = "SELECT * FROM tbl_loan_repayment where repaymentOfficer = $selectLoanOfficer AND RepaymentDate BETWEEN '$txtStartDate' AND '$txtEndDate'";
        $stmt = $db->prepare($sqlPMethod);
        $stmt->execute();
        $i = 1;
 
        while ($row = $stmt->fetchObject()) {
            $id = $row->id;
            $paymentDate = $row->paymentDate;
            $RepaymentDate = $row->RepaymentDate;
            $getRepaymentDate = $row->RepaymentDate;
            $monthlyPrincipalAmount = $row->monthlyPrincipalAmount;
            $LoanId = $row->loanId;
            $monthlyInterest = $row->monthlyInterest;
            $monthlyTotalPayment = $row->monthlyTotalPayment;
            $monthlyPrincipalAmount = number_format($monthlyPrincipalAmount, 2);
            $monthlyInterest = number_format($monthlyInterest, 2);
            $loanRandomId = $db->query("SELECT `loanRandomId` FROM tbl_loan WHERE id = $LoanId")->fetchColumn(0);
            if($loanRandomId == ''){
                $loanRandomId = $LoanId;
            }

            if (!isset($totalPaymentsByDate[$paymentDate])) {
                $totalPaymentsByDate[$paymentDate] = 0;
            }
            $totalPaymentsByDate[$paymentDate] += $monthlyTotalPayment;

            $clientId = $db->query("SELECT `clientId` FROM tbl_loan WHERE id = $LoanId")->fetchColumn(0);
            $clientName = $db->query("SELECT `firstName` FROM tbl_client WHERE id = $clientId")->fetchColumn(0);
            $principal = $db->query("SELECT `principal` FROM tbl_loan WHERE id = $LoanId")->fetchColumn(0);
            $principal = number_format($principal, 2);
            $loanDate = $db->query("SELECT `date` FROM tbl_loan WHERE id = $LoanId")->fetchColumn(0);
            $loanDate = DateTime::createFromFormat('d-m-Y H:i:s', $loanDate);
            $loanDate = $loanDate->format('Y-m-d');

            $arreasReport .= "<tr>";
            $arreasReport .= "<td>$i</td>";
            $arreasReport .= "<td>$loanRandomId</td>";
            $arreasReport .= "<td>$clientName</td>";
            $arreasReport .= "<td>$principal</td>";
            $arreasReport .= "<td>$loanDate</td>";
            $arreasReport .= "<td>$paymentDate</td>";
            $arreasReport .= "<td>$getRepaymentDate</td>";
            $arreasReport .= "<td>$monthlyPrincipalAmount</td>";
            $arreasReport .= "<td>$monthlyInterest</td>";
            $arreasReport .= "<td>$monthlyTotalPayment</td>";
            $arreasReport .= "</tr>";
            $i++;
            
        }
    
    $arreasReport .= "   </tbody>
    </table>
</div>";

$totalPaymentsReport  .= " <div class='row  mt-3'>
<table class='table table-striped table-align-left' id='collectionTotalReports'>
    <thead>
        <tr>
            <th>#</th>
            <th>Date</th>
            <th>Collection Amount</th>
        </tr>
    </thead>
    <tbody>";
    $a = 1;
    foreach ($totalPaymentsByDate as $date => $total) {
        $total = number_format($total, 2);
        $totalPaymentsReport .= "<tr>";
        $totalPaymentsReport .= "<td>$a</td>";
        $totalPaymentsReport .= "<td>$date</td>";
        $totalPaymentsReport .= "<td>$total</td>";
        $totalPaymentsReport .= "</tr>";
        $a++;
    }
    $totalPaymentsReport .= "   </tbody>
    </table>
</div>";
$statusCode = 200;
} catch (PDOException $e) {
    $statusMsg = $e->getMessage();
}



$responce = new stdClass();
$responce->code = $statusCode;
$responce->message = $statusMsg;
$responce->arreasReport = $arreasReport;
$responce->totalPaymentsReport = $totalPaymentsReport;
print_r(json_encode($responce, true));
