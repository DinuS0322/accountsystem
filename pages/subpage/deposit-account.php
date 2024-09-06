<div class="card shadow">
    <div class="card-header header-bg">
        <i class="fa fa-cog"></i> Deposit Accounts
    </div>
    <div class="card-body">
        <div class="row mt-3">
            <div class="col-6 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Account <span class="text text-danger">*</span></label>
                    <select id="txtSelectAccount" class="form-control">
                        <option value="">Select Account</option>
                        <?php
                        try {
                            $sqlPMethod = "SELECT * FROM tbl_account where accountStatus = 'active'";
                            $stmt = $db->prepare($sqlPMethod);
                            $stmt->execute();
                            while ($row = $stmt->fetchObject()) {
                                $id = $row->id;
                                $accountName = $row->accountName;
                                $balance = $row->balance;
                                $balance = number_format($balance, 2);
                                echo "<option value='$id'>$accountName ($balance)</option>";
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
                    <label class="fw-bold mt-1">Deposit Amount <span class="text text-danger">*</span></label>
                    <input type="number" class="form-control" id="txtDepositAmount">
                </div>
            </div>
        </div>
        <div class="row-2 d-flex justify-content-end">
            <button class="btn btn-primary btn-sm" id="btnDepositAmount">
                Deposit
            </button>
        </div>
    </div>
</div>

<!-- Custom JS -->
<script src='../../js/custom/account-settings.js?v=<?= $cashClear ?>'></script>
<!-- Custom JS -->