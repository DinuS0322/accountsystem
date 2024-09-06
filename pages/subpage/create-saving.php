<div class="card shadow">
    <div class="card-header header-bg">
        <i class="fa fa-users"></i> Create Savings
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
                        $sqlPMethod = 'SELECT * FROM tbl_savings_product';
                        $stmt = $db->prepare($sqlPMethod);
                        $stmt->execute();
                        $i = 1;
                        while ($row = $stmt->fetchObject()) {
                            $id = $row->id;
                            $name = $row->name;
                            $interest = $row->interest;
                            $category = $row->category;
                            echo "<option value='$id'>$name - $category - $interest %</option>";
                        }
                    } catch (PDOException $e) {
                        echo $e->getMessage();
                    }
                    ?>
                </select>
            </div>
        </div>
        <input type="text" class="form-control hidden" id="txtGetCategory">
        <div id="childrendetailsDiv" class="hidden">
            <div class="row mt-3">
                <div class="col fw-bold">
                    Children Name
                </div>
                <div class="col">
                    <input type="text" class="form-control" id="txtChildrenName">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col fw-bold">
                    Date Of Date
                </div>
                <div class="col">
                    <input type="date" class="form-control" id="txtChildrenDateOfBirth" value="<?= date('Y-m-d') ?>">
                </div>
            </div>
        </div>

        <div id="personaldetailsDiv" class="hidden">
            <div class="row mt-3">
                <div class="col fw-bold">
                    Name
                </div>
                <div class="col">
                    <input type="text" class="form-control" id="txtPersonalName">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col fw-bold">
                    Start Date
                </div>
                <div class="col">
                    <input type="date" class="form-control" id="txtStartDate" value="<?= date('Y-m-d') ?>">
                </div>
            </div>
        </div>
        <div class="row mt-3 hidden" id="savingsProductDiv">
        </div>
        <div class="row mt-3">
            <div class="col fw-bold">
                Saving Amount
            </div>
            <div class="col">
                <input type="number" class="form-control" id="txtSavingAmount">
            </div>
        </div>
        <div class="row-2 mt-3 d-flex justify-content-end">
            <button class="btn btn-primary" id="btnCreateSaving">Create</button>
        </div>
    </div>
</div>

<!-- Custom JS -->
<script src='../../js/custom/savings-settings.js?v=<?= $cashClear ?>'></script>
<!-- Custom JS -->