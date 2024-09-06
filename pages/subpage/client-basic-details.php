<?php
$id = $_GET['id'];
$clientImage = $db->query("SELECT `clientImage` FROM tbl_client WHERE id = $id")->fetchColumn(0);
$firstName = $db->query("SELECT `firstName` FROM tbl_client WHERE id = $id")->fetchColumn(0);
$lastName = $db->query("SELECT `lastName` FROM tbl_client WHERE id = $id")->fetchColumn(0);
$title = $db->query("SELECT `title` FROM tbl_client WHERE id = $id")->fetchColumn(0);
$nicNumber = $db->query("SELECT `nicNumber` FROM tbl_client WHERE id = $id")->fetchColumn(0);
$gender = $db->query("SELECT `gender` FROM tbl_client WHERE id = $id")->fetchColumn(0);
$maritalStatus = $db->query("SELECT `maritalStatus` FROM tbl_client WHERE id = $id")->fetchColumn(0);
$phoneNumber = $db->query("SELECT `phoneNumber` FROM tbl_client WHERE id = $id")->fetchColumn(0);
$accountNumber = $db->query("SELECT `accountNumber` FROM tbl_client WHERE id = $id")->fetchColumn(0);
$profession = $db->query("SELECT `profession` FROM tbl_client WHERE id = $id")->fetchColumn(0);
$folowerName = $db->query("SELECT `folowerName` FROM tbl_client WHERE id = $id")->fetchColumn(0);
$followerNicNumber = $db->query("SELECT `followerNicNumber` FROM tbl_client WHERE id = $id")->fetchColumn(0);
$followerAddress = $db->query("SELECT `followerAddress` FROM tbl_client WHERE id = $id")->fetchColumn(0);
$esignImage = $db->query("SELECT `esignImage` FROM tbl_client WHERE id = $id")->fetchColumn(0);

$fullName = $title . " " . $firstName . " " . $lastName;
$image = "../../upload/clientImagePhoto/$clientImage";
$imagePath = $image;
?>
<div class="row d-flex justify-content-center">
    <img src="<?= $imagePath ?>" id="imgClientImage" class="img-fluid img-thumbnail rounded-circle user-picture custom-size" />
</div>

<div class="row mt-3">
    <table class="table table-align-left" style="border: 1px solid black;" id="viewLoanDetailsTable">
        <tbody>
            <tr>
                <td class="fw-bold">Full Name</td>
                <td><?= $fullName ?></td>
            </tr>
            <tr>
                <td class="fw-bold">NIC Number</td>
                <td><?= $nicNumber ?></td>
            </tr>
            <tr>
                <td class="fw-bold">Gender</td>
                <td><?= $gender ?></td>
            </tr>
            <tr>
                <td class="fw-bold">Marital Status</td>
                <td><?= $maritalStatus ?></td>
            </tr>
            <tr>
                <td class="fw-bold">Phone Number</td>
                <td><?= $phoneNumber ?></td>
            </tr>
            <tr>
                <td class="fw-bold">Account Number</td>
                <td><?= $accountNumber ?></td>
            </tr>
            <tr>
                <td class="fw-bold">Profession</td>
                <td><?= $profession ?></td>
            </tr>
            <tr>
                <td class="fw-bold text-uppercase" colspan="2" style="text-align: center;">Folower Details</td>
            </tr>
            <tr>
                <td class="fw-bold">Name</td>
                <td><?= $folowerName ?></td>
            </tr>
            <tr>
                <td class="fw-bold">NIC Number</td>
                <td><?= $followerNicNumber ?></td>
            </tr>
            <tr>
                <td class="fw-bold">Address</td>
                <td><?= $followerAddress ?></td>
            </tr>
        </tbody>
    </table>


</div>

<div class="row">
    <label for="" class="fw-bold">Signature</label>
</div>
<div class="row">
    <div class="col-6 d-flex justify-content-center">
    <img src="../../upload/esignature/<?= $esignImage ?>" alt="" height="150px" width="150px">
    </div>

</div>