<?php
require '../../config.php';
$statusCode = 0;
$statusMsg = '';
$dueRepaymentDate = '';

// CSRF Protection
if (!isset($_POST['CSRF_TOKEN']) || !isset($_SESSION['CSRF_TOKEN']) || ($_POST['CSRF_TOKEN'] <> $_SESSION['CSRF_TOKEN'])) {
    echo '<p class="error">Error: invalid form submission</p>';
    header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
    exit;
}
// CSRF Protection

$txtLoanId = filter_var($_POST['txtLoanId'], FILTER_DEFAULT);
$txtRepaymentDate = filter_var($_POST['txtRepaymentDate'], FILTER_DEFAULT);


$sql = "SELECT * FROM tbl_loan where id=$txtLoanId";
$stmt = $db->prepare($sql);
$stmt->execute();

try {

    try {
        $sqlPMethod = "SELECT * FROM tbl_loan_reschedule where LoanId =$txtLoanId AND status = 'unpaid' AND paymentDate = '$txtRepaymentDate'";
        $stmt = $db->prepare($sqlPMethod);
        $stmt->execute();
        if ($row = $stmt->fetchObject()) {
            $id = $row->id;
            $monthlyPrincipalAmount = $row->principalAmount;
            $monthlyPrincipalAmount = number_format($monthlyPrincipalAmount, 2);
            $monthlyInterest = $row->interest;
            $monthlyInterest = number_format($monthlyInterest, 2);
            $monthlyamountToPay = $row->amountToPay;
            $monthlyamountToPay = number_format($monthlyamountToPay, 2);
            $monthlybalance = $row->balance;
            // $monthlybalance = number_format($monthlybalance, 2);
            $statusCode = 200;
            
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
        $statusCode = 500;
    }
} catch (PDOException $e) {
    $statusMsg = $e->getMessage();
}



$responce = new stdClass();
$responce->code = $statusCode;
$responce->message = $statusMsg;
$responce->monthlyPrincipalAmount = $monthlyPrincipalAmount;
$responce->monthlyInterest = $monthlyInterest;
$responce->monthlyamountToPay = $monthlyamountToPay;
$responce->monthlybalance = $monthlybalance;
print_r(json_encode($responce, true));
