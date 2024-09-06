<div class="card shadow">
    <div class="card-header header-bg">
        <i class="fas fa-money-check-alt"></i> All Repayment
    </div>
    <div class="card-body">
        <div class="row-2 d-flex justify-content-end mt-3">
            <a href="index.php?page=all-subpages&subpage=add-all-payment">
                <div class="col">
                    <button class="btn btn-primary">Add Payment</button>
                </div>
            </a>

        </div>
        <div class="row mt-3">
            <table class="table table-striped table-align-left" id="viewrepaymentTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Loan Id</th>
                        <th>Payment Date</th>
                        <th>Principal Amount</th>
                        <th>Interest</th>
                        <th>Total Amount</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    try {
                        $sqlPMethod = "SELECT * FROM tbl_loan_repayment where repaymentOfficer=$SESS_USER_ID ORDER BY paymentDate DESC";
                        $stmt = $db->prepare($sqlPMethod);
                        $stmt->execute();
                        $i = 1;
                        while ($row = $stmt->fetchObject()) {
                            $loanId = $row->loanId;
                            $id = $row->id;
                            $paymentDate = $row->paymentDate;
                            $monthlyPrincipalAmount = $row->monthlyPrincipalAmount;
                            $monthlyInterest = $row->monthlyInterest;
                            $monthlyTotalPayment = $row->monthlyTotalPayment;
                            $repaymentOfficer = $row->repaymentOfficer;
                            $clientId = $db->query("SELECT `clientId` FROM tbl_loan WHERE id = $loanId")->fetchColumn(0);
                            $loanRandomId = $db->query("SELECT `loanRandomId` FROM tbl_loan WHERE id = $loanId")->fetchColumn(0);
                            if($loanRandomId == ''){
                                $loanIdView = $loanId;
                            }else{
                                $loanIdView = $loanRandomId;
                            }
                            $branchId = $db->query("SELECT `branchId` FROM tbl_client WHERE id = $clientId")->fetchColumn(0);
                            if ($branchId == $SESS_USER_BRANCH && $SESS_USER_TYPE == 'fieldOfficer') {
                            echo "<tr>";
                            echo "<td>$i</td>";
                            echo "<td>$loanIdView</td>";
                            echo "<td>$paymentDate</td>";
                            echo "<td>$monthlyPrincipalAmount</td>";
                            echo "<td>$monthlyInterest</td>";
                            echo "<td>$monthlyTotalPayment</td>";
                            echo "<td>
                            <a href='index.php?page=all-subpages&subpage=view-repayment-report&id=$id' >
                            <button class='btn btn-success btn-sm'>View Report</button>
                            </a></td>";
                            echo "</tr>";
                            $i++;
                            }else if($SESS_USER_TYPE != 'fieldOfficer'){
                                echo "<tr>";
                                echo "<td>$i</td>";
                                echo "<td>$loanIdView</td>";
                                echo "<td>$paymentDate</td>";
                                echo "<td>$monthlyPrincipalAmount</td>";
                                echo "<td>$monthlyInterest</td>";
                                echo "<td>$monthlyTotalPayment</td>";
                                echo "<td>
                                <a href='index.php?page=all-subpages&subpage=view-repayment-report&id=$id' >
                                <button class='btn btn-success btn-sm'>View Report</button>
                                </a></td>";
                                echo "</tr>";
                                $i++;
                            }
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
<script src='../../js/custom/repayment-settings.js?v=<?= $cashClear ?>'></script>
<!-- Custom JS -->