<?php
$clientId = $_GET['id'];
$getData = "SELECT * FROM tbl_client where id=$clientId";
$getDatastmt = $db->prepare($getData);
$getDatastmt->execute();
if ($row = $getDatastmt->fetchObject()) {
    $branchId = $row->branchId;
    $title = $row->title;
    $firstName = $row->firstName;
    $lastName = $row->lastName;
    $cientAddress = $row->cientAddress;
    $gender = $row->gender;
    $maritalStatus = $row->maritalStatus;
    $phoneNumber = $row->phoneNumber;
    $oldAccountNumber = $row->oldAccountNumber;
    $loanOfficerId = $row->loanOfficerId;
    $folowerName = $row->folowerName;
    $followerAddress = $row->followerAddress;
    $profession = $row->profession; 
}
?>


<div class="card shadow">
    <div class="card-header header-bg">
        <i class="fa fa-user-plus"></i> Update Client
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Branch</label>
                    <select id="txtUpdateBranchId" class="form-control">
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
                                if ($id == $branchId) {
                                    echo "<option value='$id' selected>$branchName</option>";
                                } else {
                                    echo "<option value='$id' >$branchName</option>";
                                }
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
                    <label class="fw-bold mt-1">Title</label>
                    <select id="txtUpdateTitle" class="form-control">
                        <option value="Mr" <?= $title == "Mr" ? "selected" : ""; ?>>Mr</option>
                        <option value="Mrs" <?= $title == "Mrs" ? "selected" : ""; ?>>Mrs</option>
                        <option value="Dr" <?= $title == "Dr" ? "selected" : ""; ?>>Dr</option>
                        <option value="Miss" <?= $title == "Miss" ? "selected" : ""; ?>>Miss</option>
                        <option value="Ms" <?= $title == "Ms" ? "selected" : ""; ?>>Ms</option>
                    </select>
                </div>
            </div>
            <div class="col-12 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">First Name</label>
                    <input type="text" class="form-control" id="txtUpdateFirstName" value="<?= $firstName ?>">
                </div>
            </div>
            <div class="col-12 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Last Name</label>
                    <input type="text" class="form-control" id="txtUpdateLastName" value="<?= $lastName ?>">
                </div>
            </div>
            <div class="col-12 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Address</label>
                    <input type="text" class="form-control" id="txtUpdateAddress" value="<?= $cientAddress ?>">
                </div>
            </div>
            <div class="col-12 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Gender</label>
                    <select id="txtUpdateGender" class="form-control">
                        <option value="Male" <?= $gender == "Male" ? "selected" : ""; ?>>Male</option>
                        <option value="Female" <?= $gender == "Female" ? "selected" : ""; ?>>Female</option>
                    </select>
                </div>
            </div>
            <div class="col-12 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Marital Status</label>
                    <select id="txtUpdateMaritalStatus" class="form-control">
                        <option value="Single" <?= $maritalStatus == "Single" ? "selected" : ""; ?>>Single</option>
                        <option value="Married" <?= $maritalStatus == "Married" ? "selected" : ""; ?>>Married</option>
                        <option value="Divorced" <?= $maritalStatus == "Divorced" ? "selected" : ""; ?>>Divorced</option>
                        <option value="Widowed" <?= $maritalStatus == "Widowed" ? "selected" : ""; ?>>Widowed</option>
                    </select>
                </div>
            </div>
            <div class="col-12 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Phone Number</label>
                    <input type="number" class="form-control" id="txtUpdatePhoneNumber" value="<?= $phoneNumber  ?>">
                </div>
            </div>
            <div class="col-12 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Old Account Number</label>
                    <input type="number" class="form-control" id="txtUpdateOldAccountNumber" value="<?= $oldAccountNumber ?>">
                </div>
            </div>
            <div class="col-12 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Profession</label>
                    <input type="text" class="form-control" id="txtUpdateProfession" value="<?= $profession ?>">
                </div>
            </div>
            <div class="col-12 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Loan Officer</label>
                    <select id="txtUpdateLoanOfficerId" class="form-control">
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
                                if ($id == $loanOfficerId) {
                                    echo "<option value='$id' selected>$fullName</option>";
                                } else {
                                    echo "<option value='$id'>$fullName</option>";
                                }
                            }
                        } catch (PDOException $e) {
                            echo $e->getMessage();
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-12 mt-3">
                <h4 class="fw-bold mt-1">A Folower</h4>
            </div>
            <hr>
            <div class="col-sm-12 col-md-6 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Name</label>
                    <input type="text" class="form-control" id="folowerUpdateName" value="<?= $folowerName ?>">
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Address</label>
                    <input type="text" class="form-control" id="followerUpdateAddress" value="<?= $followerAddress ?>">
                </div>
            </div>
            <hr class="mt-5">
            <div class="row-2 mt-3 d-flex justify-content-end">
                <button class="btn btn-primary" id="btnUpdateClient" client-id = "<?= $clientId ?>">Update Client</button>
            </div>
        </div>
    </div>
</div>

<!-- Custom JS -->
<script src='../../js/custom/client-settings.js?v=<?= $cashClear ?>'></script>
<!-- Custom JS -->