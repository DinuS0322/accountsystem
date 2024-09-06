<div class="card shadow">
    <div class="card-header header-bg">
        <i class="fa fa-plus-square"></i> Add Product
    </div>
    <div class="card-body">
        <div class="row mt-3">
            <div class="col-4 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Name</label>
                    <input type="text" class="form-control" id="txtProductName">
                </div>
            </div>
            <div class="col-4 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Short Name</label>
                    <input type="text" class="form-control" id="txtShortName">
                </div>
            </div>
            <div class="col-4 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Description</label>
                    <input type="text" class="form-control" id="txtDescription">
                </div>
            </div>
            <div class="col-4 mt-3 hidden">
                <div class="form-group">
                    <label class="fw-bold mt-1">Fund</label>
                    <select id="txtFund" class="form-control">
                        <option value="" readonly></option>
                        <option value="Capital">Capital</option>
                        <option value="Investor Fund">Investor Fund</option>
                    </select>
                </div>
            </div>
            <div class="col-4 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Default Principal</label>
                    <input type="number" class="form-control" id="txtDefaultPrincipal">
                </div>
            </div>
            <div class="col-4 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Minimum Principal</label>
                    <input type="number" class="form-control" id="txtMinimumPrincipal">
                </div>
            </div>
            <div class="col-4 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Maximum Principal</label>
                    <input type="number" class="form-control" id="txtMaximumPrincipal">
                </div>
            </div>
            <div class="col-4 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Default Loan Term</label>
                    <input type="text" class="form-control" id="txtDefaultLoanTerm">
                </div>
            </div>
            <div class="col-4 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Minimum Loan Term</label>
                    <input type="text" class="form-control" id="txtMinimumLoanTerm">
                </div>
            </div>
            <div class="col-4 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Maximum Loan Term</label>
                    <input type="text" class="form-control" id="txtMaximumLoanTerm">
                </div>
            </div>
            <div class="col-4 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Repayment Frequency</label>
                    <input type="text" class="form-control" id="txtRepaymentFrequency">
                </div>
            </div>
            <div class="col-4 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Type</label>
                    <select id="txtType" class="form-control">
                        <option value="" readonly></option>
                        <option value="Days">Days</option>
                        <option value="Weeks">Weeks</option>
                        <option value="Months">Months</option>
                    </select>
                </div>
            </div>
            <div class="col-4 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Default Interest Rate</label>
                    <input type="text" class="form-control" id="txtDefaultInterestRate">
                </div>
            </div>
            <div class="col-4 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Minimum Interest Rate</label>
                    <input type="text" class="form-control" id="txtMinimumInterestRate">
                </div>
            </div>
            <div class="col-4 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Maximum Interest Rate</label>
                    <input type="text" class="form-control" id="txtMaximumInterestRate">
                </div>
            </div>
            <div class="col-4 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Per</label>
                    <select id="txtInterestPer" class="form-control">
                        <option value="" readonly></option>
                        <option value="Month">Month</option>
                        <option value="Year">Year</option>
                        <option value="Principal">Principal</option>
                    </select>
                </div>
            </div>
            <div class="col-4 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Charges</label>
                    <select id="txtCharges" class="form-control">
                        <option value="" readonly></option>
                        <?php
                        try {
                            $sqlPMethod = 'SELECT * FROM tbl_loan_charge';
                            $stmt = $db->prepare($sqlPMethod);
                            $stmt->execute();
                            while ($row = $stmt->fetchObject()) {
                                $id = $row->id;
                                $chargeName = $row->chargeName;
                                $active = $row->active;
                                if ($active == 'Yes') {
                                    echo "<option value='$id'>$chargeName</option>";
                                }
                            }
                        } catch (PDOException $e) {
                            echo $e->getMessage();
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-4 mt-3 hidden">
                <div class="form-group">
                    <label class="fw-bold mt-1">Credit Checks</label>
                    <select id="txtCreditChecks" class="form-control">
                        <option value="" readonly></option>
                        <option value="Client Written-off Loans Check">Client Written-off Loans Check</option>
                    </select>
                </div>
            </div>
            <div class="col-4 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Active</label>
                    <select id="txtActive" class="form-control">
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                </div>
            </div>
            <div class="col-4 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Interest Type</label>
                    <select id="txtInterestType" class="form-control">
                        <option value="Flate Rate">Flate Rate</option>
                        <option value="Reduce Amount">Reduce Amount</option>
                    </select>
                </div>
            </div>
            <!-- <div class="col-12 mt-3">
                <h3>Accounting</h3>
            </div>
            <div class="col-6 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Fund Source</label>
                    <select id="txtFundSource" class="form-control">
                        <option value="" readonly></option>
                    </select>
                </div>
            </div>
            <div class="col-6 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Loan Portfolio</label>
                    <select id="txtLoanPortfolio" class="form-control">
                        <option value="" readonly></option>
                    </select>
                </div>
            </div>
            <div class="col-6 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Overpayments</label>
                    <select id="txtOverpayments" class="form-control">
                        <option value="" readonly></option>
                    </select>
                </div>
            </div>
            <div class="col-6 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Suspended Income</label>
                    <select id="txtSuspendedIncome" class="form-control">
                        <option value="" readonly></option>
                    </select>
                </div>
            </div>
            <div class="col-3 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Income from Interest</label>
                    <select id="txtIncomeFromInterest" class="form-control">
                        <option value="" readonly></option>
                    </select>
                </div>
            </div>
            <div class="col-3 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Income from penalties</label>
                    <select id="txtIncomefrompenalties" class="form-control">
                        <option value="" readonly></option>
                    </select>
                </div>
            </div>
            <div class="col-3 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Income from fees</label>
                    <select id="txtIncomefromfees" class="form-control">
                        <option value="" readonly></option>
                    </select>
                </div>
            </div>
            <div class="col-3 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Income from recovery</label>
                    <select id="txtIncomefromrecovery" class="form-control">
                        <option value="" readonly></option>
                    </select>
                </div>
            </div>
            <div class="col-6 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Auto Disburse</label>
                    <select id="txtAutoDisburse" class="form-control">
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                </div>
            </div>
            <div class="col-6 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Active</label>
                    <select id="txtActive" class="form-control">
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                </div>
            </div> -->
        </div>
        <div class="row-2 mt-3 d-flex justify-content-end">
            <button class="btn btn-primary" id="btnCreateProduct">Create Product</button>
        </div>
    </div>
</div>

<!-- Custom JS -->
<script src='../../js/custom/loan-manage-product.js?v=<?= $cashClear ?>'></script>
<!-- Custom JS -->