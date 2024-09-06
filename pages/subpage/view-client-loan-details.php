<div class="card shadow">
    <div class="card-header header-bg">
        <i class="fa fa-cog"></i> View Loan Details
    </div>
    <div class="card-body">
        <div class="row mt-3">
            <div class="table-responsive">
                <table class="table table-striped table-align-left" id="viewAllClientLoans">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Loan Id</th>
                            <th>Client Name</th>
                            <th>Date</th>
                            <th>Principal Amount</th>
                            <th>Loan Officer</th>
                            <th>Loan Purpose</th>
                            <!-- <th>Loan Status</th>
                <th>Status</th> -->

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $clientId = $db->query("SELECT `clientId` FROM tbl_client_users WHERE id = $SESS_USER_ID")->fetchColumn(0);
                        try {
                            $sqlPMethod = "SELECT * FROM tbl_loan where clientId = $clientId";
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
                                }

                                if ($a == 0) {
                                    $loanStatus = "<span class='badge badge-success'>Completed</span>";
                                } else {
                                    $loanStatus = "<span class='badge badge-warning'>Not Completed</span>";
                                }
                                $clientFirstName = $db->query("SELECT `firstName` FROM tbl_client WHERE id = $clientId")->fetchColumn(0);
                                $lonOfficerName = $db->query("SELECT `firstName` FROM tbl_users WHERE id = $loanOfficerId")->fetchColumn(0);
                                echo "<tr>";
                                echo "<td>$i</td>";
                                echo "<td>$id</td>";
                                echo "<td>$clientFirstName</td>";
                                echo "<td>$date</td>";
                                echo "<td>$principal</td>";
                                echo "<td>$lonOfficerName</td>";
                                echo "<td>$loanPurpose</td>";
                                // echo "<td>$loanStatus</td>";
                                // echo "<td>$aprovalStatusView</td>";

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
        <!-- Add change approval Modal -->
        <div class="modal fade" id="changeApprovalStatus" tabindex="-1" aria-labelledby="changeApprovalStatusLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="changeApprovalStatusLabel"><i class="fa fa-user-plus" aria-hidden="true"></i>
                            Change Approval Status </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" class="form-control hidden" id="loanIdView">
                        <div class="row mt-3">
                            <div class="col">
                                Status
                            </div>
                            <div class="col">
                                <select id="txtApprovalStatus" class="form-control">
                                    <option value="approved">Approved</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="modalClose">Close</button>
                        <button type="button" class="btn btn-primary" id="btnChangeApprovalStatus">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Custom JS -->
<script src='../../js/custom/loan-settings.js?v=<?= $cashClear ?>'></script>
<!-- Custom JS -->