<div class="card shadow">
    <div class="card-header header-bg">
        <i class="fa fa-users"></i> Balance Transfer
    </div>
    <div class="card-body">
        <div class="row-2 mt-3 d-flex justify-content-end">
            <a href="index.php?page=all-subpages&subpage=account-balance-transfer"> <button class="btn btn-primary btn-sm">
                Create Transfer
            </button></a>
        </div>
        <div class="row  mt-3">

            <table class="table table-striped table-align-left" id="viewBalanceTransfer">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>From Account</th>
                        <th>To Account</th>
                        <th>Amount</th>
                        <th>Reason</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    try {
                        $sqlPMethod = 'SELECT * FROM tbl_account_transfer';
                        $stmt = $db->prepare($sqlPMethod);
                        $stmt->execute();
                        $i = 1;
                        while ($row = $stmt->fetchObject()) {
                            $id = $row->id;
                            $transferDate = $row->transferDate;
                            $fromAccount = $row->fromAccount;
                            $toAccount = $row->toAccount;
                            $requestApproval = $row->requestApproval;
                            $transferAmount = $row->transferAmount;
                            $transferAmount = number_format($transferAmount, 2);
                            $reason = $row->reason;
                            if ($requestApproval == 0) {
                                $requestStatus = '<span class="badge badge-warning">Pending</span>';
                            } else if ($requestApproval == 1) {
                                $requestStatus = '<span class="badge badge-primary">First Approved</span>';
                            } else if ($requestApproval == 2) {
                                $requestStatus = '<span class="badge badge-success">Transferred</span>';
                            }
                            $fromAccountName = $db->query("SELECT `accountName` FROM tbl_account WHERE id = $fromAccount")->fetchColumn(0);
                            $toAccountName = $db->query("SELECT `accountName` FROM tbl_account WHERE id = $toAccount")->fetchColumn(0);
                            echo "<tr>";
                            echo "<td>$i</td>";
                            echo "<td>$transferDate</td>";
                            echo "<td>$fromAccountName</td>";
                            echo "<td>$toAccountName</td>";
                            echo "<td>$transferAmount</td>";
                            echo "<td>$reason</td>";
                            echo "<td>$requestStatus</td>";
                            echo "<td style='text-align: center;'>
                            <div class='btn-group'>
                            <button type='button' class='btn btn-primary  dropdown-toggle' data-bs-toggle='dropdown' aria-expanded='false'>
                                Action
                            </button>
                            <ul class='dropdown-menu'>
                                <li><a class='dropdown-item ' href='#'>Edit</a></li>
                                <li><a class='dropdown-item btnDeleteBranch' href='#'>Delete</a></li>
                            </ul>
                            </div>  
                            </td>";
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