<?php
$id = $_GET['id'];
$sqlPMethod = "SELECT * FROM tbl_loan_product where id='$id'";
$stmt = $db->prepare($sqlPMethod);
$stmt->execute();
if ($row = $stmt->fetchObject()) {
    $date = $row->date;
    $productName = $row->productName;
    $shortName = $row->shortName;
    $description = $row->description;
    $fund = $row->fund;
    $defaultPrincipal = $row->defaultPrincipal;
    $minimumPrincipal = $row->minimumPrincipal;
    $maximumPrincipal = $row->maximumPrincipal;
    $DefaultLoanTerm = $row->DefaultLoanTerm;
    $MinimumLoanTerm = $row->MinimumLoanTerm;
    $MaximumLoanTerm = $row->MaximumLoanTerm;
    $RepaymentFrequency = $row->RepaymentFrequency;
    $repaymentType = $row->repaymentType;
    $InterestPer = $row->InterestPer;
    $DefaultInterestRate = $row->DefaultInterestRate;
    $MinimumInterestRate = $row->MinimumInterestRate;
    $MaximumInterestRate = $row->MaximumInterestRate;
    $Charges = $row->Charges;
    $Active = $row->Active;
    $interestRate = $row->interestRate;
} 
?>
<div class="card shadow">
    <div class="card-header header-bg">
        <i class="fa fa-plus-square"></i> Update Product
    </div>
    <div class="card-body">
        <input type="text" class="hidden" id="txtProductid" value="<?= $id ?>">
        <div class="row mt-3">
            <div class="col-4 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Name</label>
                    <input type="text" class="form-control" id="txtProductName" value="<?= $productName ?>">
                </div>
            </div>
            <div class="col-4 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Short Name</label>
                    <input type="text" class="form-control" id="txtShortName" value="<?= $shortName ?>">
                </div>
            </div>
            <div class="col-4 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Description</label>
                    <input type="text" class="form-control" id="txtDescription" value="<?= $description ?>">
                </div>
            </div>
            <div class="col-4 mt-3 hidden">
                <div class="form-group">
                    <label class="fw-bold mt-1">Fund</label>
                    <select id="txtFund" class="form-control">
                        <option value="" readonly></option>
                        <option value="Capital" <?php if($fund == 'Capital'){ echo 'selected';} ?>>Capital</option>
                        <option value="Investor Fund" <?php if($fund == 'Investor Fund'){ echo 'selected';} ?>>Investor Fund</option>
                    </select>
                </div>
            </div>
            <div class="col-4 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Default Principal</label>
                    <input type="number" class="form-control" id="txtDefaultPrincipal" value="<?= $defaultPrincipal ?>">
                </div>
            </div>
            <div class="col-4 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Minimum Principal</label>
                    <input type="number" class="form-control" id="txtMinimumPrincipal" value="<?= $minimumPrincipal ?>">
                </div>
            </div>
            <div class="col-4 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Maximum Principal</label>
                    <input type="number" class="form-control" id="txtMaximumPrincipal" value="<?= $maximumPrincipal ?>">
                </div>
            </div>
            <div class="col-4 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Default Loan Term</label>
                    <input type="text" class="form-control" id="txtDefaultLoanTerm" value="<?= $DefaultLoanTerm ?>">
                </div>
            </div>
            <div class="col-4 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Minimum Loan Term</label>
                    <input type="text" class="form-control" id="txtMinimumLoanTerm" value="<?= $MinimumLoanTerm ?>">
                </div>
            </div>
            <div class="col-4 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Maximum Loan Term</label>
                    <input type="text" class="form-control" id="txtMaximumLoanTerm" value="<?= $MaximumLoanTerm ?>">
                </div>
            </div>
            <div class="col-4 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Repayment Frequency</label>
                    <input type="text" class="form-control" id="txtRepaymentFrequency" value="<?= $RepaymentFrequency ?>">
                </div>
            </div>
            <div class="col-4 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Type</label>
                    <select id="txtType" class="form-control">
                        <option value="" readonly></option>
                        <option value="Days" <?php if($repaymentType == 'Days'){ echo 'selected';} ?>>Days</option>
                        <option value="Weeks" <?php if($repaymentType == 'Weeks'){ echo 'selected';} ?>>Weeks</option>
                        <option value="Months" <?php if($repaymentType == 'Months'){ echo 'selected';} ?>>Months</option>
                    </select>
                </div>
            </div>
            <div class="col-4 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Default Interest Rate</label>
                    <input type="text" class="form-control" id="txtDefaultInterestRate" value="<?= $DefaultInterestRate ?>">
                </div>
            </div>
            <div class="col-4 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Minimum Interest Rate</label>
                    <input type="text" class="form-control" id="txtMinimumInterestRate" value="<?= $MinimumInterestRate ?>">
                </div>
            </div>
            <div class="col-4 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Maximum Interest Rate</label>
                    <input type="text" class="form-control" id="txtMaximumInterestRate" value="<?= $MaximumInterestRate ?>">
                </div>
            </div>
            <div class="col-4 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Per</label>
                    <select id="txtInterestPer" class="form-control">
                        <option value="" readonly></option>
                        <option value="Month" <?php if($InterestPer == 'Month'){ echo 'selected';} ?>>Month</option>
                        <option value="Year" <?php if($InterestPer == 'Year'){ echo 'selected';} ?>>Year</option>
                        <option value="Principal" <?php if($InterestPer == 'Principal'){ echo 'selected';} ?>>Principal</option>
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
                                    if($Charges == '1'){
                                        echo "<option value='$id' selected>$chargeName</option>";
                                    }else{
                                        echo "<option value='$id'>$chargeName</option>";
                                    }
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
                        <option value="Yes" <?php if($Active == 'Yes'){ echo 'selected';} ?>>Yes</option>
                        <option value="No" <?php if($Active == 'No'){ echo 'selected';} ?>>No</option>
                    </select>
                </div>
            </div>
            <div class="col-4 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Interest Type</label>
                    <select id="txtInterestType" class="form-control">
                        <option value="Flate Rate" <?php if($interestRate == 'Flate Rate'){ echo 'selected';} ?>>Flate Rate</option>
                        <option value="Reduce Amount" <?php if($interestRate == 'Reduce Amount'){ echo 'selected';} ?>>Reduce Amount</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row-2 mt-3 d-flex justify-content-end">
            <button class="btn btn-primary" id="btnUpdateProduct">Update Product</button>
        </div>
    </div>
</div>

<!-- Custom JS -->
<script src='../../js/custom/loan-update-product.js?v=<?= $cashClear ?>'></script>
<!-- Custom JS -->