<div class="card shadow">
    <div class="card-header header-bg">
        <i class="bi bi-bank"></i> Create Savings Withdrawal
    </div>
    <div class="card-body">
        <div class="row mt-3">
            <div class="col fw-bold">
                Select a Member
            </div>
            <div class="col">
                <select id="searchMember" class="form-control selectize">
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
        <div class="row mt-3">
            <div class="col fw-bold">
                Amount
            </div>
            <div class="col">
                <input type="number" class="form-control" placeholder="Enter the amount" id="txtAmount">
            </div>
        </div>
        <div class="row mt-3">
            <div class="col fw-bold">
                Reason
            </div>
            <div class="col">
                <textarea id="txtReason" class="form-control" placeholder="Enter the reason"></textarea>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col d-flex justify-content-end">
                <button class="btn btn-primary" id="btnCreateWithdrawal">Withdrawal</button>
            </div>
        </div>
    </div>
</div>

<!-- Custom JS -->
<script src='../../js/custom/savings-withdrawal.js?v=<?= $cashClear ?>'></script>
<!-- Custom JS -->