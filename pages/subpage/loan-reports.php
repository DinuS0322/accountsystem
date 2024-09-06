<div class="card shadow">
    <div class="card-header header-bg">
        <i class="fa fa-tasks"></i> View Loan Reports 
    </div>
    <div class="card-body">
        <div class="row  mt-3">
        <table class="table table-striped table-align-left" id="viewAllLoansReports">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Client Name</th>
                        <th>Date</th>
                        <th>Principal Amount</th>
                        <th>Loan Officer</th>
                        <th>Loan Purpose</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    try {
                        $sqlPMethod = 'SELECT * FROM tbl_loan where deleted = 0 ORDER BY date ASC';
                        $stmt = $db->prepare($sqlPMethod);
                        $stmt->execute();
                        $i = 1;
                        while ($row = $stmt->fetchObject()) {
                            $id = $row->id;
                            $clientId = $row->clientId;
                            $date = $row->date;
                            $principal = $row->principal;
                            $loanOfficerId = $row->loanOfficerId;
                            $loanPurpose = $row->loanPurpose;
                            $aprovalStatus = $row->aprovalStatus;
                            $requestLoan = $row->requestLoan;

                            $sqlPMethodCheck = "SELECT * FROM tbl_loan_reschedule where LoanId =$id AND status = 'unpaid'";
                            $stmtCheck = $db->prepare($sqlPMethodCheck);
                            $stmtCheck->execute();
                            $a = 0;
                            while ($rows = $stmtCheck->fetchObject()) {
                                $a++;
                            }

                            if ($aprovalStatus == 'pending') {
                                $aprovalStatusView = "<span class='badge badge-warning'>$aprovalStatus</span>";
                            } else if ($aprovalStatus == 'approved') {
                                $aprovalStatusView = "<span class='badge badge-success'>$aprovalStatus</span>";
                            } else if ($aprovalStatus == 'cancelled') {
                                $aprovalStatusView = "<span class='badge badge-danger'>$aprovalStatus</span>";
                            }else if ($aprovalStatus == 'Requested') {
                                $aprovalStatusView = "<span class='badge badge-info'>$aprovalStatus</span>";
                            }else if ($aprovalStatus == 'firstAproved') {
                                $aprovalStatusView = "<span class='badge badge-info'>First Approved</span>";
                            }

                            if ($a == 0) {
                                if($aprovalStatus == 'pending' || $aprovalStatus == 'approved' || $aprovalStatus == 'Requested' || $aprovalStatus == 'firstAproved'){
                                    $loanStatus = "<span class='badge badge-warning'>Not Completed</span>";
                                }else{
                                    $loanStatus = "<span class='badge badge-danger'>Canceled</span>";
                                }

                            } else {
                                $loanStatus = "<span class='badge badge-warning'>Not Completed</span>";
                            }
                            $clientFirstName = $db->query("SELECT `firstName` FROM tbl_client WHERE id = $clientId")->fetchColumn(0);
                            $lonOfficerName = $db->query("SELECT `firstName` FROM tbl_users WHERE id = $loanOfficerId")->fetchColumn(0);
                            echo "<tr>";
                            echo "<td>$i</td>";
                            echo "<td>$clientFirstName</td>";
                            echo "<td>$date</td>";
                            echo "<td>$principal</td>";
                            echo "<td>$lonOfficerName</td>";
                            echo "<td>$loanPurpose</td>";
                        
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

<?php

?>

<!-- Custom JS -->
<script src='../../js/custom/reports.js?v=<?= $cashClear ?>'></script>
<!-- Custom JS -->