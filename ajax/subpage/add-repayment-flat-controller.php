
<?php
require '../../config.php';
require '../../source/dompdf/autoload.inc.php';
$sqlPMethod = "SELECT * FROM tbl_account_settings  where accountType = 'DEFAULT_ACCOUNT'";
$stmtCount = $db->prepare($sqlPMethod);
$stmtCount->execute();

$SESS_USER_ID = $_SESSION['SESS_USER_ID'];

if ($row = $stmtCount->fetchObject()) {
    $accountId = $row->accountId;
}

if ($stmtCount->rowCount() > 0) {

?>

<?php



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
    $curDate = date('Y-m-d');
    $currentDate = date('Y-m-d');

    $txtPaymentDate = filter_var($_POST['txtPaymentDate'], FILTER_DEFAULT);
    $txtLoanId = filter_var($_POST['txtLoanId'], FILTER_DEFAULT);
    $txtRepaymentDate = filter_var($_POST['txtRepaymentDate'], FILTER_DEFAULT);
    $txtMonthlyPrincipalAmount = filter_var($_POST['txtMonthlyPrincipalAmount'], FILTER_DEFAULT);
    $txtMonthlyInterest = filter_var($_POST['txtMonthlyInterest'], FILTER_DEFAULT);
    $txtMonthlyTotalPayment = filter_var($_POST['txtMonthlyTotalPayment'], FILTER_DEFAULT);
    $txtLoanBalance = filter_var($_POST['txtLoanBalance'], FILTER_DEFAULT);
    $txtRepaymentOfficer = filter_var($_POST['txtRepaymentOfficer'], FILTER_DEFAULT);
    $txtRemarks = filter_var($_POST['txtRemarks'], FILTER_DEFAULT);
    $txtMonthlySavings = filter_var($_POST['txtMonthlySavings'], FILTER_DEFAULT);
    // $txtSavingCheck = filter_var($_POST['txtSavingCheck'], FILTER_DEFAULT);
    $txtReceiptNo = filter_var($_POST['txtReceiptNo'], FILTER_DEFAULT);
    $txtUniqueNo = filter_var($_POST['txtUniqueNo'], FILTER_DEFAULT);
    $dropPaymentOption = filter_var($_POST['dropPaymentOption'], FILTER_DEFAULT);

    // $txtMonthlyReducePrincipal = filter_var($_POST['txtMonthlyReducePrincipal'], FILTER_DEFAULT);
    // $txtReduceCheck = filter_var($_POST['txtReduceCheck'], FILTER_DEFAULT);
    $txtPaymentAmount = filter_var($_POST['txtPaymentAmount'], FILTER_DEFAULT);
    $txtPaymentAmount = str_replace(',', '', $txtPaymentAmount);
    $txtPaymentAmount = number_format($txtPaymentAmount, 2);
    // $txtLoanBalanceView = filter_var($_POST['txtLoanBalanceView'], FILTER_DEFAULT);
    $paid = 'paid';



    $Loanprincipal = $db->query("SELECT `principal` FROM tbl_loan WHERE id = $txtLoanId")->fetchColumn(0);
    $Loanprincipal = number_format($Loanprincipal, 2);
    $LoanOfficcerFirstName = $db->query("SELECT `firstName` FROM tbl_users WHERE id = $txtRepaymentOfficer")->fetchColumn(0);
    $LoanOfficcerLastName = $db->query("SELECT `lastName` FROM tbl_users WHERE id = $txtRepaymentOfficer")->fetchColumn(0);
    $officeFullName = $LoanOfficcerFirstName . " " . $LoanOfficcerLastName;
    $clientId = $db->query("SELECT `clientId` FROM tbl_loan WHERE id = $txtLoanId")->fetchColumn(0);
    $clientFirstName = $db->query("SELECT `firstName` FROM tbl_client WHERE id = $clientId")->fetchColumn(0);
    $clientLastName = $db->query("SELECT `lastName` FROM tbl_client WHERE id = $clientId")->fetchColumn(0);
    $savingAmountTotal = $db->query("SELECT `savingAmountTotal` FROM tbl_savings_total WHERE clientId = $clientId")->fetchColumn(0);
    $savingsT = floatval($savingAmountTotal);
    $clientFullName = $clientFirstName . " " . $clientLastName;


    if ($dropPaymentOption == 'cash') {
        //update reschedule status - start
        $updateStmt = $db->prepare('UPDATE tbl_loan_reschedule SET status=? where LoanId = ? AND paymentDate= ?');

        $updateStmt->bindParam(1, $paid);
        $updateStmt->bindParam(2, $txtLoanId);
        $updateStmt->bindParam(3, $txtRepaymentDate);
        $updateStmt->execute();

        $sqlPMethod = "SELECT * FROM tbl_loan_reschedule where LoanId =$txtLoanId AND status = 'unpaid'";
        $stmt = $db->prepare($sqlPMethod);
        $stmt->execute();
        $paymentDateArray = array();
        while ($row = $stmt->fetchObject()) {
            $id = $row->id;
            $paymentDate = $row->paymentDate;
            array_push($paymentDateArray, $paymentDate);
        }
        $firstDate = reset($paymentDateArray);

        $sqlPMethod = "SELECT * FROM tbl_loan_reschedule where LoanId =$txtLoanId AND status = 'unpaid' AND paymentDate = '$firstDate'";
        $stmt = $db->prepare($sqlPMethod);
        $stmt->execute();
        if ($row = $stmt->fetchObject()) {
            $id = $row->id;
            $monthlyPrincipalAmount = $row->principalAmount;
            $monthlyPrincipalAmount = number_format($monthlyPrincipalAmount, 2);
            $monthlyInterest = $row->interest;
            $monthlyInterest = number_format($monthlyInterest, 2);
            $monthlyamountToPay = $row->amountToPay;
            $monthlyamountToPaycc = $row->amountToPay;
            $monthlyamountToPay = number_format($monthlyamountToPay, 2);
            $monthlyamountToPaycheck = number_format($monthlyamountToPaycc, 2);
            $monthlyamountToPaycheck = str_replace(',', '', $monthlyamountToPaycheck);
            $monthlybalance = $row->balance;

            if ($monthlyamountToPay == '1,833.33') {
                $monthlyamountToPaycheck = str_replace(',', '', $monthlyamountToPay);
            }
            // $monthlybalance = number_format($monthlybalance, 2);
        }
        //update reschedule status - end

        // if ($txtSavingCheck == 'true') {
        $txtMonthlySav = floatval($txtMonthlySavings);
        $totalsav = $savingsT + $txtMonthlySav;
        $totalsav = number_format($totalsav, 2);
        // } else {
        //     $totalsav = '-';
        // }

        $sql = "SELECT COUNT(*) as row_count, MAX(id) as max_id FROM tbl_loan_repayment";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $maxId = $result['max_id'];
        $FinalId = (int)$maxId + 1;

        //Gen Document - START
        // use Dompdf\Dompdf;

        $body = "
<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Diagnostic Report</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        .page-break {
            page-break-before: always;
          }

        th, td {
            border: 1px solid #000; /* 1px solid black border */
            padding: 8px;
            
        }

        th {
            background-color: #f2f2f2; /* Gray background for header cells */
            text-align: center;
        }
        .headerTable td{
            border: none;
        }
        .card {
            margin-top: 20px;
            width: 100%;
            background-color: #0879AE;
            border-radius: 10px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        }
        .cardhead{
            text-align:center;
            color: white;
        }
        .houseHeadImage{
            align-item: center;
        }
        .container {
            text-align: center;
          }
        .headStyle{
            text-align: center;
            color: blue;
        }
    </style>
</head>

<body>
<table>
<tbody>
  <tr >
        <td>
            Loan Id
        </td>
        <td>
            $txtLoanId
        </td>
    </tr>
    <tr >
    <td>
        Receipt Number
    </td>
    <td>
        $txtReceiptNo
    </td>
    </tr>
    <tr >
    <td>
        Unique Number
    </td>
    <td>
        $txtUniqueNo
    </td>
    </tr>
  <tr >
        <td>
            Payment Date
        </td>
        <td>
            $txtPaymentDate
        </td>
    </tr>
      <tr >
        <td>
            Re-Payment Date
        </td>
        <td>
            $txtRepaymentDate
        </td>
    </tr>
      <tr >
        <td>
           Client Name
        </td>
        <td>
            $clientFullName
        </td>
    </tr>
       <tr >
        <td>
           Loan Officer Name
        </td>
        <td>
            $officeFullName
        </td>
     </tr>
        <tr >
        <td>
           Principal Anount
        </td>
        <td>
            $txtMonthlyPrincipalAmount
        </td>
    </tr>
        <tr >
        <td>
           Interest Amount
        </td>
        <td>
            $txtMonthlyInterest
        </td>
    </tr>
        <tr >
        <td>
           Loan Total Payment
        </td>
        <td>
            $txtMonthlyTotalPayment
        </td>
    </tr>
         <tr >
        <td>
           Loan Amount
        </td>
        <td>
            $Loanprincipal
        </td>
    </tr>
           <tr >
        <td>
           Savings Amount
        </td>
        <td>
            $txtMonthlySavings
        </td>
    </tr>
            <tr >
        <td>
           Savings Total Amount
        </td>
        <td>
            $totalsav
        </td>
    </tr>
       <tr >
        <td>
           Payment Amount
        </td>
        <td>
            $txtPaymentAmount
        </td>
    </tr>
         <tr >
        <td>
           Balance Payment
        </td>
        <td>
            $txtLoanBalance
        </td>
    </tr>
    </tbody>
    </table>
</body>

</html>
";

        // use Dompdf\Options;

        // $options = new Options();
        // $options->set('isHtml5ParserEnabled', true);
        // $options->set('isPhpEnabled', true);
        // $options->set('isRemoteEnabled', true);

        // // instantiate and use the dompdf class
        // $dompdf = new Dompdf($options);

        // Define the footer HTML and CSS
        $footerHtml = "
    <div style='text-align: center; position: absolute; bottom: 10px; left: 0; right: 0;'>
    <form style='margin-top:300px'>
       <label><strong>Generated/Updated Date & Time : </strong></label>
       <label>$curDate</label>
   </form>
    This document is generated using Account System";
        $footerCss = 'body { position: relative; }';

        $header = "
        <table class='headerTable'>
            <tbody width = '100%'>
                <tr>
                 
                    <td  style='text-align: center;'>
                        <h2>PAYMENT DETAILS</h2>
                    </td>
                </tr>
            </tbody>
        </table>    
        <div style='background-color: blue'></div>
        ";

        // Combine the body content and footer HTML
        $html = '<html><head><style>' . $footerCss . '</style></head><body>' . $header . $body . $footerHtml . '</body></html>';

        // $dompdf->loadHtml($html);

        // // (Optional) Setup the paper size and orientation
        // $dompdf->setPaper('A4', 'portrait');

        // $dompdf->set_base_path(__DIR__);

        // // Render the HTML as PDF
        // $dompdf->render();

        // $pdfOutput = $dompdf->output();

        // // Specify the path to the local folder where you want to save the PDF
        // $localFolderPath = '../../upload/generateDoc/';
        // $filename = $FinalId . '.pdf';

        // Save the PDF to the local folder
        // file_put_contents($localFolderPath . $filename, $pdfOutput);
        //Gen Document - END

        try {

            // if ($txtSavingCheck == 'true') {
                if($txtMonthlySavings != ''){
            $clientId = $db->query("SELECT `clientId` FROM tbl_loan WHERE id = $txtLoanId")->fetchColumn(0);
            $savingStmt = $db->prepare('INSERT INTO `tbl_savings` (date,clientId, savingAmount, status, repaymentId, paymentStatus)
                                        VALUES (:date,:clientId, :savingAmount, :status, :repaymentId, :paymentStatus)');

            $savingStmt->execute([
                ':date' => $curDate,
                ':clientId' => $clientId,
                ':savingAmount' => $txtMonthlySavings,
                ':status' => 'saving from loan pay',
                ':repaymentId' => $FinalId,
                ':paymentStatus' => 'Credit'
            ]);
        }

            $savingAmountTotal = $db->query("SELECT `savingAmountTotal` FROM tbl_savings_total WHERE clientId = $clientId")->fetchColumn(0);
            if ($savingAmountTotal == '') {
                // $savingTotal = floatval($txtMonthlySavings);
                $savingtotalStmt = $db->prepare('INSERT INTO `tbl_savings_total` (date,clientId, savingAmountTotal)
                                        VALUES (:date,:clientId, :savingAmountTotal)');

                $savingtotalStmt->execute([
                    ':date' => $curDate,
                    ':clientId' => $clientId,
                    ':savingAmountTotal' => $txtMonthlySavings
                ]);
            } else {
                $savingDB = floatval($savingAmountTotal);
                $savingTotal = floatval($txtMonthlySavings);
                $finalTotalSavings = $savingDB + $savingTotal;


                $updateSavingStmt = $db->prepare('UPDATE tbl_savings_total SET savingAmountTotal=?, date=? where clientId = ? ');

                $updateSavingStmt->bindParam(1, $finalTotalSavings);
                $updateSavingStmt->bindParam(2, $curDate);
                $updateSavingStmt->bindParam(3, $clientId);
                $updateSavingStmt->execute();
            }
            // }

            // if($txtReduceCheck == 'true'){

            //     $stmt = $db->prepare('INSERT INTO `tbl_loan_repayment` (date,paymentDate,RepaymentDate,monthlyPrincipalAmount,monthlyInterest,monthlyTotalPayment,loanBalance,repaymentOfficer,remarks,loanId, paymentAmount)
            //                                     VALUES (:date,:paymentDate, :RepaymentDate, :monthlyPrincipalAmount, :monthlyInterest, :monthlyTotalPayment, :loanBalance, :repaymentOfficer, :remarks, :loanId, :paymentAmount)');

            //     $stmt->execute([
            //         ':date' => $curDate,
            //         ':paymentDate' => $txtPaymentDate,
            //         ':RepaymentDate' => $txtRepaymentDate,
            //         ':monthlyPrincipalAmount' => $txtMonthlyPrincipalAmount,
            //         ':monthlyInterest' => $txtMonthlyInterest,
            //         ':monthlyTotalPayment' => $txtMonthlyTotalPayment,
            //         ':loanBalance' => $txtLoanBalance,
            //         ':repaymentOfficer' => $txtRepaymentOfficer,
            //         ':remarks' => $txtRemarks,
            //         ':loanId' => $txtLoanId,
            //         ':paymentAmount' => $txtPaymentAmount
            //     ]);

            //     $updateStmt = $db->prepare('UPDATE tbl_loan_reschedule SET status=? where LoanId = ? AND paymentDate= ?');

            //     $updateStmt->bindParam(1, $paid);
            //     $updateStmt->bindParam(2, $txtLoanId);
            //     $updateStmt->bindParam(3, $txtRepaymentDate);
            //     $updateStmt->execute();

            //     $clientId = $db->query("SELECT `clientId` FROM tbl_loan WHERE id = $txtLoanId")->fetchColumn(0);
            //     $firstName = $db->query("SELECT `firstName` FROM tbl_client WHERE id = $clientId")->fetchColumn(0);
            //     $activityPath = $txtLoanId . '-' . $firstName;

            //     $activityStmt = $db->prepare('INSERT INTO `tbl_activity_log` (userName, currentDate, userEmail, userType, activity, activityPath)
            //                                     VALUES (:userName,:currentDate,:userEmail,:userType,:activity,:activityPath) ');

            //     $activityStmt->execute([
            //         ':userName' => $userFirstName,
            //         ':currentDate' => $curDate,
            //         ':userEmail' => $userEmail,
            //         ':userType' => $userType,
            //         ':activity' => 'Create Loan Payment',
            //         ':activityPath' => $activityPath

            //     ]);
            //     echo $FinalId;

            //     //fix issue
            //     // $reduceAmount = floatval($txtMonthlyReducePrincipal);
            //     // for ($t = $reduceAmount; $t > 0;) {
            //     //     $sqlPMethod = "SELECT * FROM tbl_loan_reschedule where LoanId =$txtLoanId AND status = 'unpaid' AND principalAmount != '0'";
            //     //     $stmt = $db->prepare($sqlPMethod);
            //     //     $stmt->execute();
            //     //     $paymentDateArray = array();
            //     //     while ($row = $stmt->fetchObject()) {
            //     //         $paymentDate = $row->paymentDate;
            //     //         array_push($paymentDateArray, $paymentDate);
            //     //     }
            //     //     $firstDate = reset($paymentDateArray);
            //     //     $sqlPMethod = "SELECT * FROM tbl_loan_reschedule WHERE LoanId = $txtLoanId AND status = 'unpaid' AND paymentDate= '$firstDate' ";
            //     //     $stmt = $db->prepare($sqlPMethod);
            //     //     $stmt->execute();
            //     //     if ($row = $stmt->fetchObject()) {
            //     //         $id = $row->id;
            //     //         $amountToPay = $row->amountToPay;
            //     //         $amountToPay = floatval($amountToPay);
            //     //         $interest = $row->interest;
            //     //         $interest = floatval($interest);
            //     //         $principalAmount = $row->principalAmount;
            //     //         $principalAmount = floatval($principalAmount);
            //     //         $balance = $row->balance;
            //     //         $tt_without_comma = str_replace(',', '', $balance);
            //     //         $balance = floatval($tt_without_comma);
            //     //         $test = $t;
            //     //         $ftest = $test - $principalAmount;
            //     //         if ($ftest > 0) {
            //     //             $finalPrincipalAmount = '0';
            //     //             $calFInalPrin = floatval($finalPrincipalAmount);
            //     //             $lastTotalAMountPay = $calFInalPrin + $interest;
            //     //             $lastTotalAMountPay = floatval($lastTotalAMountPay);
            //     //             $finalcal = $amountToPay - $lastTotalAMountPay;
            //     //             $lastBalance = $balance - $finalcal;
            //     //             $lastBalance = number_format($lastBalance, 2);

            //     //             // $sqlPMethod = "SELECT * FROM tbl_loan_reschedule where LoanId =$txtLoanId AND status = 'paid'";
            //     //             // $stmt = $db->prepare($sqlPMethod);
            //     //             // $stmt->execute();
            //     //             // $paymentDateArray = array();
            //     //             // while ($row = $stmt->fetchObject()) {
            //     //             //     $id = $row->id;
            //     //             //     $paymentDate = $row->paymentDate;
            //     //             //     array_push($paymentDateArray, $paymentDate);
            //     //             // }
            //     //             // $lastDate = end($paymentDateArray);

            //     //             // $sqlMethod = "SELECT * FROM tbl_loan_reschedule where LoanId =$txtLoanId AND status = 'paid' AND paymentDate = '$lastDate'";
            //     //             // $stmtt = $db->prepare($sqlMethod);
            //     //             // $stmtt->execute();
            //     //             // if ($row = $stmtt->fetchObject()) {
            //     //             //     $balance = $row->balance;
            //     //             //     $tt_without_comma = str_replace(',', '', $balance);
            //     //             //     $balancee = floatval($tt_without_comma);
            //     //             //     $lBAL = $balancee - $lastTotalAMountPay;
            //     //             //     $lBAL = number_format($lBAL, 2);
            //     //             // }

            //     //             // echo $lastBal;
            //     //             $updateStmt = $db->prepare('UPDATE tbl_loan_reschedule SET principalAmount=?, balance=?, amountToPay=? where id = ?');
            //     //             $updateStmt->bindParam(1, $finalPrincipalAmount);
            //     //             $updateStmt->bindParam(2, $lastBalance);
            //     //             $updateStmt->bindParam(3, $lastTotalAMountPay);
            //     //             $updateStmt->bindParam(4, $id);
            //     //             $updateStmt->execute();
            //     //         } else {
            //     //             $finalPrencipal = $principalAmount - $test;
            //     //             $finalBal = $finalPrencipal + $interest;
            //     //             $finalBal = floatval($finalBal);
            //     //             $lastBL = $balance - $test;
            //     //             $lastBL = number_format($lastBL, 2);
            //     //             $updateStmt = $db->prepare('UPDATE tbl_loan_reschedule SET principalAmount=?, balance=?, amountToPay=? where id = ?');
            //     //             $updateStmt->bindParam(1, $finalPrencipal);
            //     //             $updateStmt->bindParam(2, $lastBL);
            //     //             $updateStmt->bindParam(3, $finalBal);
            //     //             $updateStmt->bindParam(4, $id);
            //     //             $updateStmt->execute();
            //     //             // echo $finalPrencipal .'<br>';
            //     //             // echo $finalBal;
            //     //         }

            //     //     }
            //     //     $t = $ftest;
            //     // }
            //     //fix issue

            // }else{

            // }

            $stmt = $db->prepare('INSERT INTO `tbl_loan_repayment` (date,paymentDate,RepaymentDate,monthlyPrincipalAmount,monthlyInterest,monthlyTotalPayment,loanBalance,repaymentOfficer,remarks,loanId, paymentAmount, uniqueNo,receiptNo, monthlybalance)
    VALUES (:date,:paymentDate, :RepaymentDate, :monthlyPrincipalAmount, :monthlyInterest, :monthlyTotalPayment, :loanBalance, :repaymentOfficer, :remarks, :loanId, :paymentAmount, :uniqueNo, :receiptNo, :monthlybalance)');

            $stmt->execute([
                ':date' => $curDate,
                ':paymentDate' => $txtPaymentDate,
                ':RepaymentDate' => $txtRepaymentDate,
                ':monthlyPrincipalAmount' => $txtMonthlyPrincipalAmount,
                ':monthlyInterest' => $txtMonthlyInterest,
                ':monthlyTotalPayment' => $txtMonthlyTotalPayment,
                ':loanBalance' => $txtLoanBalance,
                ':repaymentOfficer' => $txtRepaymentOfficer,
                ':remarks' => $txtRemarks,
                ':loanId' => $txtLoanId,
                ':paymentAmount' => $txtPaymentAmount,
                ':uniqueNo' => $txtUniqueNo,
                ':receiptNo' => $txtReceiptNo,
                ':monthlybalance' => $txtLoanBalance
            ]);

            $clientId = $db->query("SELECT `clientId` FROM tbl_loan WHERE id = $txtLoanId")->fetchColumn(0);
            $firstName = $db->query("SELECT `firstName` FROM tbl_client WHERE id = $clientId")->fetchColumn(0);
            $activityPath = $txtLoanId . '-' . $firstName;

            $activityStmt = $db->prepare('INSERT INTO `tbl_activity_log` (userName, currentDate, userEmail, userType, activity, activityPath)
    VALUES (:userName,:currentDate,:userEmail,:userType,:activity,:activityPath) ');

            $activityStmt->execute([
                ':userName' => $userFirstName,
                ':currentDate' => $curDate,
                ':userEmail' => $userEmail,
                ':userType' => $userType,
                ':activity' => 'Create Loan Payment',
                ':activityPath' => $activityPath

            ]);

            $balance = $db->query("SELECT `balance` FROM tbl_account WHERE id = $accountId")->fetchColumn(0);
            $balance = (float)$balance;
            if ($txtMonthlySavings != '') {
                $txtMonthlySavingsCal = (float)$txtMonthlySavings;
                $totalBalance = $balance + $txtMonthlySavingsCal;
                $totalBalance = (string)$totalBalance;
                $db->query("UPDATE tbl_account SET balance = '$totalBalance' WHERE id = $accountId");

                $stmtTRansferFrom = $db->prepare('INSERT INTO `tbl_transfer_history` (transferDate, account, accountStatus, reason, accountBalance, transferAmount )
        VALUES (:transferDate, :account, :accountStatus,  :reason, :accountBalance, :transferAmount)');

                $stmtTRansferFrom->execute([
                    ':transferDate' => $currentDate,
                    ':account' => $accountId,
                    ':accountStatus' => 'Credit',
                    ':reason' => 'Loan Savings',
                    ':accountBalance' => $totalBalance,
                    ':transferAmount' => $txtMonthlySavings,
                ]);
            }

            $formatAmount = str_replace(',', '', $txtMonthlyTotalPayment);
            $txtMonthlyTotalPaymentCal = (float)$formatAmount;
            $getBalance = $db->query("SELECT `balance` FROM tbl_account WHERE id = $accountId")->fetchColumn(0);
            $getBalanceCal = (float)$getBalance;
            $finalBalance = $getBalanceCal + $txtMonthlyTotalPaymentCal;
            $finalBalance = (string)$finalBalance;

            $db->query("UPDATE tbl_account SET balance = '$finalBalance' WHERE id = $accountId");

            $stmtTRansferFrom = $db->prepare('INSERT INTO `tbl_transfer_history` (transferDate, account, accountStatus, reason, accountBalance, transferAmount )
    VALUES (:transferDate, :account, :accountStatus,  :reason, :accountBalance, :transferAmount)');

            $stmtTRansferFrom->execute([
                ':transferDate' => $currentDate,
                ':account' => $accountId,
                ':accountStatus' => 'Credit',
                ':reason' => 'Repayment - '.$txtLoanId,
                ':accountBalance' => $finalBalance,
                ':transferAmount' => $formatAmount,
            ]);

            $txtPaymentAmountSet = filter_var($_POST['txtPaymentAmount'], FILTER_DEFAULT);
            $stmtCollection = $db->prepare('INSERT INTO `tbl_collection_history` (date, officerId,amount,collectionStatus)
            VALUES (:date, :officerId, :amount, :collectionStatus)');
    
            $stmtCollection->execute([
                ':date' => $curDate,
                ':officerId' => $SESS_USER_ID,
                ':amount' => $txtPaymentAmountSet,
                ':collectionStatus' => 'repayment'
            ]);


            echo $FinalId;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
?>

<?php
    } else {
        $savingAmountTotal = $db->query("SELECT `savingAmountTotal` FROM tbl_savings_total WHERE clientId = $clientId")->fetchColumn(0);
        $savingAmountTotalCal = (float)$savingAmountTotal;
        $txtMonthlyTotalPaymentCals = (float)$txtMonthlyTotalPayment;

        if ($savingAmountTotalCal > $txtMonthlyTotalPaymentCals) {

            //update reschedule status - start
            $updateStmt = $db->prepare('UPDATE tbl_loan_reschedule SET status=? where LoanId = ? AND paymentDate= ?');

            $updateStmt->bindParam(1, $paid);
            $updateStmt->bindParam(2, $txtLoanId);
            $updateStmt->bindParam(3, $txtRepaymentDate);
            $updateStmt->execute();

            $sqlPMethod = "SELECT * FROM tbl_loan_reschedule where LoanId =$txtLoanId AND status = 'unpaid'";
            $stmt = $db->prepare($sqlPMethod);
            $stmt->execute();
            $paymentDateArray = array();
            while ($row = $stmt->fetchObject()) {
                $id = $row->id;
                $paymentDate = $row->paymentDate;
                array_push($paymentDateArray, $paymentDate);
            }
            $firstDate = reset($paymentDateArray);

            $sqlPMethod = "SELECT * FROM tbl_loan_reschedule where LoanId =$txtLoanId AND status = 'unpaid' AND paymentDate = '$firstDate'";
            $stmt = $db->prepare($sqlPMethod);
            $stmt->execute();
            if ($row = $stmt->fetchObject()) {
                $id = $row->id;
                $monthlyPrincipalAmount = $row->principalAmount;
                $monthlyPrincipalAmount = number_format($monthlyPrincipalAmount, 2);
                $monthlyInterest = $row->interest;
                $monthlyInterest = number_format($monthlyInterest, 2);
                $monthlyamountToPay = $row->amountToPay;
                $monthlyamountToPaycc = $row->amountToPay;
                $monthlyamountToPay = number_format($monthlyamountToPay, 2);
                $monthlyamountToPaycheck = number_format($monthlyamountToPaycc, 2);
                $monthlyamountToPaycheck = str_replace(',', '', $monthlyamountToPaycheck);
                $monthlybalance = $row->balance;

                if ($monthlyamountToPay == '1,833.33') {
                    $monthlyamountToPaycheck = str_replace(',', '', $monthlyamountToPay);
                }
                // $monthlybalance = number_format($monthlybalance, 2);
            }
            //update reschedule status - end

            // if ($txtSavingCheck == 'true') {
            $txtMonthlySav = floatval($txtMonthlySavings);
            $totalsav = $savingsT + $txtMonthlySav;
            $totalsav = number_format($totalsav, 2);
            // } else {
            //     $totalsav = '-';
            // }

            $sql = "SELECT COUNT(*) as row_count, MAX(id) as max_id FROM tbl_loan_repayment";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $maxId = $result['max_id'];
            $FinalId = (int)$maxId + 1;

            //Gen Document - START
            // use Dompdf\Dompdf;

            $body = "
<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Diagnostic Report</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        .page-break {
            page-break-before: always;
          }

        th, td {
            border: 1px solid #000; /* 1px solid black border */
            padding: 8px;
            
        }

        th {
            background-color: #f2f2f2; /* Gray background for header cells */
            text-align: center;
        }
        .headerTable td{
            border: none;
        }
        .card {
            margin-top: 20px;
            width: 100%;
            background-color: #0879AE;
            border-radius: 10px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        }
        .cardhead{
            text-align:center;
            color: white;
        }
        .houseHeadImage{
            align-item: center;
        }
        .container {
            text-align: center;
          }
        .headStyle{
            text-align: center;
            color: blue;
        }
    </style>
</head>

<body>
<table>
<tbody>
  <tr >
        <td>
            Loan Id
        </td>
        <td>
            $txtLoanId
        </td>
    </tr>
    <tr >
    <td>
        Receipt Number
    </td>
    <td>
        $txtReceiptNo
    </td>
    </tr>
    <tr >
    <td>
        Unique Number
    </td>
    <td>
        $txtUniqueNo
    </td>
    </tr>
  <tr >
        <td>
            Payment Date
        </td>
        <td>
            $txtPaymentDate
        </td>
    </tr>
      <tr >
        <td>
            Re-Payment Date
        </td>
        <td>
            $txtRepaymentDate
        </td>
    </tr>
      <tr >
        <td>
           Client Name
        </td>
        <td>
            $clientFullName
        </td>
    </tr>
       <tr >
        <td>
           Loan Officer Name
        </td>
        <td>
            $officeFullName
        </td>
     </tr>
        <tr >
        <td>
           Principal Anount
        </td>
        <td>
            $txtMonthlyPrincipalAmount
        </td>
    </tr>
        <tr >
        <td>
           Interest Amount
        </td>
        <td>
            $txtMonthlyInterest
        </td>
    </tr>
        <tr >
        <td>
           Loan Total Payment
        </td>
        <td>
            $txtMonthlyTotalPayment
        </td>
    </tr>
         <tr >
        <td>
           Loan Amount
        </td>
        <td>
            $Loanprincipal
        </td>
    </tr>
           <tr >
        <td>
           Savings Amount
        </td>
        <td>
            $txtMonthlySavings
        </td>
    </tr>
            <tr >
        <td>
           Savings Total Amount
        </td>
        <td>
            $totalsav
        </td>
    </tr>
       <tr >
        <td>
           Payment Amount
        </td>
        <td>
            $txtPaymentAmount
        </td>
    </tr>
         <tr >
        <td>
           Balance Payment
        </td>
        <td>
            $monthlybalance
        </td>
    </tr>
    </tbody>
    </table>
</body>

</html>
";

            // use Dompdf\Options;

            // $options = new Options();
            // $options->set('isHtml5ParserEnabled', true);
            // $options->set('isPhpEnabled', true);
            // $options->set('isRemoteEnabled', true);

            // // instantiate and use the dompdf class
            // $dompdf = new Dompdf($options);

            // Define the footer HTML and CSS
            $footerHtml = "
    <div style='text-align: center; position: absolute; bottom: 10px; left: 0; right: 0;'>
    <form style='margin-top:300px'>
       <label><strong>Generated/Updated Date & Time : </strong></label>
       <label>$curDate</label>
   </form>
    This document is generated using Account System";
            $footerCss = 'body { position: relative; }';

            $header = "
        <table class='headerTable'>
            <tbody width = '100%'>
                <tr>
                 
                    <td  style='text-align: center;'>
                        <h2>PAYMENT DETAILS</h2>
                    </td>
                </tr>
            </tbody>
        </table>    
        <div style='background-color: blue'></div>
        ";

            // Combine the body content and footer HTML
            $html = '<html><head><style>' . $footerCss . '</style></head><body>' . $header . $body . $footerHtml . '</body></html>';

            // $dompdf->loadHtml($html);

            // // (Optional) Setup the paper size and orientation
            // $dompdf->setPaper('A4', 'portrait');

            // $dompdf->set_base_path(__DIR__);

            // // Render the HTML as PDF
            // $dompdf->render();

            // $pdfOutput = $dompdf->output();

            // // Specify the path to the local folder where you want to save the PDF
            // $localFolderPath = '../../upload/generateDoc/';
            // $filename = $FinalId . '.pdf';

            // Save the PDF to the local folder
            // file_put_contents($localFolderPath . $filename, $pdfOutput);
            //Gen Document - END

            try {

                // if ($txtSavingCheck == 'true') {
                if($txtMonthlySavings != ''){
                $clientId = $db->query("SELECT `clientId` FROM tbl_loan WHERE id = $txtLoanId")->fetchColumn(0);
                $savingStmt = $db->prepare('INSERT INTO `tbl_savings` (date,clientId, savingAmount, status, repaymentId, paymentStatus)
                                        VALUES (:date,:clientId, :savingAmount, :status, :repaymentId, :paymentStatus)');

                $savingStmt->execute([
                    ':date' => $curDate,
                    ':clientId' => $clientId,
                    ':savingAmount' => $txtMonthlySavings,
                    ':status' => 'saving from loan pay',
                    ':repaymentId' => $FinalId,
                    ':paymentStatus' => 'Credit'
                ]);
            }

                $savingAmountTotal = $db->query("SELECT `savingAmountTotal` FROM tbl_savings_total WHERE clientId = $clientId")->fetchColumn(0);
                if ($savingAmountTotal == '') {
                    // $savingTotal = floatval($txtMonthlySavings);
                    $savingtotalStmt = $db->prepare('INSERT INTO `tbl_savings_total` (date,clientId, savingAmountTotal)
                                        VALUES (:date,:clientId, :savingAmountTotal)');

                    $savingtotalStmt->execute([
                        ':date' => $curDate,
                        ':clientId' => $clientId,
                        ':savingAmountTotal' => $txtMonthlySavings
                    ]);
                } else {
                    $savingDB = floatval($savingAmountTotal);
                    $savingTotal = floatval($txtMonthlySavings);
                    $finalTotalSavings = $savingDB + $savingTotal;


                    $updateSavingStmt = $db->prepare('UPDATE tbl_savings_total SET savingAmountTotal=?, date=? where clientId = ? ');

                    $updateSavingStmt->bindParam(1, $finalTotalSavings);
                    $updateSavingStmt->bindParam(2, $curDate);
                    $updateSavingStmt->bindParam(3, $clientId);
                    $updateSavingStmt->execute();
                }
                // }

                // if($txtReduceCheck == 'true'){

                //     $stmt = $db->prepare('INSERT INTO `tbl_loan_repayment` (date,paymentDate,RepaymentDate,monthlyPrincipalAmount,monthlyInterest,monthlyTotalPayment,loanBalance,repaymentOfficer,remarks,loanId, paymentAmount)
                //                                     VALUES (:date,:paymentDate, :RepaymentDate, :monthlyPrincipalAmount, :monthlyInterest, :monthlyTotalPayment, :loanBalance, :repaymentOfficer, :remarks, :loanId, :paymentAmount)');

                //     $stmt->execute([
                //         ':date' => $curDate,
                //         ':paymentDate' => $txtPaymentDate,
                //         ':RepaymentDate' => $txtRepaymentDate,
                //         ':monthlyPrincipalAmount' => $txtMonthlyPrincipalAmount,
                //         ':monthlyInterest' => $txtMonthlyInterest,
                //         ':monthlyTotalPayment' => $txtMonthlyTotalPayment,
                //         ':loanBalance' => $txtLoanBalance,
                //         ':repaymentOfficer' => $txtRepaymentOfficer,
                //         ':remarks' => $txtRemarks,
                //         ':loanId' => $txtLoanId,
                //         ':paymentAmount' => $txtPaymentAmount
                //     ]);

                //     $updateStmt = $db->prepare('UPDATE tbl_loan_reschedule SET status=? where LoanId = ? AND paymentDate= ?');

                //     $updateStmt->bindParam(1, $paid);
                //     $updateStmt->bindParam(2, $txtLoanId);
                //     $updateStmt->bindParam(3, $txtRepaymentDate);
                //     $updateStmt->execute();

                //     $clientId = $db->query("SELECT `clientId` FROM tbl_loan WHERE id = $txtLoanId")->fetchColumn(0);
                //     $firstName = $db->query("SELECT `firstName` FROM tbl_client WHERE id = $clientId")->fetchColumn(0);
                //     $activityPath = $txtLoanId . '-' . $firstName;

                //     $activityStmt = $db->prepare('INSERT INTO `tbl_activity_log` (userName, currentDate, userEmail, userType, activity, activityPath)
                //                                     VALUES (:userName,:currentDate,:userEmail,:userType,:activity,:activityPath) ');

                //     $activityStmt->execute([
                //         ':userName' => $userFirstName,
                //         ':currentDate' => $curDate,
                //         ':userEmail' => $userEmail,
                //         ':userType' => $userType,
                //         ':activity' => 'Create Loan Payment',
                //         ':activityPath' => $activityPath

                //     ]);
                //     echo $FinalId;

                //     //fix issue
                //     // $reduceAmount = floatval($txtMonthlyReducePrincipal);
                //     // for ($t = $reduceAmount; $t > 0;) {
                //     //     $sqlPMethod = "SELECT * FROM tbl_loan_reschedule where LoanId =$txtLoanId AND status = 'unpaid' AND principalAmount != '0'";
                //     //     $stmt = $db->prepare($sqlPMethod);
                //     //     $stmt->execute();
                //     //     $paymentDateArray = array();
                //     //     while ($row = $stmt->fetchObject()) {
                //     //         $paymentDate = $row->paymentDate;
                //     //         array_push($paymentDateArray, $paymentDate);
                //     //     }
                //     //     $firstDate = reset($paymentDateArray);
                //     //     $sqlPMethod = "SELECT * FROM tbl_loan_reschedule WHERE LoanId = $txtLoanId AND status = 'unpaid' AND paymentDate= '$firstDate' ";
                //     //     $stmt = $db->prepare($sqlPMethod);
                //     //     $stmt->execute();
                //     //     if ($row = $stmt->fetchObject()) {
                //     //         $id = $row->id;
                //     //         $amountToPay = $row->amountToPay;
                //     //         $amountToPay = floatval($amountToPay);
                //     //         $interest = $row->interest;
                //     //         $interest = floatval($interest);
                //     //         $principalAmount = $row->principalAmount;
                //     //         $principalAmount = floatval($principalAmount);
                //     //         $balance = $row->balance;
                //     //         $tt_without_comma = str_replace(',', '', $balance);
                //     //         $balance = floatval($tt_without_comma);
                //     //         $test = $t;
                //     //         $ftest = $test - $principalAmount;
                //     //         if ($ftest > 0) {
                //     //             $finalPrincipalAmount = '0';
                //     //             $calFInalPrin = floatval($finalPrincipalAmount);
                //     //             $lastTotalAMountPay = $calFInalPrin + $interest;
                //     //             $lastTotalAMountPay = floatval($lastTotalAMountPay);
                //     //             $finalcal = $amountToPay - $lastTotalAMountPay;
                //     //             $lastBalance = $balance - $finalcal;
                //     //             $lastBalance = number_format($lastBalance, 2);

                //     //             // $sqlPMethod = "SELECT * FROM tbl_loan_reschedule where LoanId =$txtLoanId AND status = 'paid'";
                //     //             // $stmt = $db->prepare($sqlPMethod);
                //     //             // $stmt->execute();
                //     //             // $paymentDateArray = array();
                //     //             // while ($row = $stmt->fetchObject()) {
                //     //             //     $id = $row->id;
                //     //             //     $paymentDate = $row->paymentDate;
                //     //             //     array_push($paymentDateArray, $paymentDate);
                //     //             // }
                //     //             // $lastDate = end($paymentDateArray);

                //     //             // $sqlMethod = "SELECT * FROM tbl_loan_reschedule where LoanId =$txtLoanId AND status = 'paid' AND paymentDate = '$lastDate'";
                //     //             // $stmtt = $db->prepare($sqlMethod);
                //     //             // $stmtt->execute();
                //     //             // if ($row = $stmtt->fetchObject()) {
                //     //             //     $balance = $row->balance;
                //     //             //     $tt_without_comma = str_replace(',', '', $balance);
                //     //             //     $balancee = floatval($tt_without_comma);
                //     //             //     $lBAL = $balancee - $lastTotalAMountPay;
                //     //             //     $lBAL = number_format($lBAL, 2);
                //     //             // }

                //     //             // echo $lastBal;
                //     //             $updateStmt = $db->prepare('UPDATE tbl_loan_reschedule SET principalAmount=?, balance=?, amountToPay=? where id = ?');
                //     //             $updateStmt->bindParam(1, $finalPrincipalAmount);
                //     //             $updateStmt->bindParam(2, $lastBalance);
                //     //             $updateStmt->bindParam(3, $lastTotalAMountPay);
                //     //             $updateStmt->bindParam(4, $id);
                //     //             $updateStmt->execute();
                //     //         } else {
                //     //             $finalPrencipal = $principalAmount - $test;
                //     //             $finalBal = $finalPrencipal + $interest;
                //     //             $finalBal = floatval($finalBal);
                //     //             $lastBL = $balance - $test;
                //     //             $lastBL = number_format($lastBL, 2);
                //     //             $updateStmt = $db->prepare('UPDATE tbl_loan_reschedule SET principalAmount=?, balance=?, amountToPay=? where id = ?');
                //     //             $updateStmt->bindParam(1, $finalPrencipal);
                //     //             $updateStmt->bindParam(2, $lastBL);
                //     //             $updateStmt->bindParam(3, $finalBal);
                //     //             $updateStmt->bindParam(4, $id);
                //     //             $updateStmt->execute();
                //     //             // echo $finalPrencipal .'<br>';
                //     //             // echo $finalBal;
                //     //         }

                //     //     }
                //     //     $t = $ftest;
                //     // }
                //     //fix issue

                // }else{

                // }

                $stmt = $db->prepare('INSERT INTO `tbl_loan_repayment` (date,paymentDate,RepaymentDate,monthlyPrincipalAmount,monthlyInterest,monthlyTotalPayment,loanBalance,repaymentOfficer,remarks,loanId, paymentAmount, uniqueNo,receiptNo, monthlybalance)
    VALUES (:date,:paymentDate, :RepaymentDate, :monthlyPrincipalAmount, :monthlyInterest, :monthlyTotalPayment, :loanBalance, :repaymentOfficer, :remarks, :loanId, :paymentAmount, :uniqueNo, :receiptNo, :monthlybalance)');

                $stmt->execute([
                    ':date' => $curDate,
                    ':paymentDate' => $txtPaymentDate,
                    ':RepaymentDate' => $txtRepaymentDate,
                    ':monthlyPrincipalAmount' => $txtMonthlyPrincipalAmount,
                    ':monthlyInterest' => $txtMonthlyInterest,
                    ':monthlyTotalPayment' => $txtMonthlyTotalPayment,
                    ':loanBalance' => $txtLoanBalance,
                    ':repaymentOfficer' => $txtRepaymentOfficer,
                    ':remarks' => $txtRemarks,
                    ':loanId' => $txtLoanId,
                    ':paymentAmount' => $txtPaymentAmount,
                    ':uniqueNo' => $txtUniqueNo,
                    ':receiptNo' => $txtReceiptNo,
                    ':monthlybalance' => $monthlybalance
                ]);

                $clientId = $db->query("SELECT `clientId` FROM tbl_loan WHERE id = $txtLoanId")->fetchColumn(0);
                $firstName = $db->query("SELECT `firstName` FROM tbl_client WHERE id = $clientId")->fetchColumn(0);
                $activityPath = $txtLoanId . '-' . $firstName;

                $activityStmt = $db->prepare('INSERT INTO `tbl_activity_log` (userName, currentDate, userEmail, userType, activity, activityPath)
    VALUES (:userName,:currentDate,:userEmail,:userType,:activity,:activityPath) ');

                $activityStmt->execute([
                    ':userName' => $userFirstName,
                    ':currentDate' => $curDate,
                    ':userEmail' => $userEmail,
                    ':userType' => $userType,
                    ':activity' => 'Create Loan Payment',
                    ':activityPath' => $activityPath

                ]);

                $balance = $db->query("SELECT `balance` FROM tbl_account WHERE id = $accountId")->fetchColumn(0);
                $balance = (float)$balance;
                if ($txtMonthlySavings != '') {
                    $txtMonthlySavingsCal = (float)$txtMonthlySavings;
                    $totalBalance = $balance + $txtMonthlySavingsCal;
                    $totalBalance = (string)$totalBalance;
                    $db->query("UPDATE tbl_account SET balance = '$totalBalance' WHERE id = $accountId");

                    $stmtTRansferFrom = $db->prepare('INSERT INTO `tbl_transfer_history` (transferDate, account, accountStatus, reason, accountBalance, transferAmount )
        VALUES (:transferDate, :account, :accountStatus,  :reason, :accountBalance, :transferAmount)');

                    $stmtTRansferFrom->execute([
                        ':transferDate' => $currentDate,
                        ':account' => $accountId,
                        ':accountStatus' => 'Credit',
                        ':reason' => 'Loan Savings',
                        ':accountBalance' => $totalBalance,
                        ':transferAmount' => $txtMonthlySavings,
                    ]);
                }

                $formatAmount = str_replace(',', '', $txtMonthlyTotalPayment);
                $txtMonthlyTotalPaymentCal = (float)$formatAmount;
          
                $getBalance = $db->query("SELECT `balance` FROM tbl_account WHERE id = $accountId")->fetchColumn(0);
                $getBalanceCal = (float)$getBalance;
                $finalBalance = $getBalanceCal + $txtMonthlyTotalPaymentCal;
                $finalBalance = (string)$finalBalance;

                $db->query("UPDATE tbl_account SET balance = '$finalBalance' WHERE id = $accountId");

                $stmtTRansferFrom = $db->prepare('INSERT INTO `tbl_transfer_history` (transferDate, account, accountStatus, reason, accountBalance, transferAmount )
    VALUES (:transferDate, :account, :accountStatus,  :reason, :accountBalance, :transferAmount)');

                $stmtTRansferFrom->execute([
                    ':transferDate' => $currentDate,
                    ':account' => $accountId,
                    ':accountStatus' => 'Credit',
                    ':reason' => 'Repayment - '.$txtLoanId,
                    ':accountBalance' => $finalBalance,
                    ':transferAmount' => $formatAmount,
                ]);

                $lastTO = $savingAmountTotalCal - $txtMonthlyTotalPaymentCals;
                $lastTO = (string)$lastTO;
                $updateSavingStmt = $db->prepare('UPDATE tbl_savings_total SET savingAmountTotal=?, date=? where clientId = ? ');

                $updateSavingStmt->bindParam(1, $lastTO);
                $updateSavingStmt->bindParam(2, $currentDate);
                $updateSavingStmt->bindParam(3, $clientId);
                $updateSavingStmt->execute();

                $txtMonthlyTotalPaymentCalStr = (string)$txtMonthlyTotalPaymentCals;
                $clientId = $db->query("SELECT `clientId` FROM tbl_loan WHERE id = $txtLoanId")->fetchColumn(0);
                $savingStmt = $db->prepare('INSERT INTO `tbl_savings` (date,clientId, savingAmount, status, repaymentId, paymentStatus)
                                        VALUES (:date,:clientId, :savingAmount, :status, :repaymentId, :paymentStatus)');

                $savingStmt->execute([
                    ':date' => $curDate,
                    ':clientId' => $clientId,
                    ':savingAmount' => $txtMonthlyTotalPaymentCalStr,
                    ':status' => 'Loan payment from savings amount',
                    ':repaymentId' => $FinalId,
                    ':paymentStatus' => 'Debit'
                ]);

                echo $FinalId;
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
?>
<?php


        }else{
            echo 3;
        }
    }
} else {
    echo 0;
}
?>