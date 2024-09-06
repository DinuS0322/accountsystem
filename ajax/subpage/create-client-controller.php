<?php
require '../../config.php';

// CSRF Protection
if (!isset($_POST['CSRF_TOKEN']) || !isset($_SESSION['CSRF_TOKEN']) || ($_POST['CSRF_TOKEN'] <> $_SESSION['CSRF_TOKEN'])) {
    echo '<p class="error">Error: invalid form submission</p>';
    header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
    exit;
}
// CSRF Protection

$userFirstName = $_SESSION['SESS_USER_NAME'];
$userEmail = $_SESSION['SESS_USER_EMAIL'];
$userType = $_SESSION['SESS_USER_TYPE'];
$curDate = date('d-m-Y H:i:s');

$txtBranchId = filter_var($_POST['txtBranchId'], FILTER_DEFAULT);
$txtClientNicNumber = filter_var($_POST['txtClientNicNumber'], FILTER_DEFAULT);
$txtclientNicIssueDate = filter_var($_POST['txtclientNicIssueDate'], FILTER_DEFAULT);
$txtTitle = filter_var($_POST['txtTitle'], FILTER_DEFAULT);
$txtFirstName = filter_var($_POST['txtFirstName'], FILTER_DEFAULT);
$txtLastName = filter_var($_POST['txtLastName'], FILTER_DEFAULT);
$txtAddress = filter_var($_POST['txtAddress'], FILTER_DEFAULT);
$txtGender = filter_var($_POST['txtGender'], FILTER_DEFAULT);
$txtMaritalStatus = filter_var($_POST['txtMaritalStatus'], FILTER_DEFAULT);
$txtPhoneNumber = filter_var($_POST['txtPhoneNumber'], FILTER_DEFAULT);
$txtNewAccountNumber = filter_var($_POST['txtNewAccountNumber'], FILTER_DEFAULT);
$txtOldAccountNumber = filter_var($_POST['txtOldAccountNumber'], FILTER_DEFAULT);
$txtProfession = filter_var($_POST['txtProfession'], FILTER_DEFAULT);
$txtLoanOfficerId = filter_var($_POST['txtLoanOfficerId'], FILTER_DEFAULT);
$txtSubmittedOn = filter_var($_POST['txtSubmittedOn'], FILTER_DEFAULT);
$folowerName = filter_var($_POST['folowerName'], FILTER_DEFAULT);
$followerNicNumber = filter_var($_POST['followerNicNumber'], FILTER_DEFAULT);
$followerNicIssueDate = filter_var($_POST['followerNicIssueDate'], FILTER_DEFAULT);
$followerAddress = filter_var($_POST['followerAddress'], FILTER_DEFAULT);
$uploadClientPhotoType = filter_var($_POST['uploadClientPhotoType'], FILTER_DEFAULT);
$eSignatureType = filter_var($_POST['eSignatureType'], FILTER_DEFAULT);
$currDateTime = date('d-m-Y H:i:s');
try {

    if ($uploadClientPhotoType != 'empty') {
        $tempFileLocation = $_FILES['uploadClientPhoto']['tmp_name'];
        $fileId = randomText(12);
        $clientUploadImage = $fileId . $uploadClientPhotoType;
        $targetLocalPath = "../../upload/clientImagePhoto/" . $clientUploadImage;
        move_uploaded_file($tempFileLocation, $targetLocalPath);
    } else {
        $clientUploadImage = 'empty';
    }

    if ($eSignatureType != 'empty') {
        $tempFileLocationESignature= $_FILES['eSignature']['tmp_name'];
        $fileIdEsign = randomText(12);
        $esignImage = $fileIdEsign . $eSignatureType;
        $targetEsignLocalPath = "../../upload/esignature/" . $esignImage;
        move_uploaded_file($tempFileLocationESignature, $targetEsignLocalPath);
    } else {
        $esignImage = 'empty';
    }


    $sql = 'SELECT * FROM `tbl_client` WHERE `nicNumber` = :nicNumber ';
    $checkStmt = $db->prepare($sql);
    $checkStmt->bindParam(':nicNumber', $txtNicNumber);
    $checkStmt->execute();
    if ($checkStmt->rowcount() > 0) {
        echo 'already exists';
    }else{

        $stmt = $db->prepare('INSERT INTO `tbl_client` (branchId, nicNumber, title, firstName, lastName, cientAddress, gender, maritalStatus, phoneNumber, accountNumber, oldAccountNumber, profession, loanOfficerId, submittedOn, folowerName, followerNicNumber, followerNicIssueDate, followerAddress, clientImage , esignImage, date, deleted)
                                        VALUES (:branchId, :nicNumber, :title, :firstName, :lastName, :cientAddress ,:gender, :maritalStatus, :phoneNumber, :accountNumber, :oldAccountNumber, :profession, :loanOfficerId, :submittedOn, :folowerName, :followerNicNumber, :followerNicIssueDate, :followerAddress, :clientImage, :esignImage, :date, :deleted)');

        $stmt->execute([
            ':branchId' => (int)$txtBranchId,
            ':nicNumber' => $txtClientNicNumber,
            ':title' => $txtTitle,
            ':firstName' => $txtFirstName,
            ':lastName' => $txtLastName,
            ':cientAddress' => $txtAddress,
            ':gender' => $txtGender,
            ':maritalStatus' => $txtMaritalStatus,
            ':phoneNumber' => $txtPhoneNumber,
            ':accountNumber' => $txtNewAccountNumber,
            ':oldAccountNumber' => $txtOldAccountNumber,
            ':profession' => $txtProfession,
            ':loanOfficerId' => (int)$txtLoanOfficerId,
            ':submittedOn' => $txtSubmittedOn,
            ':folowerName' => $folowerName,
            ':followerNicNumber' => $followerNicNumber,
            ':followerNicIssueDate' => $followerNicIssueDate,
            ':followerAddress' => $followerAddress,
            ':clientImage' => $clientUploadImage,
            ':esignImage' => $esignImage,
            ':date' => $currDateTime,
            ':deleted' => '0',
        ]);

        $activityStmt = $db->prepare('INSERT INTO `tbl_activity_log` (userName, currentDate, userEmail, userType, activity, activityPath)
                                        VALUES (:userName,:currentDate,:userEmail,:userType,:activity,:activityPath) ');

        $activityStmt->execute([
            ':userName' => $userFirstName,
            ':currentDate' => $curDate,
            ':userEmail' => $userEmail,
            ':userType' => $userType,
            ':activity' => 'Create Client',
            ':activityPath' => $txtFirstName

        ]);
        echo 'success';
    }

} catch (PDOException $e) {
    echo $e->getMessage();
}
