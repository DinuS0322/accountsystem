<?php
$currentDate = new DateTime();
$currentDate->modify('+1 month');
$newDate = $currentDate->format('Y-m-d');
?>
<div class="card shadow">
    <div class="card-header header-bg">
        <i class="fa fa-plus-square"></i> Create Loan
    </div>
    <div class="card-body">
        <div class="row mt-3">
            <div class="col fw-bold">
                Select a client
            </div>
            <div class="col">
                <select id="searchClient" class="form-control">
                    <option value="">---select---</option>
                    <?php
                    try {
                        $sqlPMethod = 'SELECT * FROM tbl_client';
                        $stmt = $db->prepare($sqlPMethod);
                        $stmt->execute();
                        $i = 1;
                        while ($row = $stmt->fetchObject()) {
                            $id = $row->id;
                            $firstName = $row->firstName;
                            $nicNumber = $row->nicNumber;
                            $accountNumber = $row->accountNumber;
                            echo "<option value='$id'>$firstName - $nicNumber - $accountNumber</option>";
                        }
                    } catch (PDOException $e) {
                        echo $e->getMessage();
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col fw-bold">
                Select a product
            </div>
            <div class="col">
                <select id="searchProduct" class="form-control">
                    <option value="">---select---</option>
                    <?php
                    try {
                        $sqlPMethod = 'SELECT * FROM tbl_loan_product';
                        $stmt = $db->prepare($sqlPMethod);
                        $stmt->execute();
                        $i = 1;
                        while ($row = $stmt->fetchObject()) {
                            $id = $row->id;
                            $productName = $row->productName;
                            echo "<option value='$id'>$productName</option>";
                        }
                    } catch (PDOException $e) {
                        echo $e->getMessage();
                    }
                    ?>
                </select>
            </div>
        </div>
    </div>
</div>

<div class="card shadow hidden" id="showTermsLoan">
    <div class="card-header header-bg">
        Terms
    </div>
    <div class="card-body">
        <div class="row mt-3">
            <div class="col-4 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">shortName</label>
                    <div id="shortNameDiv"></div>
                </div>
            </div>
            <div class="col-4 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Description</label>
                    <div id="descriptionDiv" style="text-align: justify;"></div>
                </div>
            </div>
            <div class="col-4 mt-3 hidden">
                <div class="form-group">
                    <label class="fw-bold mt-1">Fund</label>
                    <select id="txtfund" class="form-control">
                        <option value="Capital">Capital</option>
                        <option value="Investor Fund">Investor Fund</option>
                    </select>
                </div>
            </div>
            <div class="col-4 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Principal</label>
                    <input type='number' id='txtDefaultPrincipal' class='form-control'>
                    <div id="validationCheckPrincipal"></div>
                </div>
            </div>
            <div class="col-4 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">LoanTerm</label>
                    <input type='number' id='txtDefaultLoanTerm' class='form-control'>
                    <div id="validationCheckLognterm"></div>
                </div>
            </div>
            <div class="col-4 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Interest Rate</label>
                    <input type='number' id='txtDefaultInterestRate' class='form-control'>
                    <div id="validationCheckRate"></div>
                </div>
            </div>
            <div class="col-4 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Interest Rate Per</label>
                    <select id="interestPer" class="form-control">
                        <option value="Month">Month</option>
                        <option value="Year">Year</option>
                        <option value="Principal">Principal</option>
                    </select>
                </div>
            </div>
            <div class="col-4 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Repayment Frequency</label>
                    <input type='text' id='txtRepaymentFrequency' class='form-control'>
                </div>
            </div>
            <div class="col-4 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Repayment Type</label>
                    <select id="txtrepaymentType" class="form-control">
                        <option value=""></option>
                        <option value="Days">Days</option>
                        <option value="Weeks">Weeks</option>
                        <option value="Months">Months</option>
                    </select>
                </div>
            </div>
            <div class="col-6 mt-3 hidden">
                <div class="form-group">
                    <label class="fw-bold mt-1">Credit Checks</label>
                    <select id="txtCreditChecks" class="form-control">
                        <option value="Client Written-off Loans Check">Client Written-off Loans Check</option>
                    </select>
                </div>
            </div>
            <div class="col-4 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Gurantors</label>
                    <select id="txtGurantors" class="form-control">
                        <option value=""></option>
                        <option value="Gurantors from client">Gurantors from client</option>
                        <option value="Gurantors from others">Gurantors from others</option>
                    </select>
                </div>
            </div>
            <div class="row-2 d-flex justify-content-end mt-3 ">
                <div class="col">
                    <button class="btn btn-primary btn-sm hidden" id="otherGnBtnDiv" data-bs-toggle="modal" data-bs-target="#addOtherGurantors">
                        Add Gurantors
                    </button>
                </div>
            </div>
            <div class="row mt-3">
                <div id="tableOtherGurantorsDiv" class="hidden"></div>
            </div>
            <div class="row mt-3 hidden" id="gurantorsFromClientDiv">
                <div class="col">
                    <label class="fw-bold mt-1"> Select the gurantors from client</label>
                </div>
                <div class="col">
                    <select id="txtGurantorsFromClient" class="form-control" multiple>
                        <option value=""></option>
                        <?php
                        try {
                            $sqlPMethod = 'SELECT * FROM tbl_client';
                            $stmt = $db->prepare($sqlPMethod);
                            $stmt->execute();
                            $i = 1;
                            while ($row = $stmt->fetchObject()) {
                                $id = $row->id;
                                $firstName = $row->firstName;
                                $lastName = $row->lastName;
                                $fullName = $firstName . ' ' . $lastName;
                                echo "<option value='$id'>$fullName</option>";
                            }
                        } catch (PDOException $e) {
                            echo $e->getMessage();
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row"></div>
        </div>

        <div class="row mt-3">
            <h3>Settings</h3>
        </div>

        <div class="row mt-3">
            <div class="col-6 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Loan Officer</label>
                    <select id="txtLoanOfficerId" class="form-control">
                        <?php
                        try {
                            $sqlPMethod = 'SELECT * FROM tbl_users where userType = "fieldOfficer"';
                            $stmt = $db->prepare($sqlPMethod);
                            $stmt->execute();
                            $i = 1;
                            while ($row = $stmt->fetchObject()) {
                                $id = $row->id;
                                $firstName = $row->firstName;
                                $lastName = $row->lastName;
                                $fullName = $firstName . ' ' . $lastName;
                                $branchName = $row->branchName;
                                echo "<option value='$id'>$fullName</option>";
                            }
                        } catch (PDOException $e) {
                            echo $e->getMessage();
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-6 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Loan Purpose</label>
                    <select id="txtLoanPurpose" class="form-control">
                        <?php
                        try {
                            $sqlPMethod = 'SELECT * FROM tbl_loan_purpose';
                            $stmt = $db->prepare($sqlPMethod);
                            $stmt->execute();
                            $i = 1;
                            while ($row = $stmt->fetchObject()) {
                                $id = $row->id;
                                $purpose = $row->purpose;
                                echo "<option value='$purpose'>$purpose</option>";
                            }
                        } catch (PDOException $e) {
                            echo $e->getMessage();
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-6 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Expected First Repayment date</label>
                    <input type="date" class="form-control" id="txtExpectedFirstRepaymentdDate" value="<?= $newDate ?>">
                </div>
            </div>
            <div class="col-6 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Interest Type</label>
                    <select id="interestType" class="form-control">
                    </select>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <h3>Charges</h3>
        </div>

        <div class="row mt-3">
            <table class="table  table-striped table-align-left" id="viewCharges">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>

        <div class="row mt-3">
            <div class="col-8">
                <select id="getAllChargers" class="form-control">
                    <?php
                    try {
                        $sqlPMethod = 'SELECT * FROM tbl_loan_charge';
                        $stmt = $db->prepare($sqlPMethod);
                        $stmt->execute();
                        $i = 1;
                        while ($row = $stmt->fetchObject()) {
                            $id = $row->id;
                            $chargeName = $row->chargeName;
                            echo "<option value='$id'>$chargeName</option>";
                        }
                    } catch (PDOException $e) {
                        echo $e->getMessage();
                    }
                    ?>
                </select>
            </div>
            <div class="col-4">
                <button class="btn btn-primary" id="addCharges">Add</button>
            </div>
        </div>

        <div class="row mt-3 hidden">
            <h3>Accounts</h3>
        </div>

        <div class="col-6 mt-3 hidden">
            <div class="form-group">
                <label class="fw-bold mt-1">Fund Source</label>
                <select id="txtFundSource" class="form-control">
                    <option value=""></option>
                    <?php
                    try {
                        $sqlPMethod = 'SELECT * FROM tbl_account';
                        $stmt = $db->prepare($sqlPMethod);
                        $stmt->execute();
                        $i = 1;
                        while ($row = $stmt->fetchObject()) {
                            $id = $row->id;
                            $fundResource = $row->fundResource;
                            echo "<option value='$id'>$fundResource</option>";
                        }
                    } catch (PDOException $e) {
                        echo $e->getMessage();
                    }
                    ?>
                </select>
            </div>
        </div>

        <hr>
        <div class="row-2 d-flex justify-content-end mt-3">
            <button class="btn btn-primary" id="createLoan">Create</button>
        </div>

    </div>
</div>


<!-- Add other gurantos Modal -->
<div class="modal fade" id="addOtherGurantors" tabindex="-1" aria-labelledby="addOtherGurantorsLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addOtherGurantorsLabel"><i class="fa fa-user-plus" aria-hidden="true"></i>
                    Gurantors from others </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mt-3">
                    <div class="col">
                        Name
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" id="txtName">
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col">
                        NIC Number
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" id="txtNicNumber">
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col">
                        Address
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" id="txtAddress">
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col">
                        Phone Number
                    </div>
                    <div class="col">
                        <input type="number" class="form-control" id="txtPhoneNumber">
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col">
                        Monthly Salary
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" id="txtMonthlySalary">
                    </div>
                </div>


                <div class="row mt-3">
                    <div class="col">
                        Other Details
                    </div>
                    <div class="col">
                        <textarea id="txtOtherDetails" class="form-control"></textarea>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="modalClose">Close</button>
                <button type="button" class="btn btn-primary" id="btnAddOtherGurantos">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Custom JS -->
<script src='../../js/custom/loan-settings.js?v=<?= $cashClear ?>'></script>
<!-- Custom JS -->