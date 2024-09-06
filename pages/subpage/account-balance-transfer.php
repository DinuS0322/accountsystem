<?php
$currentDate = date("Y-m-d");
?>
<div class="card shadow">
    <div class="card-header header-bg">
        <i class="fa fa-suitcase"></i> Account Balance Transfer
    </div>
    <div class="card-body">
        <div class="row mt-3">
            <div class="col-6 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Transfer Reason <span class="text text-danger">*</span></label>
                    <input type="text" class="form-control" id="txtTransferReason">
                </div>
            </div>
            <div class="col-6 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">From Account <span class="text text-danger">*</span></label>
                    <select id="txtFromAccount" class="form-control">
                        <option value="">Select Account</option>
                        <?php
                        try {
                            $sqlPMethod = "SELECT * FROM tbl_account  where accountStatus = 'active'";
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
                    <label class="fw-bold mt-1">To Account <span class="text text-danger">*</span></label>
                    <select id="txtToAccount" class="form-control">
                        <option value="">Select Account</option>
                        <?php
                        try {
                            $sqlPMethod = "SELECT * FROM tbl_account  where accountStatus = 'active'";
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
                    <label class="fw-bold mt-1">Available Balance <span class="text text-danger">*</span></label>
                    <input type="text" class="form-control" id="txtAvailableBalance" readonly>
                </div>
            </div>
            <div class="col-6 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Amount <span class="text text-danger">*</span></label>
                    <input type="number" class="form-control" id="txtTransferAmount">
                </div>
            </div>
            <div class="col-6 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Date <span class="text text-danger">*</span></label>
                    <input type="date" class="form-control" id="txtTransferDate" value="<?= $currentDate ?>">
                </div>
            </div>
            <div class="col-12 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Note <span class="text text-danger">*</span></label>
                    <textarea id="txtTransferNote" class="form-control"></textarea>
                </div>
            </div>

        </div>
        <div class="row-2 d-flex justify-content-end mt-3">
            <button class="btn btn-primary btn-sm" id="btnAccountTransfer">Account Transfer</button>
        </div>
    </div>

    <!-- Custom JS -->
    <script src='../../js/custom/account-settings.js?v=<?= $cashClear ?>'></script>
    <!-- Custom JS -->