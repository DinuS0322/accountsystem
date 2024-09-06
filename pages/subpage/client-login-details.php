<?php
$id = $_GET['id'];
$nicNumber = $db->query("SELECT `nicNumber` FROM tbl_client WHERE id = $id")->fetchColumn(0);
$firstName = $db->query("SELECT `firstName` FROM tbl_client WHERE id = $id")->fetchColumn(0);
$lastName = $db->query("SELECT `lastName` FROM tbl_client WHERE id = $id")->fetchColumn(0);

$sqlPMethod = "SELECT * FROM tbl_client_users where clientId = $id";
$stmt = $db->prepare($sqlPMethod);
$stmt->execute();



?>
<?php
if ($stmt->rowCount() == 0) {
?>
    <div class="row d-flex justify-content-center">
        <div class="col d-flex justify-content-center">
            <h3 class="fw-bold">Create User Account</h3>
        </div>
    </div>
    <hr>
    <div class="row ">
        <div class="col-6 mt-3">
            <div class="form-group">
                <label class="fw-bold mt-1">First Name</label>
                <input type="text" class="form-control" id="txtFirstName" value="<?= $firstName ?>">
            </div>
        </div>
        <div class="col-6 mt-3">
            <div class="form-group">
                <label class="fw-bold mt-1">Last Name</label>
                <input type="text" class="form-control" id="txtLastName" value="<?= $lastName ?>">
            </div>
        </div>
        <div class="col-6 mt-3">
            <div class="form-group">
                <label class="fw-bold mt-1">NIC Number</label>
                <input type="text" class="form-control" id="txtNicNumber" value="<?= $nicNumber ?>">
            </div>
        </div>
    </div>
    <div class="row-2 d-flex justify-content-end mt-3">
        <button class="btn btn-primary" id="btnCreateClientUser" data-id="<?= $id ?>">Create Account</button>
    </div>
    </div>

<?php
} else {
    $nicNumber = $db->query("SELECT `nicNumber` FROM tbl_client_users WHERE clientId = $id")->fetchColumn(0);
    $viewPassword = $db->query("SELECT `viewPassword` FROM tbl_client_users WHERE clientId = $id")->fetchColumn(0);
?>
<div class="row d-flex justify-content-center" style="margin-left: 35%;">
    <h4><strong>User Details</strong></h4>
</div>
<hr>
    <div class="alert alert-success" role="alert" >
        <div class="row mt-1" style="margin-left: 30%;">
            <div class="col-sm-4 col-md-3">
                <strong>USERNAME :</strong>
            </div>
            <div class="col-sm-4 col-md-3">
                <?= $nicNumber ?>
            </div>
        </div>
        <div class="row" style="margin-left: 30%;">
            <div class="col-sm-4 col-md-3">
                <strong>PASSWORD :</strong>
            </div>
            <div class="col-sm-4 col-md-3">
                <?= $viewPassword ?>
            </div>
        </div>
    </div>
<?php
}
?>