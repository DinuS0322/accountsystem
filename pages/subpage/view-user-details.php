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
        <i class="fas fa-money-check-alt"></i> View User Details
    </div>
    <div class="card-body">
        <div id="viewUserDetails" class="row mt-5">
            <table class="table table-align-left" style="border: 1px solid black;" id="viewLoanDetailsTable">
                <tbody>
                    <tr>
                        <td class="fw-bold">User Id</td>
                        <td><?= $userId ?></td>
                    </tr>
                       <tr>
                        <td class="fw-bold">Register Date</td>
                        <td><?= $registerDate ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">First Name</td>
                        <td><?= $firstName ?></td>
                    </tr>
                 
                    <tr>
                        <td class="fw-bold">Last Name</td>
                        <td><?= $lastName ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Email Address</td>
                        <td><?= $email ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Phone Number</td>
                        <td><?= $phoneNumber ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">NIC Number</td>
                        <td><?= $nicNumber ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Address</td>
                        <td><?= $address ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Gender </td>
                        <td><?= $gender ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">User Type </td>
                        <td><span class='badge badge-primary'><?= $userType ?></span></td>
                    </tr>
                  
                </tbody>
            </table>
        </div>
    </div>
</div>
