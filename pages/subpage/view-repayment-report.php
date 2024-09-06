<?php
$repaymentId = $_GET['id'];

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
    $officerFullName = $officerfirstName.' '. $officerlastName;
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


?>
<div class="card shadow">
    <div class="card-header header-bg">
        <i class="fas fa-money-check-alt"></i> View Repayment Details
    </div>
    <div class="card-body">
        <div class="row-2 d-flex justify-content-end mt-3">
            <button class="btn btn-primary btn-sm generatePaymentReport" data-repaymentId="<?= $repaymentId ?>">Generate Report</button>
        </div>
        <div id="viewRepaymentDetails" class="row mt-5">
            <table class="table table-align-left" style="border: 1px solid black;" id="viewLoanDetailsTable">
                <tbody>
                    <tr>
                        <td class="fw-bold">Loan Id</td>
                        <td><?= $loanIdView ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Receipt Number</td>
                        <td><?= $receiptNo ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Unique Number</td>
                        <td><?= $uniqueNo ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Payment Date</td>
                        <td><?= $paymentDate ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Re-Payment Date</td>
                        <td><?= $RepaymentDate ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Client Name</td>
                        <td><?= $clientFullName ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Re-payment Officer Name</td>
                        <td><?= $officerFullName ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Principal Amount </td>
                        <td><?= $monthlyPrincipalAmount ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Interest Amount </td>
                        <td><?= $monthlyInterest ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Loan Total Payment </td>
                        <td><?= $monthlyTotalPayment ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Loan Amount </td>
                        <td><?= $principal_amount ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Savings Amount </td>
                        <td><?= $savingAmount ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Savings Total Amount </td>
                        <td><?= $savingAmountTotal ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Payment Amount </td>
                        <td><?= $paymentAmount ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Balance Payment </td>
                        <td><?= $monthlybalance ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Custom JS -->
<script src='../../js/custom/loan-settings.js?v=<?= $cashClear ?>'></script>
<!-- Custom JS -->