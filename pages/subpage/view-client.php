<div class="card shadow">
    <div class="card-header header-bg">
        <i class="fa fa-users"></i> View Clients
    </div>
    <div class="card-body">
        <!-- filter option -->
        <p class="d-flex justify-content-end">
            <a class="btn btn-primary btn-sm mt-3 " data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                <i class="fa fa-filter" aria-hidden="true"></i> Filter
            </a>
        </p>
        <div class="collapse" id="collapseExample">
            <div class="row px-md-5  mt-md-2">
                <div class="col-md-6 mb-3">
                    <div class="row">
                        <div class="col-md-3 col-sm-12">
                            <label for="txtBranchSearch" class="col-form-label fw-bold">Branch:</label>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <select class="form-control" aria-label="Default select example" id="txtBranchSearch">
                                <option value="">---select---</option>
                                <?php
                                $sqlPMethod = 'SELECT * FROM tbl_branch';
                                $stmt = $db->prepare($sqlPMethod);
                                $stmt->execute();
                                $i = 1;
                                while ($row = $stmt->fetchObject()) {
                                    $branchName = $row->branchName;
                                    echo "<option value='$branchName'>$branchName</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="col-md-6 mb-3">
                    <div class="row">
                        <div class="col-md-3 col-sm-12">
                            <label for="txtBranchSearch" class="col-form-label fw-bold">Date:</label>
                        </div>
                        <div class="col-md-9 col-sm-12">
                            <input type="text" id="dateRangePicker" class="form-control">
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- filter option -->
        <div class="row  mt-3">

            <table class="table table-striped table-align-left table-responsive" id="viewClients">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Name</th>
                        <th>NicNumber</th>
                        <th>Phone Number</th>
                        <th>Gender</th>
                        <th>Branch</th>
                        <th>Loan Officer</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    try {
                        $sqlPMethod = 'SELECT * FROM tbl_client';
                        $stmt = $db->prepare($sqlPMethod);
                        $stmt->execute();
                        $i = 1;
                        while ($row = $stmt->fetchObject()) {
                            $id = $row->id;
                            $firstName = $row->firstName;
                            $lastName = $row->lastName;
                            $fullName = $firstName . ' ' . $lastName;
                            $nicNumber = $row->nicNumber;
                            $phoneNumber = $row->phoneNumber;
                            $gender = $row->gender;
                            $branchId = $row->branchId;
                            $date = $row->date;
                            $date = DateTime::createFromFormat('m-d-Y H:i:s', $date);
                            $formattedDate = $date->format('Y-m-d');
                            $loanOfficerId = $row->loanOfficerId;
                            $branchName = $db->query("SELECT `branchName` FROM tbl_branch WHERE id = $branchId")->fetchColumn(0);
                            $loanOfficerFirstName = $db->query("SELECT `firstName` FROM tbl_users WHERE id = $loanOfficerId")->fetchColumn(0);
                            $loanOfficerLastName = $db->query("SELECT `lastName` FROM tbl_users WHERE id = $loanOfficerId")->fetchColumn(0);
                            $loanOfficerName = $loanOfficerFirstName . " " . $loanOfficerLastName;

                            if($branchId == $SESS_USER_BRANCH && $SESS_USER_TYPE == 'fieldOfficer'){
                            echo "<tr>";
                            echo "<td>$i</td>";
                            echo "<td>$formattedDate</td>";
                            echo "<td><a href='index.php?page=all-subpages&subpage=view-client-details&id=$id'>$fullName</a></td>";
                            echo "<td>$nicNumber</td>";
                            echo "<td>$phoneNumber</td>";
                            echo "<td>$gender</td>";
                            echo "<td>$branchName</td>";
                            echo "<td>$loanOfficerName</td>";
                            echo "<td style='text-align: center;'>
                            <div class='btn-group'>
                            <button type='button' class='btn btn-primary dropdown-toggle' data-bs-toggle='dropdown' aria-expanded='false'>
                                Action
                            </button>
                            <ul class='dropdown-menu'>
                              <li><a class='dropdown-item ' href='index.php?page=all-subpages&subpage=view-client-details&id=$id'>Details</a></li>
                                <li><a class='dropdown-item ' href='index.php?page=all-subpages&subpage=update-client&id=$id'>Edit</a></li>
                                <li><a class='dropdown-item btnDeleteClient' href='#' client-id=$id>Delete</a></li>
                                <li><a class='dropdown-item ' href='index.php?page=all-subpages&subpage=update-client-profile&id=$id'>Change Profile</a></li>

                            </ul>
                            </div>  
                            </td>";
                            echo "</tr>";
                            $i++;
                            }else if($SESS_USER_TYPE != 'fieldOfficer'){
                                echo "<tr>";
                                echo "<td>$i</td>";
                                echo "<td>$formattedDate</td>";
                                echo "<td><a href='index.php?page=all-subpages&subpage=view-client-details&id=$id'>$fullName</a></td>";
                                echo "<td>$nicNumber</td>";
                                echo "<td>$phoneNumber</td>";
                                echo "<td>$gender</td>";
                                echo "<td>$branchName</td>";
                                echo "<td>$loanOfficerName</td>";
                                echo "<td style='text-align: center;'>
                                <div class='btn-group'>
                                <button type='button' class='btn btn-primary dropdown-toggle' data-bs-toggle='dropdown' aria-expanded='false'>
                                    Action
                                </button>
                                <ul class='dropdown-menu'>
                                  <li><a class='dropdown-item ' href='index.php?page=all-subpages&subpage=view-client-details&id=$id'>Details</a></li>
                                    <li><a class='dropdown-item ' href='index.php?page=all-subpages&subpage=update-client&id=$id'>Edit</a></li>
                                    <li><a class='dropdown-item btnDeleteClient' href='#' client-id=$id>Delete</a></li>
                                    <li><a class='dropdown-item ' href='index.php?page=all-subpages&subpage=update-client-profile&id=$id'>Change Profile</a></li>
                                    <li><a class='dropdown-item ' href='index.php?page=all-subpages&subpage=update-client-signature&id=$id'>Change Signature</a></li>
                                </ul>
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

<!-- Custom JS -->
<script src='../../js/custom/client-settings.js?v=<?= $cashClear ?>'></script>
<!-- Custom JS -->