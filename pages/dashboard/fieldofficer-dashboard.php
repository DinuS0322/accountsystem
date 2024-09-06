<div class="row">
    <div class="col-md-6 col-lg-6 col-sm-12">
        <h2 style="font-family: serif;">Hello, <?= $SESS_USER_NAME . ' ' . $SESS_USER_LAST_NAME ?>!</h2>
    </div>

</div>


<?php
$sqlPMethod = 'SELECT * FROM tbl_loan_repayment';
$stmt = $db->prepare($sqlPMethod);
$stmt->execute();
$totalRepayment = 0;
while ($row = $stmt->fetchObject()) {
    $monthlyTotalPayment = $row->monthlyTotalPayment;
    $monthlyTotalPayment = str_replace(',', '', $monthlyTotalPayment);
    $monthlyTotalPayment = (float)$monthlyTotalPayment;
    $totalRepayment = $totalRepayment + $monthlyTotalPayment;
}

$sqlPMethodre = 'SELECT * FROM tbl_loan_reschedule where status="unpaid"';
$stmtre = $db->prepare($sqlPMethodre);
$stmtre->execute();
$totalRepaymentre = 0;
while ($row = $stmtre->fetchObject()) {
    $amountToPay = $row->amountToPay;
    $amountToPay = str_replace(',', '', $amountToPay);
    $amountToPay = (float)$amountToPay;
    $totalRepaymentre = $totalRepaymentre + $amountToPay;
}

$sqlPMethodrewriteoff = 'SELECT * FROM tbl_loan_reschedule where status="writeoff"';
$stmtrewriteoff = $db->prepare($sqlPMethodrewriteoff);
$stmtrewriteoff->execute();
$totalRepaymentrewriteoff = 0;
while ($row = $stmtrewriteoff->fetchObject()) {
    $amountToPay = $row->amountToPay;
    $amountToPay = str_replace(',', '', $amountToPay);
    $amountToPay = (float)$amountToPay;
    $totalRepaymentrewriteoff = $totalRepaymentrewriteoff + $amountToPay;
}

$sqlPMethodreinterestwise = 'SELECT * FROM tbl_interestwise';
$stmtreinterestwise = $db->prepare($sqlPMethodreinterestwise);
$stmtreinterestwise->execute();
$totalRepaymentrinterestwise = 0;
while ($row = $stmtreinterestwise->fetchObject()) {
    $interestwiseamount = $row->interestwiseamount;
    $interestwiseamount = str_replace(',', '', $interestwiseamount);
    $interestwiseamount = (float)$interestwiseamount;
    $totalRepaymentrinterestwise = $totalRepaymentrinterestwise + $interestwiseamount;
}

$sqlPMethodLoan = 'SELECT * FROM tbl_loan';
$stmtLoan = $db->prepare($sqlPMethodLoan);
$stmtLoan->execute();
$totalloan = 0;
while ($row = $stmtLoan->fetchObject()) {
    $principal = $row->principal;
    $principal = str_replace(',', '', $principal);
    $principal = (float)$principal;
    $totalloan = $totalloan + $principal;
}
$totalloan = number_format($totalloan, 2);
$totalRepaymentre = number_format($totalRepaymentre, 2);
$totalRepayments = number_format($totalRepayment, 2);
$totalRepaymentrewriteoff = number_format($totalRepaymentrewriteoff, 2);
$totalRepaymentrinterestwise = number_format($totalRepaymentrinterestwise, 2);
?>

<hr class="mb-2 mt-2">

<section class="section dashboard">

    <div>
        <h3 class="text-theme strong mt-3">Dashboard</h3>
    </div>

    <div class="row mt-3">
        <div class="notification col-sm-12 col-md-4 mt-3">
            <div class="notiglow"></div>
            <div class="notiborderglow"></div>
            <div class="notititle mt-2">
                <h4 class="fw-bold">Total Repayment</h4>
            </div>
            <div class="notibody mt-2">
                <h6> RS. <?= $totalRepayments ?></h6>
            </div>
        </div>
        <div class="col-sm-12 col-md-1"></div>
        <div class="notification col-sm-12 col-md-4 mt-3">
            <div class="notiglow"></div>
            <div class="notiborderglow"></div>
            <div class="notititle mt-2">
                <h4 class="fw-bold">Pending Repayment</h4>
            </div>
            <div class="notibody mt-2">
                <h6> RS. <?= $totalRepaymentre ?></h6>
            </div>
        </div>
        <div class="col-sm-12 col-md-1"></div>
        <div class="notification col-sm-12 col-md-4 mt-3">
            <div class="notiglow"></div>
            <div class="notiborderglow"></div>
            <div class="notititle mt-2">
                <h4 class="fw-bold">Total Loan</h4>
            </div>
            <div class="notibody mt-2">
                <h6> RS. <?= $totalloan ?></h6>
            </div>
        </div>
        <div class="notification col-sm-12 col-md-4 mt-3">
            <div class="notiglow"></div>
            <div class="notiborderglow"></div>
            <div class="notititle mt-2">
                <h4 class="fw-bold">Total Write Off</h4>
            </div>
            <div class="notibody mt-2">
                <h6> RS. <?= $totalRepaymentrewriteoff ?></h6>
            </div>
        </div>
        <div class="col-sm-12 col-md-1"></div>
        <div class="notification col-sm-12 col-md-4 mt-3">
            <div class="notiglow"></div>
            <div class="notiborderglow"></div>
            <div class="notititle mt-2">
                <h4 class="fw-bold">Total interest wise</h4>
            </div>
            <div class="notibody mt-2">
                <h6> RS. <?= $totalRepaymentrinterestwise ?></h6>
            </div>
        </div>
    </div>

    <!-- <a href="index.php?page=all-subpages&subpage=test">
        <button class="btn btn-primary">test</button>
    </a> -->

</section>





<!-- Custom JS -->
<script src='js/custom/dashboard.js?v=<?= $cashClear ?>'></script>
<!-- Custom JS -->