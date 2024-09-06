<div class="card shadow">
    <div class="card-header header-bg">
        <i class="fa fa-plus-square"></i> Add Charges
    </div>
    <div class="card-body">
        <div class="row mt-3">
            <div class="col-6 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Name</label>
                    <input type="text" class="form-control" id="txtChargeName">
                </div>
            </div>
            <div class="col-6 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Charge Type</label>
                    <select id="txtChargesType" class="form-control">
                        <option value=""></option>
                        <?php
                        try {
                            $sqlPMethod = 'SELECT * FROM tbl_charge';
                            $stmt = $db->prepare($sqlPMethod);
                            $stmt->execute();
                            while ($row = $stmt->fetchObject()) {
                                $id = $row->id;
                                $chargeType = $row->chargeType;
                                echo "<option value='$id'>$chargeType</option>";
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
                    <label class="fw-bold mt-1">Amount</label>
                    <input type="number" class="form-control" id="txtAmount">
                </div>
            </div>
            <div class="col-6 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Charge Option</label>
                    <select id="txtChargeOption" class="form-control">
                        <option value=""></option>
                        <option value="Flat">Flat</option>
                        <option value="Principal due on installment">Principal due on installment</option>
                        <option value="Original loan principal">Original loan principal</option>
                    </select>
                </div>
            </div>
            <div class="col-6 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Penalty</label>
                    <select id="txtPenalty" class="form-control">
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                </div>
            </div>
            <div class="col-6 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Override</label>
                    <select id="txtOverride" class="form-control">
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
            </div>
        </div>
        <div class="row-2 d-flex justify-content-end">
            <button class="btn btn-primary" id="btnAddCharges">Save</button>
        </div>
    </div>
</div>

<!-- Custom JS -->
<script src='../../js/custom/loan-manage-charge.js?v=<?= $cashClear ?>'></script>
<!-- Custom JS -->