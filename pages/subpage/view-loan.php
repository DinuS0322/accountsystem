<div class="card shadow">
    <div class="card-header header-bg">
        <i class="fas fa-money-check-alt"></i> View Loans
    </div>
    <div class="card-body">
        <p class="d-flex justify-content-end">
            <a class="btn btn-primary btn-sm mt-3 " data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                <i class="fa fa-filter" aria-hidden="true"></i> Filter
            </a>
        </p>
        <div class="collapse" id="collapseExample">
            <div class="row mt-3">
                <div class="col d-flex justify-content-center">
                    <h5 class="fw-bold text-uppercase">Filter</h5>
                </div>
            </div>

            <div class="row">
                <div class="col-3">
                    <div class="form-group">
                        <label for="dateFrom">Status</label>
                        <select id="txtFilterStatus" class="form-control selectize">
                            <option value="">---select----</option>
                            <option value="approved">Approved</option>
                            <option value="firstAproved">First Aproved</option>
                            <option value="secondApproved">Second Approved</option>
                            <option value="Requested">Requested</option>
                            <option value="pending">Pending</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label for="dateFrom">Loan Status</label>
                        <select id="txtFilterLoanStatus" class="form-control selectize">
                            <option value="">---select----</option>
                            <option value="Loan Completed">Loan Completed</option>
                            <option value="Canceled">Canceled</option>
                            <option value="Not Completed">Not Completed</option>
                        </select>
                    </div>
                </div>

                <div class="col-6">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="" class="pt-1">From </label>
                                <input type="date" id="fromdate" class="form-control">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="" class="pt-1">To </label>
                                <input type="date" id="todate" class="form-control ">
                            </div>

                        </div>
                    </div>

                </div>

                <div class="col-6">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="" class="pt-1">Min Amount </label>
                                <input type="number" id="fromAmount" class="form-control">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="" class="pt-1">Max Amount</label>
                                <input type="number" id="toAmount" class="form-control ">
                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </div>
        <div class="row  mt-3">
            <table class="table table-striped table-align-left" id="viewAllLoans">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Client Name</th>
                        <th>Date</th>
                        <th>Principal Amount</th>
                        <th>Loan Officer</th>
                        <th>Loan Purpose</th>
                        <th>Loan Status</th>
                        <th>Status</th>
                        <th></th>
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

                            $dateTime = DateTime::createFromFormat('d-m-Y H:i:s', $date);
                            $dateWithoutTime = $dateTime->format('Y-m-d');

                            if ($aprovalStatus == 'pending') {
                                $aprovalStatusView = "<span class='badge badge-warning'>$aprovalStatus</span>";
                            } else if ($aprovalStatus == 'approved') {
                                $aprovalStatusView = "<span class='badge badge-success'>$aprovalStatus</span>";
                            } else if ($aprovalStatus == 'cancelled') {
                                $aprovalStatusView = "<span class='badge badge-danger'>$aprovalStatus</span>";
                            } else if ($aprovalStatus == 'Requested') {
                                $aprovalStatusView = "<span class='badge badge-info'>$aprovalStatus</span>";
                            } else if ($aprovalStatus == 'firstAproved') {
                                $aprovalStatusView = "<span class='badge badge-info'>First Approved</span>";
                            } else if ($aprovalStatus == 'secondApproved') {
                                $aprovalStatusView = "<span class='badge badge-info'>Second Approved</span>";
                            }

                            if ($a == 0) {
                                if ($aprovalStatus == 'approved') {
                                    $loanStatus = "<span class='badge badge-success'>Loan Completed</span>";
                                } else if ($aprovalStatus == 'cancelled') {
                                    $loanStatus = "<span class='badge badge-danger'>Cancelled</span>";
                                } else {
                                    $loanStatus = "<span class='badge badge-warning'>Not Completed</span>";
                                }
                            } else {
                                $loanStatus = "<span class='badge badge-warning'>Not Completed</span>";
                            }
                            $clientFirstName = $db->query("SELECT `firstName` FROM tbl_client WHERE id = $clientId")->fetchColumn(0);
                            $lonOfficerName = $db->query("SELECT `firstName` FROM tbl_users WHERE id = $loanOfficerId")->fetchColumn(0);
                            $branchId = $db->query("SELECT `branchId` FROM tbl_client WHERE id = $clientId")->fetchColumn(0);
                            if ($branchId == $SESS_USER_BRANCH && $SESS_USER_TYPE == 'fieldOfficer') {
                                echo "<tr>";
                                echo "<td>$i</td>";
                                echo "<td>$clientFirstName</td>";
                                echo "<td>$dateWithoutTime</td>";
                                echo "<td>$principal</td>";
                                echo "<td>$lonOfficerName</td>";
                                echo "<td>$loanPurpose</td>";
                                echo "<td>$loanStatus</td>";
                                echo "<td>$aprovalStatusView</td>";
                                echo "<td style='text-align: center;'>
                            <div class='btn-group'>
                            <button type='button' class='btn btn-primary btn-sm dropdown-toggle' data-bs-toggle='dropdown' aria-expanded='false'>
                                Action
                            </button>
                            <ul class='dropdown-menu'>";
                                if ($SESS_USER_TYPE != 'fieldOfficer' && $aprovalStatus != 'approved' && $aprovalStatus != 'cancelled') {
                                    // echo " <li><a class='dropdown-item btnChangeApprovalModal' href='#' id='$id'  data-bs-toggle='modal' data-bs-target='#changeApprovalStatus'>Approval Status</a></li>";
                                } else if ($SESS_USER_TYPE == 'fieldOfficer' && $aprovalStatus != 'approved' && $aprovalStatus != 'cancelled' && $requestLoan == 0) {
                                    echo " <li><a class='dropdown-item requestForLoan' href='#' data-id='$id'>Request Loan</a></li>";
                                }
                                if ($SESS_USER_TYPE != 'fieldOfficer') {
                                    echo "  <li><a class='dropdown-item ' href='index.php?page=all-subpages&subpage=view-separate-loan&id=$id'>View</a></li>
                               
                                <li><a class='dropdown-item btnDeleteLoan' href='#' data-id='$id'>Delete</a></li>";
                                } else {
                                    echo "  <li><a class='dropdown-item ' href='index.php?page=all-subpages&subpage=view-separate-loan&id=$id'>View</a></li>
                                <li><a class='dropdown-item ' href='#' id='$id'>Edit</a></li>";
                                }

                                echo "</ul>
                            </div>  
                            </td>";
                                echo "</tr>";
                                $i++;
                            } else if ($SESS_USER_TYPE != 'fieldOfficer') {
                                echo "<tr>";
                                echo "<td>$i</td>";
                                echo "<td>$clientFirstName</td>";
                                echo "<td>$dateWithoutTime</td>";
                                echo "<td>$principal</td>";
                                echo "<td>$lonOfficerName</td>";
                                echo "<td>$loanPurpose</td>";
                                echo "<td>$loanStatus</td>";
                                echo "<td>$aprovalStatusView</td>";
                                echo "<td style='text-align: center;'>
                            <div class='btn-group'>
                            <button type='button' class='btn btn-primary btn-sm dropdown-toggle' data-bs-toggle='dropdown' aria-expanded='false'>
                                Action
                            </button>
                            <ul class='dropdown-menu'>";
                                if ($SESS_USER_TYPE != 'fieldOfficer' && $aprovalStatus != 'approved' && $aprovalStatus != 'cancelled') {
                                    // echo " <li><a class='dropdown-item btnChangeApprovalModal' href='#' id='$id'  data-bs-toggle='modal' data-bs-target='#changeApprovalStatus'>Approval Status</a></li>";
                                } else if ($SESS_USER_TYPE == 'fieldOfficer' && $aprovalStatus != 'approved' && $aprovalStatus != 'cancelled' && $requestLoan == 0) {
                                    echo " <li><a class='dropdown-item requestForLoan' href='#' data-id='$id'>Request Loan</a></li>";
                                }
                                if ($SESS_USER_TYPE != 'fieldOfficer') {
                                    echo "  <li><a class='dropdown-item ' href='index.php?page=all-subpages&subpage=view-separate-loan&id=$id'>View</a></li>
                                
                                <li><a class='dropdown-item btnDeleteLoan' href='#' data-id='$id'>Delete</a></li>";
                                } else {
                                    echo "  <li><a class='dropdown-item ' href='index.php?page=all-subpages&subpage=view-separate-loan&id=$id'>View</a></li>
                                <li><a class='dropdown-item ' href='#' id='$id'>Edit</a></li>";
                                }

                                echo "</ul>
                            </div>  
                            </td>";
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
                            <option value="firstAproved">First Approved</option>
                            <option value="secondApproved">Secound Approved</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        Reason
                    </div>
                    <div class="col">
                        <textarea name="" id="txtApprovedReason" class="form-control"></textarea>
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


<!-- Add change approval Modal third -->
<div class="modal fade" id="changeApprovalStatusThird" tabindex="-1" aria-labelledby="changeApprovalStatusThirdLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changeApprovalStatusThirdLabel"><i class="fa fa-user-plus" aria-hidden="true"></i>
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
                            <option value="approved">Third Approved</option>

                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        Cheque No
                    </div>
                    <div class="col">
                        <input type="text" id="txtCheqeNo" class="form-control">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        Select Account
                    </div>
                    <div class="col">
                        <select id="txtSelectAccount" class="form-control">
                            <?php
                            $sqlPMethod = "SELECT * FROM tbl_account ";
                            $stmt = $db->prepare($sqlPMethod);
                            $stmt->execute();
                            while ($row = $stmt->fetchObject()) {
                                $id = $row->id;
                                $accountName = $row->accountName;
                                $balance = $row->balance;
                                $balance = number_format($balance, 2);

                                echo "<option value='$id'>$accountName ($balance)</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        Description
                    </div>
                    <div class="col">
                        <textarea id="txtApprovedDes" class="form-control"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="modalClose">Close</button>
                <button type="button" class="btn btn-primary" id="btnChangeApprovalStatusThird">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Custom JS -->
<script src='../../js/custom/loan-settings.js?v=<?= $cashClear ?>'></script>
<script src='../../js/custom/loan-filter.js?v=<?= $cashClear ?>'></script>
<!-- Custom JS -->