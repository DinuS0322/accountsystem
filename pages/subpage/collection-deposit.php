<?php
$currentDate = date('Y-m-d');
$accountId = $db->query("SELECT `accountId` FROM tbl_account_settings WHERE accountType = 'DEFAULT_ACCOUNT'")->fetchColumn(0);


?>
<div class="card shadow">
    <div class="card-header header-bg">
        <i class="fa fa-cog"></i> Collection Deposit Accounts
    </div>
    <div class="card-body">
        <div class="row mt-3">
            <div class="col-6 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Account <span class="text text-danger">*</span></label>
                    <select id="txtSelectCollectionAccount" class="form-control">
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
                                if ($id != $accountId) {
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

            <div class="col-6 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Field Officer <span class="text text-danger">*</span></label>
                    <select id="txtFieldOfficerId" class="form-control">
                        <option value="">---Select---</option>
                        <?php
                        try {
                            $sqlPMethod = "SELECT * FROM tbl_users where userType = 'fieldOfficer'";
                            $stmt = $db->prepare($sqlPMethod);
                            $stmt->execute();
                            while ($row = $stmt->fetchObject()) {
                                $id = $row->id;
                                $firstName = $row->firstName;
                                $lastName = $row->lastName;
                                echo "<option value='$id'>$firstName $lastName</option>";
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
                    <input type="text" class="form-control" id="txtCollectionDepositAmount" value="" readonly>
                </div>
            </div>

            <div class="col-6 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Pay Amount <span class="text text-danger">*</span></label>
                    <input type="text" class="form-control" id="txtCollectionPayAmount">
                </div>
            </div>
        </div>
        <div class="row-2 d-flex justify-content-end">
            <button class="btn btn-primary btn-sm" id="btnCollectionDepositAmount">
                Deposit
            </button>
        </div>
    </div>
</div>


<div class="card shadow">
    <div class="card-header header-bg">
        <i class="fa fa-briefcase" aria-hidden="true"></i> Collection Report
    </div>
    <div class="card-body">
        <br>
        <div class="table-responsive">
            <table class="table table-striped table-align-left" id="viewAllTransection">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Officer Name</th>
                        <th>Officer Type</th>
                        <th>Deposit Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    try {
                        $sqlPMethod = "SELECT * FROM tbl_collection";
                        $stmt = $db->prepare($sqlPMethod);
                        $stmt->execute();
                        $i = 1;
                        while ($row = $stmt->fetchObject()) {
                            $id = $row->id;
                            $officerId = $row->officerId;
                            $date = $row->date;
                            $amount = $row->amount;
                            $balanceAmount = $row->balanceAmount;
                            $balanceAmount = number_format($balanceAmount, 2);
                            $amount = number_format($amount, 2);

                            $firstName = $db->query("SELECT `firstName` FROM tbl_users WHERE id = '$officerId'")->fetchColumn(0);
                            $userType = $db->query("SELECT `userType` FROM tbl_users WHERE id = '$officerId'")->fetchColumn(0);

                            echo "<tr>";
                            echo "<td>$i</td>";
                            echo "<td>$date</td>";
                            echo "<td><a href='index.php?page=all-subpages&subpage=view-deposit&id=$officerId'>$firstName</a></td>";
                            echo "<td><span class='badge badge-primary'>$userType</span></td>";
                            echo "<td>$amount</td>";
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

<!-- Custom JS -->
<script src='../../js/custom/account-settings.js?v=<?= $cashClear ?>'></script>
<!-- Custom JS -->