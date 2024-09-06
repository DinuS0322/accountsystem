<?php
$currentDate = date('Y-m-d');

$sql = "SELECT MAX(id) AS max_value FROM tbl_client";
$stmt = $db->prepare($sql);
$stmt->execute();

$result = $stmt->fetch(PDO::FETCH_ASSOC);

$maxValue = $result['max_value'];
$incrementedValue = str_pad($maxValue + 1, 10, '0', STR_PAD_LEFT);

?>
<div class="card shadow">
    <div class="card-header header-bg">
        <i class="fa fa-user-plus"></i> Create Client
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Branch <span class="text-danger">*</span></label>
                    <select id="txtBranchId" class="form-control">
                        <option value="" readonly>---Select---</option>
                        <?php
                        try {
                            $sqlPMethod = 'SELECT * FROM tbl_branch where active = "Yes"';
                            $stmt = $db->prepare($sqlPMethod);
                            $stmt->execute();
                            $i = 1;
                            while ($row = $stmt->fetchObject()) {
                                $id = $row->id;
                                $branchName = $row->branchName;
                                echo "<option value='$id'>$branchName</option>";
                            }
                        } catch (PDOException $e) {
                            echo $e->getMessage();
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-12 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Nic Number<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="txtClientNicNumber">
                </div>
            </div>
            <div class="col-12 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Nic Issue Date<span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="txtclientNicIssueDate">
                </div>
            </div>
            <div class="col-12 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Title<span class="text-danger">*</span></label>
                    <select id="txtTitle" class="form-control">
                        <option value="Mr">Mr</option>
                        <option value="Mrs">Mrs</option>
                        <option value="Dr">Dr</option>
                        <option value="Miss">Miss</option>
                        <option value="Ms">Ms</option>
                    </select>
                </div>
            </div>
            <div class="col-12 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">First Name<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="txtFirstName">
                </div>
            </div>
            <div class="col-12 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Last Name<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="txtLastName">
                </div>
            </div>
            <div class="col-12 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Address<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="txtAddress">
                </div>
            </div>
            <div class="col-12 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Gender<span class="text-danger">*</span></label>
                    <select id="txtGender" class="form-control">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
            </div>
            <div class="col-12 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Marital Status<span class="text-danger">*</span></label>
                    <select id="txtMaritalStatus" class="form-control">
                        <option value="Single">Single</option>
                        <option value="Married">Married</option>
                        <option value="Divorced">Divorced</option>
                        <option value="Widowed">Widowed</option>
                    </select>
                </div>
            </div>
            <div class="col-12 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Phone Number<span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="txtPhoneNumber">
                </div>
            </div>
            <div class="col-12 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">New Account Number<span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="txtNewAccountNumber" value="<?= $incrementedValue ?>" readonly>
                </div>
            </div>
            <div class="col-12 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Old Account Number<span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="txtOldAccountNumber">
                </div>
            </div>
            <div class="col-12 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Profession<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="txtProfession">
                </div>
            </div>
            <div class="col-12 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Photo<span class="text-danger">*</span></label>
                    <input type="file" class="form-control" id="uploadClientPhoto">
                </div>
            </div>
            <div class="col-12 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Loan Officer<span class="text-danger">*</span></label>
                    <select id="txtLoanOfficerId" class="form-control">
                        <option value="" readonly>---Select---</option>
                        <?php
                        try {
                            $sqlPMethod = 'SELECT * FROM tbl_users where userType = "fieldOfficer"';
                            $stmt = $db->prepare($sqlPMethod);
                            $stmt->execute();
                            $i = 1;
                            while ($row = $stmt->fetchObject()) {
                                $id = $row->id;
                                $firstName = $row->firstName;
                                $lastName = $row->lastName;
                                $fullName = $firstName . ' ' . $lastName;
                                $branchName = $row->branchName;
                                echo "<option value='$id'>$fullName</option>";
                            }
                        } catch (PDOException $e) {
                            echo $e->getMessage();
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-12 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">E-signature<span class="text-danger">*</span></label>
                    <input type="file" class="form-control" id="eSignature">
                </div>
            </div>
            <div class="col-12 mt-3">
                    <h4 class="fw-bold mt-1">A Folower</h4>
            </div>
            <hr>
            <div class="col-sm-12 col-md-6 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Name<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="folowerName">
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">NIC Number<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="followerNicNumber">
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Issue Date<span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="followerNicIssueDate">
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Address<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="followerAddress">
                </div>
            </div>
            <hr class="mt-5">
            <div class="col-12 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Submitted On</label>
                    <input type="date" class="form-control" id="txtSubmittedOn" value="<?= $currentDate ?>" readonly>
                </div>
            </div>
            <div class="row-2 mt-3 d-flex justify-content-end">
                <button class="btn btn-primary" id="btnCreateClient">Create Client</button>
            </div>
        </div>
    </div>
</div>

<!-- Custom JS -->
<script src='../../js/custom/client-settings.js?v=<?= $cashClear ?>'></script>
<!-- Custom JS -->