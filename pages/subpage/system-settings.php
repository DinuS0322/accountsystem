
<?php
    $sqlPMethod = "SELECT * FROM tbl_account_settings  where accountType = 'DEFAULT_ACCOUNT'";
    $stmtCount = $db->prepare($sqlPMethod);
    $stmtCount->execute();

    if ($row = $stmtCount->fetchObject()) {
        $accountId = $row->accountId;
    }else{
        $accountId = '';
    }
?>

<div class="card shadow">
    <div class="card-header header-bg">
        <i class="fa fa-cog"></i> Account Default Settings
    </div>
    <div class="card-body">
        <div class="row mt-3">
            <div class="col-12 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Select Account <span class="text text-danger">*</span></label>
                    <select id="txtDefaultAccount" class="form-control">
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
                                if($accountId == $id){
                                    echo "<option value='$id' selected>$accountName ($balance)</option>";
                                }else{
                                    echo "<option value='$id'>$accountName ($balance)</option>";
                                }
                                
                            }
                        } catch (PDOException $e) {
                            echo $e->getMessage();
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-12 mt-3 d-flex justify-content-end">
                 <div class="form-group">
                    <button class="btn btn-primary" id="btnDefaultAccount">Update Default Account</button>
                 </div>
             </div>
        </div>
    </div>

        <!-- Custom JS -->
        <script src='../../js/custom/account-settings.js?v=<?= $cashClear ?>'></script>
    <!-- Custom JS -->