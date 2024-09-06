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


    $sql = "SELECT * FROM tbl_loan where id=$txtLoanId";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    try {

    try {
        $sqlPMethod = "SELECT * FROM tbl_loan_reschedule where LoanId =$txtLoanId AND status = 'unpaid'";
        $stmt = $db->prepare($sqlPMethod);
        $stmt->execute();
        $paymentDateArray = array();
        $dueRepaymentDate .=  "<option value=''>Select</option>";
        while ($row = $stmt->fetchObject()) {
            $id = $row->id;
            $paymentDate = $row->paymentDate;
            array_push($paymentDateArray, $paymentDate);
        }
        $firstDate = reset($paymentDateArray);
        $dueRepaymentDate .=  "<option value='$firstDate'>$firstDate</option>";
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

        if ($row = $stmt->fetchObject()) {
            $shortName = $row->shortName;
            $description = $row->description;
            $statusCode = 200;
        } else {
            $statusCode = 502;
        }
    } catch (PDOException $e) {
        $statusMsg = $e->getMessage();
    }



$responce = new stdClass();
$responce->code = $statusCode;
$responce->message = $statusMsg;
$responce->dueRepaymentDate = $dueRepaymentDate;

print_r(json_encode($responce, true));
