<div class="card shadow">
    <div class="card-header header-bg">
        <i class="bi bi-bank"></i> Savings Withdrawal
    </div>
    <div class="card-body">
        <div class="row mt-3">
            <div class="col d-flex justify-content-end">
                <a href="index.php?page=all-subpages&subpage=create-withdrawal">
                    <button class="btn btn-primary">
                        <i class="bi bi-plus-square-fill"></i> Create Withdrawal
                    </button>
                </a>
            </div>
        </div>
        <div class="row  mt-3">
            <table class="table table-striped table-align-left" id="viewSavingsWithdrawal">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Id</th>
                        <th>Member</th>
                        <th>Saving Account</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    try {
                        $sqlPMethod = "SELECT * FROM tbl_savings_withdrawal ";
                        $stmt = $db->prepare($sqlPMethod);
                        $stmt->execute();
                        $i = 1;
                        while ($row = $stmt->fetchObject()) {
                            $date = $row->date;
                            $withdrawalId = $row->withdrawalId;
                            $clientId = $row->clientId;
                            $savingId = $row->savingId;
                            $amount = $row->amount;
                            $status = $row->status;
                            $amount = number_format($amount, 2);
                            $firstName = $db->query("SELECT `firstName` FROM tbl_client WHERE id = $clientId")->fetchColumn(0);
                            $personalName = $db->query("SELECT `personalName` FROM tbl_savings WHERE savingId = $savingId")->fetchColumn(0);
                            $childrenName = $db->query("SELECT `childrenName` FROM tbl_savings WHERE savingId = $savingId")->fetchColumn(0);
                            if($personalName == ''){
                                $savingAccount = $childrenName;
                            }else{
                                $savingAccount = $personalName;
                            }

                            if($status == 0){
                                $status = '<span class="badge bg-warning">Pending</span>';
                            }else if($status == 1){
                                $status = '<span class="badge bg-primary">Requested</span>';
                            }else if($status == 2){
                                $status = '<span class="badge bg-primary">First Approved</span>';
                            }else if($status == 3){
                                $status = '<span class="badge bg-primary">Second Approved</span>';
                            }else if($status == 4){
                                $status = '<span class="badge bg-success">Completed</span>';
                            }else if($status == 5){
                                $status = '<span class="badge bg-danger">Cancelled</span>';
                            }
                            echo "<tr>";
                            echo "<td>$i</td>";
                            echo "<td >$date</td>";
                            echo "<td><a href='index.php?page=all-subpages&subpage=view-saving-withdrawal&id=$withdrawalId'>$withdrawalId</a></td>";
                            echo "<td>$firstName</td>";
                            echo "<td>$savingAccount</td>";
                            echo "<td>$amount</td>";
                            echo "<td>$status</td>";
                            echo "<td style='text-align: center;'>
                            <div class='btn-group'>
                            <button type='button' class='btn btn-primary btn-sm dropdown-toggle' data-bs-toggle='dropdown' aria-expanded='false'>
                                Action
                            </button>
                            <ul class='dropdown-menu'>";
                            if( $SESS_USER_TYPE == 'fieldOfficer'){
                                echo "<li><a class='dropdown-item btnRequestWithdrawal' href='#' data-id='$withdrawalId'>Request Withdrawal</a></li>";
                            }
                              echo   "<li><a class='dropdown-item btnDeleteBranch' href='#'>Delete</a></li>
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
<script src='../../js/custom/savings-withdrawal.js?v=<?= $cashClear ?>'></script>
<!-- Custom JS -->