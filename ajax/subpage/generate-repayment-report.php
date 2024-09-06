<?php
require '../../config.php';
require '../../source/dompdf/autoload.inc.php';


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


$repaymentId = filter_var($_POST['repaymentId'], FILTER_DEFAULT);


$sqlPMethod = "SELECT * FROM tbl_loan_repayment where id = $repaymentId";
$stmt = $db->prepare($sqlPMethod);
$stmt->execute();
if ($row = $stmt->fetchObject()) {
    $id = $row->id;
    $loanId = $row->loanId;
    $loanRandomId = $db->query("SELECT `loanRandomId` FROM tbl_loan WHERE id = $loanId")->fetchColumn(0);
    if($loanRandomId == ''){
        $loanIdView = $loanId;
    }else{
        $loanIdView = $loanRandomId;
    }
    $receiptNo = $row->receiptNo;
    $uniqueNo = $row->uniqueNo;
    $paymentDate = $row->paymentDate;
    $RepaymentDate = $row->RepaymentDate;
    $RepaymentDate = $row->RepaymentDate;
    $clientId = $db->query("SELECT `clientId` FROM tbl_loan WHERE id = $loanId")->fetchColumn(0);
    $clientfirstName = $db->query("SELECT `firstName` FROM tbl_client WHERE id = $clientId")->fetchColumn(0);
    $clientlastName = $db->query("SELECT `lastName` FROM tbl_client WHERE id = $clientId")->fetchColumn(0);
    $clientFullName = $clientfirstName . ' ' . $clientlastName;
    $repaymentOfficer = $row->repaymentOfficer;
    $officerfirstName = $db->query("SELECT `firstName` FROM tbl_users WHERE id = $repaymentOfficer")->fetchColumn(0);
    $officerlastName = $db->query("SELECT `lastName` FROM tbl_users WHERE id = $repaymentOfficer")->fetchColumn(0);
    $officerFullName = $officerfirstName . ' ' . $officerlastName;
    $monthlyPrincipalAmount = $row->monthlyPrincipalAmount;
    $monthlyInterest = $row->monthlyInterest;
    $monthlyInterest = $row->monthlyInterest;
    $monthlyTotalPayment = $row->monthlyTotalPayment;
    $principal = $db->query("SELECT `principal` FROM tbl_loan WHERE id = $loanId")->fetchColumn(0);
    $principal_amount = number_format($principal, 2);
    $savingAmount = $db->query("SELECT `savingAmount` FROM tbl_savings WHERE repaymentId = $id")->fetchColumn(0);
    $savingAmountTotal = $db->query("SELECT `savingAmountTotal` FROM tbl_savings_total WHERE clientId = $clientId")->fetchColumn(0);
    $paymentAmount = $row->paymentAmount;
    $monthlybalance = $row->monthlybalance;
}




//Gen Document - START
use Dompdf\Dompdf;

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
            $loanIdView
        </td>
    </tr>
    <tr >
    <td>
        Receipt Number
    </td>
    <td>
        $receiptNo
    </td>
    </tr>
    <tr >
    <td>
        Unique Number
    </td>
    <td>
        $uniqueNo
    </td>
    </tr>
  <tr >
        <td>
            Payment Date
        </td>
        <td>
            $paymentDate
        </td>
    </tr>
      <tr >
        <td>
            Re-Payment Date
        </td>
        <td>
            $RepaymentDate
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
        Re-payment  Name
        </td>
        <td>
            $officerFullName
        </td>
     </tr>
        <tr >
        <td>
           Principal Anount
        </td>
        <td>
            $monthlyPrincipalAmount
        </td>
    </tr>
        <tr >
        <td>
           Interest Amount
        </td>
        <td>
            $monthlyInterest
        </td>
    </tr>
        <tr >
        <td>
           Loan Total Payment
        </td>
        <td>
            $monthlyTotalPayment
        </td>
    </tr>
         <tr >
        <td>
           Loan Amount
        </td>
        <td>
            $principal_amount
        </td>
    </tr>
           <tr >
        <td>
           Savings Amount
        </td>
        <td>
            $savingAmount
        </td>
    </tr>
            <tr >
        <td>
           Savings Total Amount
        </td>
        <td>
            $savingAmountTotal
        </td>
    </tr>
       <tr >
        <td>
           Payment Amount
        </td>
        <td>
            $paymentAmount
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

use Dompdf\Options;

$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isPhpEnabled', true);
$options->set('isRemoteEnabled', true);

// instantiate and use the dompdf class
$dompdf = new Dompdf($options);

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

$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

$dompdf->set_base_path(__DIR__);

// Render the HTML as PDF
$dompdf->render();

$pdfOutput = $dompdf->output();

// Specify the path to the local folder where you want to save the PDF
$localFolderPath = '../../upload/generateDoc/';
$filename = $repaymentId . '.pdf';

// Save the PDF to the local folder
file_put_contents($localFolderPath . $filename, $pdfOutput);
//Gen Document - END

echo $repaymentId;