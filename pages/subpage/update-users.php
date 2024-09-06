<?php
$userId = $_GET['id'];

$sqlPMethod = "SELECT * FROM tbl_users where id = $userId";
$stmt = $db->prepare($sqlPMethod);
$stmt->execute();
if ($row = $stmt->fetchObject()) {
    $firstName = $row->firstName;
    $registerDate = $row->registerDate;
    $lastName = $row->lastName;
    $email = $row->email;
    $phoneNumber = $row->phoneNumber;
    $nicNumber = $row->nicNumber;
    $address = $row->address;
    $gender = $row->gender;
    $userType = $row->userType;
}
?>

<div class="card shadow">
    <div class="card-header header-bg">
        <i class="fa fa-user-plus"></i> Update User
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12 col-md-6 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">First Name</label>
                    <input type="text" class="form-control" id="txtUpdateFirstName" value="<?= $firstName ?>">
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Last Name</label>
                    <input type="text" class="form-control" id="txtUpdateLastName" value="<?= $lastName ?>">
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Gender</label>
                    <select id="txtUpdateGender" class="form-control">
                        <option value="Male" <?= $gender == "Male" ? "selected" : ""; ?>>Male</option>
                        <option value="Female" <?= $gender == "Female" ? "selected" : ""; ?>>Female</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Phone</label>
                    <input type="number" class="form-control" id="txtUpdateNumber" value="<?= $phoneNumber ?>">
                </div>
            </div>
            <div class="col-sm-12 col-md-12 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Address</label>
                    <textarea id="txtUpdateAddress" class="form-control"><?= $address ?></textarea>
                </div>
            </div>
        </div>
        <div class="row-2 d-flex justify-content-end mt-3">
            <button class="btn btn-primary" id="btnUpdateUser" user-id="<?= $userId ?>">Update User</button>
        </div>
    </div>
</div>

<!-- Custom JS -->
<script src='../../js/custom/user-settings.js?v=<?= $cashClear ?>'></script>
<!-- Custom JS -->