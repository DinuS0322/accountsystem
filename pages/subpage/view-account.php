<div class="card shadow">
    <div class="card-header header-bg">
        <i class="fa fa-cog"></i> View Accounts Data
    </div>
    <div class="card-body">
        <div class="row mt-3">
            <table class="table table-striped table-align-left" id="viewAccountTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Account Name</th>
                        <th>Branch Name</th>
                        <th>Account Number</th>
                        <th>Balance</th>
                        <th>Account Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    try {
                        $sqlPMethod = 'SELECT * FROM tbl_account';
                        $stmt = $db->prepare($sqlPMethod);
                        $stmt->execute();
                        $i = 1;
                        while ($row = $stmt->fetchObject()) {
                            $id = $row->id;
                            $accountName = $row->accountName;
                            $branchName = $row->branchName;
                            $accountNumber = $row->accountNumber;
                            $accountStatus = $row->accountStatus;
                            $balance = $row->balance;
                            $balance = number_format($balance, 2);
                            if ($accountStatus == 'active') {
                                $accountStatus = '<span class="badge badge-info">Active</span>';
                            } else {
                                $accountStatus = '<span class="badge badge-danger">Inactive</span>';
                            }
                            echo "<tr>";
                            echo "<td>$i</td>";
                            echo "<td><a href='index.php?page=all-subpages&subpage=separate-view-transaction&id=$id'>$accountName</a></td>";
                            echo "<td>$branchName</td>";
                            echo "<td>$accountNumber</td>";
                            echo "<td>Rs. $balance</td>";
                            echo "<td>$accountStatus</td>";
                            echo "</tr>";
                            $i++;
                        }
                    } catch (PDOException $e) {
                        echo $e->getMessage();
                    }
                    ?>
                </tbody>
                <a href="">
                    <div>

                    </div>
                </a>
            </table>
        </div>
    </div>
</div>

<!-- Custom JS -->
<script src='../../js/custom/account-settings.js?v=<?= $cashClear ?>'></script>
<!-- Custom JS -->