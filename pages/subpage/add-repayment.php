<?php
$loanId = $_GET['loanId'];
$curDate = date('Y-m-d');
$uniqueRandom = randomCode(16);
?>


<?php
//check
$start_date = new DateTime('2024-02-20');
$end_date = new DateTime('2024-02-20');

$interval = $start_date->diff($end_date);

$total_days = $interval->days + 1;


if ($start_date > $end_date) {
} else if ($start_date == $end_date) {
} else {

}
//check
?>

<?php
try {
    $sqlPMethod = "SELECT * FROM tbl_loan_reschedule where LoanId =$loanId AND status = 'unpaid'";
    $stmt = $db->prepare($sqlPMethod);
    $stmt->execute();
    $i = 0;
    while ($row = $stmt->fetchObject()) {
        $i++;
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}

if ($i == 0) {
?>
    <div class="alert alert-warning d-flex align-items-center mt-3 justify-content-center" role="alert">
        <i class="fa fa-check-circle " style="margin-right: 10px;"></i>
        <div>
            <strong>Successfully completed the loan thanks your payment!</strong>
        </div>
    </div>

<?php
} else {

?>
    <div class="card shadow">
        <div class="card-header header-bg">
            <i class="fas fa-money-check-alt"></i> Add Re-Payment
        </div>
        <div class="card-body">
            <div class="row mt-3">
                <div class="col-12 mt-3">
                    <div class="form-group">
                        <label class="fw-bold mt-1">Payment Date <span class="text text-danger">*</span></label>
                        <input type="date" class="form-control" id="txtPaymentDate" value="<?= $curDate ?>">
                    </div>
                </div>

                <div class="col-12 mt-3">
                    <div class="form-group">
                        <label class="fw-bold mt-1">Loan ID <span class="text text-danger">*</span></label>
                        <select id="txtLoanId" class="form-control">
                            <?php
                            try {
                                $sqlPMethod = "SELECT * FROM tbl_loan where id =$loanId";
                                $stmt = $db->prepare($sqlPMethod);
                                $stmt->execute();
                                $i = 1;
                                while ($row = $stmt->fetchObject()) {
                                    $id = $row->id;
                                    $clientId = $row->clientId;
                                    $principal = $row->principal;
                                    $principal = number_format($principal, 2);
                                    $clientFirstName = $db->query("SELECT `firstName` FROM tbl_client WHERE id = $clientId")->fetchColumn(0);
                                    echo "<option value='$id'>$id - $clientFirstName (Rs. $principal)</option>";
                                }
                            } catch (PDOException $e) {
                                echo $e->getMessage();
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="col-12 mt-3">
                    <div class="form-group">
                        <label class="fw-bold mt-1">Due Repayment Date <span class="text text-danger">*</span></label>
                        <select id="txtRepaymentDate" class="form-control">
                            <?php
                            try {
                                $sqlPMethod = "SELECT * FROM tbl_loan_reschedule where LoanId =$loanId AND status = 'unpaid'";
                                $stmt = $db->prepare($sqlPMethod);
                                $stmt->execute();
                                $paymentDateArray = array();
                                while ($row = $stmt->fetchObject()) {
                                    $id = $row->id;
                                    $paymentDate = $row->paymentDate;
                                    array_push($paymentDateArray, $paymentDate);
                                }
                                $firstDate = reset($paymentDateArray);
                                echo "<option value='$firstDate'>$firstDate</option>";
                            } catch (PDOException $e) {
                                echo $e->getMessage();
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <!-- Get Montlhy Loan Data - START -->
                <?php
                try {
                    $sqlPMethod = "SELECT * FROM tbl_loan_reschedule where LoanId =$loanId AND status = 'unpaid' AND paymentDate = '$firstDate'";
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
                    $repaymentType = $db->query("SELECT `repaymentType` FROM tbl_loan WHERE id = $loanId")->fetchColumn(0);
                    $interestRate = $db->query("SELECT `interestRate` FROM tbl_loan WHERE id = $loanId")->fetchColumn(0);
                    $principal = $db->query("SELECT `principal` FROM tbl_loan WHERE id = $loanId")->fetchColumn(0);
                    $interestRateType = $db->query("SELECT `interestRateType` FROM tbl_loan WHERE id = $loanId")->fetchColumn(0);
                    $interestPer = $db->query("SELECT `interestPer` FROM tbl_loan WHERE id = $loanId")->fetchColumn(0);
                } catch (PDOException $e) {
                    echo $e->getMessage();
                }
                ?>
                <!-- Get Montlhy Loan Data - END -->
                <input type="text" class="form-control hidden" id="txtrepaymentType" placeholder="Reduce Amount" aria-label="Reduce Amount" aria-describedby="basic-addon2" value="<?= $repaymentType ?>">
                <input type="text" class="form-control hidden" id="txtprincipal" placeholder="Reduce Amount" aria-label="Reduce Amount" aria-describedby="basic-addon2" value="<?= $principal ?>">
                <input type="text" class="form-control hidden" id="txtinterestRate" placeholder="Reduce Amount" aria-label="Reduce Amount" aria-describedby="basic-addon2" value="<?= $interestRate ?>">
                <input type="text" class="form-control hidden" id="txtinterestRateType" placeholder="Reduce Amount" aria-label="Reduce Amount" aria-describedby="basic-addon2" value="<?= $interestRateType ?>">
                <input type="text" class="form-control hidden" id="txtinterestPer" placeholder="Reduce Amount" aria-label="Reduce Amount" aria-describedby="basic-addon2" value="<?= $interestPer ?>">

                <div class="col-12 mt-3 ">
                    <div class="form-group">
                        <label class="fw-bold mt-1">Payment Amount<span class="text text-danger">*</span></label>
                        <div class="input-group mb-3">
                            <input type="number" class="form-control" id="txtPaymentAmount" placeholder="Reduce Amount" aria-label="Reduce Amount" aria-describedby="basic-addon2" value="<?= $monthlyamountToPaycheck ?>">
                            <span class="input-group-text" id="basic-addon2">RS</span>
                        </div>
                    </div>
                </div>

                <div class="col-12 mt-3 ">
                <div class="form-group">
                    <label class="fw-bold mt-1">Payment Option<span class="text text-danger">*</span></label>
                    <div class="input-group mb-3">
                        <select class="form-control" id="dropPaymentOption">
                            <option value="cash">Cash</option>
                            <option value="savings">Savings</option>
                        </select>
                    </div>
                </div>
            </div>

                <div class="row mt-3">
                    <!-- <div class="col-6">
                        <div class="row">
                            <div class="col">
                                <strong>Savings</strong>
                            </div>
                            <div class="col d-flex justify-content-end">
                                <div class="toggle">
                                    <input type="checkbox" id="txtSavingCheck" class="txtSavingCheck" onclick="savingsFunction()">
                                    <label for="txtSavingCheck">
                                        <h2>OFF</h2>
                                        <h1>ON</h1>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <!-- <div class="col-6">
                        <div class="row">
                            <div class="col mt-2">
                                <strong>Reduce Principal</strong>
                            </div>
                            <div class="col d-flex justify-content-end">
                                <div class="toggle">
                                    <input type="checkbox" id="txtReduceCheck" class="txtReduceCheck" onclick="myFunction()">
                                    <label for="txtReduceCheck">
                                        <h2>OFF</h2>
                                        <h1>ON</h1>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div> -->

                </div>

                <div class="col-6 mt-3" id="savingsDiv">
                    <div class="form-group">
                        <label class="fw-bold mt-1">Savings Amount<span class="text text-danger">*</span></label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="txtMonthlySavings" placeholder="Savings Amount" aria-label="Savings Amount" aria-describedby="basic-addon2" readonly>
                            <span class="input-group-text" id="basic-addon2">RS</span>
                        </div>
                    </div>
                </div>

                <div class="col-6 mt-3 hidden" id="reduceDiv">
                    <div class="form-group">
                        <label class="fw-bold mt-1">Reduce Principal Amount<span class="text text-danger">*</span></label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="txtMonthlyReducePrincipal" placeholder="Reduce Amount" aria-label="Reduce Amount" aria-describedby="basic-addon2" readonly>
                            <span class="input-group-text" id="basic-addon2">RS</span>
                        </div>
                    </div>
                </div>


                <div class="col-6 mt-3">
                    <div class="form-group">
                        <label class="fw-bold mt-1">Principal Amount<span class="text text-danger">*</span></label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="txtMonthlyPrincipalAmount" placeholder="Principal Amount" aria-label="Principal Amount" aria-describedby="basic-addon2" value="<?= $monthlyPrincipalAmount ?>" readonly>
                            <span class="input-group-text" id="basic-addon2">RS</span>
                        </div>
                    </div>
                </div>

                <div class="col-6 mt-3">
                    <div class="form-group">
                        <label class="fw-bold mt-1">Interest <span class="text text-danger">*</span></label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="txtMonthlyInterest" placeholder="Principal Amount" aria-label="Principal Amount" aria-describedby="basic-addon2" value="<?= $monthlyInterest ?>" readonly>
                            <span class="input-group-text" id="basic-addon2">RS</span>
                        </div>
                    </div>
                </div>

                <div class="col-6 mt-3">
                    <div class="form-group">
                        <label class="fw-bold mt-1">Payment Total Amount <span class="text text-danger">*</span></label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="txtMonthlyTotalPayment" placeholder="Principal Amount" aria-label="Principal Amount" aria-describedby="basic-addon2" value="<?= $monthlyamountToPay ?>" readonly>
                            <span class="input-group-text" id="basic-addon2">RS</span>
                        </div>
                    </div>
                </div>

                <div class="col-6 mt-3">
                    <div class="form-group">
                        <label class="fw-bold mt-1">Loan Balance <span class="text text-danger">*</span></label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="txtLoanBalanceView" placeholder="Principal Amount" aria-label="Principal Amount" aria-describedby="basic-addon2" value="<?= $monthlybalance ?>" readonly>
                            <input type="text" class="form-control hidden" id="txtLoanBalance" placeholder="Principal Amount" aria-label="Principal Amount" aria-describedby="basic-addon2" value="<?= $monthlybalance ?>" readonly>
                            <span class="input-group-text" id="basic-addon2">RS</span>
                        </div>
                    </div>
                </div>

                <div class="col-6 mt-3">
                    <div class="form-group">
                        <label class="fw-bold mt-1">Receipt No </label>
                        <div class="input-group mb-3">
                            <input type="number" class="form-control" id="txtReceiptNo" placeholder="Receipt No" aria-label="Receipt No" aria-describedby="basic-addon2">
                            <span class="input-group-text" id="basic-addon2">RS</span>
                        </div>
                    </div>
                </div>

                <div class="col-6 mt-3">
                    <div class="form-group">
                        <label class="fw-bold mt-1">Unique No </label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="txtUniqueNo" placeholder="Unique No" aria-label="Unique No" aria-describedby="basic-addon2" value="<?= $uniqueRandom ?>" readonly>
                            <span class="input-group-text" id="basic-addon2">RS</span>
                        </div>
                    </div>
                </div>

                <div class="col-12 mt-3">
                    <div class="form-group">
                        <label class="fw-bold mt-1">Repayment Officer Name <span class="text text-danger">*</span></label>
                        <div class="input-group mb-3">
                            <input type="text" id="" class="form-control" value="<?= $SESS_USER_NAME . ' ' . $SESS_USER_LAST_NAME ?>" readonly>
                            <input type="text" id="txtRepaymentOfficer" class="form-control hidden" value="<?= $SESS_USER_ID ?>" readonly>
                        </div>
                    </div>
                </div>

                <div class="col-12 mt-3">
                    <div class="form-group">
                        <label class="fw-bold mt-1">Remarks </label>
                        <div class="input-group mb-3">
                            <textarea id="txtRemarks" class="form-control" placeholder="Remarks"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-2 d-flex justify-content-end">
                <button class="btn btn-primary" id="btnSubmitRepayment">Submit</button>
            </div>
        </div>
    </div>
<?php
}
?>

<!-- Custom JS -->
<script src='../../js/custom/loan-settings.js?v=<?= $cashClear ?>'></script>
<!-- Custom JS -->