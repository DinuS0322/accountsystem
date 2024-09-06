<?php
$userId = $SESS_USER_ID;
$proPic = "images/user-logo.png";
$SESS_USER_ID = $_SESSION['SESS_USER_ID'];

$sqlPMethod = "SELECT * FROM tbl_users where id = $SESS_USER_ID";
$stmt = $db->prepare($sqlPMethod);
$stmt->execute();
if ($row = $stmt->fetchObject()) {
    $firstName = $row->firstName;
    $lastName = $row->lastName;
    $phoneNumber = $row->phoneNumber;
    $address = $row->address;
}
?>

<section class="user-info">
    <div class="card mb-2">
        <div class="card-body pt-3">
            <div class="text-center mb-3">
                <img src="<?= $proPic ?>" id="imgDocPictureUpload" class="img-fluid img-thumbnail rounded-circle user-picture" />
                <input type="file" id="fileDocPictureUpload" class="hidden" accept="image/*">
                <!-- <br>
                <button class="btn btn-light btn-sm mt-2 mb-2" id="btnUploadDocProPicture"><i class="fas fa-camera"></i> Change Image</button> -->
                <br>
                <h2><?= $firstName . ' ' . $lastName ?></h2>
                <h5 class='text-uppercase'><?= $SESS_USER_TYPE ?></h5>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body pt-3">

            <div class="row">
                <div class="mb-2 col-md-6">
                    <label for="txtFirstName" class="col-md-12 pl-0 pt-2 strong">
                        First Name <span class="text-danger">*</span>
                    </label>
                    <input type="text" id="txtAdminFirstName" class="form-control" autocomplete="off" value="<?= $firstName ?>">
                </div>
                <div class="mb-2 col-md-6">
                    <label for="txtLastName" class="col-md-12 pl-0 pt-2 strong">
                        Last Name <span class="text-danger">*</span>
                    </label>
                    <input type="text" id="txtAdminLastName" class="form-control" autocomplete="off" value="<?= $lastName ?>">
                </div>
                <div class="mb-2 col-md-6">
                    <label for="txtPhone" class="col-md-12 pl-0 pt-2 strong">
                        Phone <span class="text-danger">*</span>
                    </label>
                    <input type="text" id="txtAdminPhone" class="form-control" autocomplete="off" value="<?= $phoneNumber ?>">
                </div>
                <div class="mb-2 col-md-6">
                    <label for="txtLastName" class="col-md-12 pl-0 pt-2 strong">
                        Address <span class="text-danger">*</span>
                    </label>
                    <input type="text" id="txtAdminAddress" class="form-control" autocomplete="off" value="<?= $address ?>">
                </div>


            </div>
        </div>


    </div>

    <div class="float-end">
    <a href="index.php?page=all-subpages&subpage=admin-change-password"> <button class="btn btn-secondary mb-1" id="btnClientChangePassword">Change Password</button></a> 
        <button class="btn btn-primary mb-1" id="btnUpdateAdminProfile">Save Changes</button>
    </div>
</section>







<!-- Custom JS -->
<script src='js/custom/admin-profile.js?v=<?= $cashClear ?>'></script>
<!-- Custom JS -->