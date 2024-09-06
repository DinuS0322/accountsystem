<div class="card shadow">
    <div class="card-header header-bg">
        <i class="fa fa-tasks"></i> View Repayment Reports
    </div>
    <div class="card-body">
        <div class="row mt-3">
            <div class="col-6 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Start Date</label>
                    <input type="date" class="form-control" id="txtStartDate">
                </div>
            </div>
            <div class="col-6 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">End Date</label>
                    <input type="date" class="form-control" id="txtEndDate">
                </div>
            </div>
            <div class="col-6 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Loan Officer</label>
                    <select class="form-control selectize" id="selectLoanOfficer">
                        <option value="">---select---</option>
                        <?php
                          $sqlPMethod = 'SELECT * FROM tbl_users where userType="fieldOfficer"';
                          $stmt = $db->prepare($sqlPMethod);
                          $stmt->execute();
                          $i = 1;
                          while ($row = $stmt->fetchObject()) {
                              $id = $row->id;
                              $firstName = $row->firstName;
                              $lastName = $row->lastName;
                              $fullName = $firstName.' '. $lastName;
                              echo "<option value='$id'>$fullName</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col d-flex justify-content-end">
            <button type="button" class="btn btn-primary" id="btnViewRepayment"><i class="bi bi-funnel-fill"></i> Filter</button>
            </div>
        </div>
        <div id="viewRepaymentDiv"></div>
    </div>
</div>

<?php

?>

<!-- Custom JS -->
<script src='../../js/custom/reports.js?v=<?= $cashClear ?>'></script>
<!-- Custom JS -->