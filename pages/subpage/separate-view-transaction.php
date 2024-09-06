<div class="card shadow">
    <div class="card-header header-bg">
        <i class="fa fa-users"></i> Transaction History
    </div>
    <div class="card-body">
        <div class="row  mt-3">

            <table class="table table-striped table-align-left" id="viewTransferHistory">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Account</th>
                        <th>Account Status</th>
                        <th>Amount</th>
                        <th>Balance</th>
                        <th>Reason</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $trId = $_GET['id'];
                    try {
                        $sqlPMethod = "SELECT * FROM tbl_transfer_history where account=$trId";
                        $stmt = $db->prepare($sqlPMethod);
                        $stmt->execute();
                        $i = 1;
                        while ($row = $stmt->fetchObject()) {
                            $id = $row->id;
                            $transferDate = $row->date;
                            $account = $row->account;
                            $accountStatus = $row->accountStatus;
                            $accountBalance = $row->accountBalance;
                            $accountBalance = number_format($accountBalance, 2);
                            $transferAmount = $row->transferAmount;
                            $transferAmount = number_format($transferAmount, 2);
                            $reason = $row->reason;
                            if ($accountStatus == 'Debit') {
                                $accountStatus = '<span class="badge badge-danger">Debit</span>';
                            } else if ($accountStatus == 'Credit') {
                                $accountStatus = '<span class="badge badge-success">Credit</span>';
                            }
                            $account = $db->query("SELECT `accountName` FROM tbl_account WHERE id = $account")->fetchColumn(0);                            echo "<tr>";
                            echo "<td>$i</td>";
                            echo "<td>$transferDate</td>";
                            echo "<td>$account</td>";
                            echo "<td>$accountStatus</td>";
                            echo "<td>$transferAmount</td>";
                            echo "<td>$accountBalance</td>";
                            echo "<td>$reason</td>";
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