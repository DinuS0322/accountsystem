<?php
require '../../config.php';
$statusCode = 0;
$statusMsg = '';
$arreasReport = '';

// CSRF Protection
if (!isset($_POST['CSRF_TOKEN']) || !isset($_SESSION['CSRF_TOKEN']) || ($_POST['CSRF_TOKEN'] <> $_SESSION['CSRF_TOKEN'])) {
    echo '<p class="error">Error: invalid form submission</p>';
    header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
    exit;
}
// CSRF Protection

$txtEndDate = filter_var($_POST['txtEndDate'], FILTER_DEFAULT);

try {
    $arreasReport .= " <div class='row  mt-3'>
    <table class='table table-striped table-align-left' id='dueReports'>
        <thead>
            <tr>
                <th>#</th>
                <th>Loan Id</th>
                <th>Client Name</th>
                <th>Loan Amount</th>
                <th>Loan Date</th>
                <th>Payment Date</th>
                <th>Interest</th>
                <th>Principal Amount</th>
                <th>Total Payment</th>
            </tr>
        </thead>
        <tbody>";

        $sqlPMethod = 'SELECT * FROM tbl_loan_reschedule where status="unpaid" ORDER BY currentDate desc ';
        $stmt = $db->prepare($sqlPMethod);
        $stmt->execute();
        $i = 1;
 
        while ($row = $stmt->fetchObject()) {
            $id = $row->id;
            $paymentDate = $row->paymentDate;
            $amountToPay = $row->amountToPay;
            $principalAmount = $row->principalAmount;
            $interest = $row->interest;
            $LoanId = $row->LoanId;
            $amountToPay = number_format($amountToPay,  2);
            $interest = number_format($interest, 2);
            $principalAmount = number_format($principalAmount, 2);
            $loanRandomId = $db->query("SELECT `loanRandomId` FROM tbl_loan WHERE id = $LoanId")->fetchColumn(0);
            if($loanRandomId == ''){
                $loanRandomId = $LoanId;
            }
            $clientId = $db->query("SELECT `clientId` FROM tbl_loan WHERE id = $LoanId")->fetchColumn(0);
            $clientName = $db->query("SELECT `firstName` FROM tbl_client WHERE id = $clientId")->fetchColumn(0);
            $principal = $db->query("SELECT `principal` FROM tbl_loan WHERE id = $LoanId")->fetchColumn(0);
            $principal = number_format($principal, 2);
            $loanDate = $db->query("SELECT `date` FROM tbl_loan WHERE id = $LoanId")->fetchColumn(0);
            $loanDate = DateTime::createFromFormat('d-m-Y H:i:s', $loanDate);
            $loanDate = $loanDate->format('Y-m-d');
            

            $formatPaymentDate = new DateTime($paymentDate);
            $formatFilterDate = new DateTime($txtEndDate);

            if($formatFilterDate >= $formatPaymentDate){
            $arreasReport .= "<tr>";
            $arreasReport .= "<td>$i</td>";
            $arreasReport .= "<td>$loanRandomId</td>";
            $arreasReport .= "<td>$clientName</td>";
            $arreasReport .= "<td>$principal</td>";
            $arreasReport .= "<td>$loanDate</td>";
            $arreasReport .= "<td>$paymentDate</td>";
            $arreasReport .= "<td>$interest</td>";
            $arreasReport .= "<td>$principalAmount</td>";
            $arreasReport .= "<td>$amountToPay</td>";
            $arreasReport .= "</tr>";
            $i++;
            }
        }
    
    $arreasReport .= "   </tbody>
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
print_r(json_encode($responce, true));
