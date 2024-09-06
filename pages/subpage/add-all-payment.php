<?php
$curDate = date('Y-m-d');
$uniqueRandom = randomCode(16);
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
                        <option value="">---search---</option>
                        <?php
                        try {
                            $sqlPMethod = "SELECT * FROM tbl_loan ";
                            $stmt = $db->prepare($sqlPMethod);
                            $stmt->execute();
                            $i = 1;
                            while ($row = $stmt->fetchObject()) {
                                $id = $row->id;
                                $clientId = $row->clientId;
                                $principal = $row->principal;  
                                $loanRandomId = $row->loanRandomId;
                                if($loanRandomId == ''){
                                    $loanIdView = $id;
                                }else{
                                    $loanIdView = $loanRandomId;
                                }
                                $principal = number_format($principal, 2);
                                $clientFirstName = $db->query("SELECT `firstName` FROM tbl_client WHERE id = $clientId")->fetchColumn(0);
                                echo "<option value='$id'>$loanIdView - $clientFirstName (Rs. $principal)</option>";
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

                    </select>
                </div>
            </div>

            <div class="col-12 mt-3 ">
                <div class="form-group">
                    <label class="fw-bold mt-1">Payment Amount<span class="text text-danger">*</span></label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="txtPaymentAmount" placeholder="Reduce Amount" aria-label="Reduce Amount" aria-describedby="basic-addon2" >
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

            <div class="col-6 mt-3">
                    <div class="form-group">
                        <label class="fw-bold mt-1">Receipt No </label>
                        <div class="input-group mb-3">
                            <input type="number" class="form-control" id="txtReceiptNo" placeholder="Receipt No" aria-label="Receipt No" aria-describedby="basic-addon2">
                       
                        </div>
                    </div>
                </div>

                <div class="col-6 mt-3">
                    <div class="form-group">
                        <label class="fw-bold mt-1">Unique No </label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="txtUniqueNo" placeholder="Unique No" aria-label="Unique No" aria-describedby="basic-addon2" value="<?= $uniqueRandom ?>" readonly>
                        
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
                </div>

                <div class="col-6">
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

            <div class="col-6 mt-3 " id="savingsDiv">
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
                        <input type="text" class="form-control" id="txtMonthlyPrincipalAmount" placeholder="Principal Amount" aria-label="Principal Amount" aria-describedby="basic-addon2" readonly>
                        <span class="input-group-text" id="basic-addon2">RS</span>
                    </div>
                </div>
            </div>

            <div class="col-6 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Interest <span class="text text-danger">*</span></label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="txtMonthlyInterest" placeholder="Principal Amount" aria-label="Principal Amount" aria-describedby="basic-addon2" readonly>
                        <span class="input-group-text" id="basic-addon2">RS</span>
                    </div>
                </div>
            </div>

            <div class="col-6 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Payment Total Amount <span class="text text-danger">*</span></label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="txtMonthlyTotalPayment" placeholder="Principal Amount" aria-label="Principal Amount" aria-describedby="basic-addon2" readonly>
                        <span class="input-group-text" id="basic-addon2">RS</span>
                    </div>
                </div>
            </div>

            <div class="col-6 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Loan Balance <span class="text text-danger">*</span></label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="txtLoanBalance" placeholder="Principal Amount" aria-label="Principal Amount" aria-describedby="basic-addon2" readonly>
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


<!-- Custom JS -->
<script src='../../js/custom/repayment-settings.js?v=<?= $cashClear ?>'></script>
<!-- Custom JS -->