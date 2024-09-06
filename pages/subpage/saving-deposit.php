<div class="card shadow">
    <div class="card-header header-bg">
        <i class="fa fa-users"></i> Savings Deposit
    </div>
    <div class="card-body">
        <div class="row mt-3">
            <div class="col fw-bold">
                Select a client
            </div>
            <div class="col">
                <select id="clientData" class="form-control ">
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

        <div id="viewSavingsData"></div>
        
        <div class="row-2 mt-3 d-flex justify-content-end">
            <button class="btn btn-primary" id="btnSavingDeposit">Deposit</button>
        </div>
    </div>
</div>

<!-- Custom JS -->
<script src='../../js/custom/savings-settings.js?v=<?= $cashClear ?>'></script>
<!-- Custom JS -->