<div class="card shadow">
    <div class="card-header header-bg">
        <i class="fa fa-cog"></i> Charge Type Settings
    </div>
    <div class="card-body">
        <div class="row-2 mt-3 d-flex justify-content-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createChargeType">Add Type</button>
        </div>
        <div class="row mt-3">
            <table class="table table-striped table-align-left" id="chargeTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Charge Type</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    try {
                        $sqlPMethod = 'SELECT * FROM tbl_charge';
                        $stmt = $db->prepare($sqlPMethod);
                        $stmt->execute();
                        $i = 1;
                        while ($row = $stmt->fetchObject()) {
                            $id = $row->id;
                            $chargeType = $row->chargeType;
                            echo "<tr>";
                            echo "<td>$i</td>";
                            echo "<td>$chargeType</td>";
                            echo "</tr>";
                            $i++;
                        }
                    } catch (PDOException $e) {
                        echo $e->getMessage();
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="card shadow">
    <div class="card-header header-bg">
        <i class="fa fa-cog"></i> Loan Purpose Settings
    </div>
    <div class="card-body">
        <div class="row-2 mt-3 d-flex justify-content-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createPurpose">Add Purpose</button>
        </div>
        <div class="row mt-3">
            <table class="table table-striped table-align-left" id="loanPurpose">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Purpose</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    try {
                        $sqlPMethod = 'SELECT * FROM tbl_loan_purpose';
                        $stmt = $db->prepare($sqlPMethod);
                        $stmt->execute();
                        $i = 1;
                        while ($row = $stmt->fetchObject()) {
                            $id = $row->id;
                            $purpose = $row->purpose;
                            echo "<tr>";
                            echo "<td>$i</td>";
                            echo "<td>$purpose</td>";
                            echo "</tr>";
                            $i++;
                        }
                    } catch (PDOException $e) {
                        echo $e->getMessage();
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="createChargeType" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createChargeTypeLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createChargeTypeLabel">Add Charge Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        Charge Type
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" id="txtChargeType">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btnAddChargetype">Save</button>
            </div>
        </div>
    </div>
</div>

<!--Loan Purpose Modal -->
<div class="modal fade" id="createPurpose" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createPurposeLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createPurposeLabel">Add Loan Purpose</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        Loan Purpose
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" id="txtPurpose">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btnAddPurpose">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Custom JS -->
<script src='../../js/custom/other-settings.js?v=<?= $cashClear ?>'></script>
<!-- Custom JS -->