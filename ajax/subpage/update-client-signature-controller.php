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

$clientId = filter_var($_POST['clientId'], FILTER_DEFAULT);
$eSignatureType = filter_var($_POST['eSignatureType'], FILTER_DEFAULT);
$esignImage = $db->query("SELECT `esignImage` FROM tbl_client WHERE id = $clientId")->fetchColumn(0);
$currDateTime = date('d-m-Y H:i:s');
try {

    if ($eSignatureType != 'empty') {
        $tempFileLocation = $_FILES['eSignature']['tmp_name'];
        $targetLocalPath = "../../upload/esignature/" . $esignImage;
        move_uploaded_file($tempFileLocation, $targetLocalPath);
    } else {
        $eSignatureType = 'empty';
    }





        $activityStmt = $db->prepare('INSERT INTO `tbl_activity_log` (userName, currentDate, userEmail, userType, activity, activityPath)
                                        VALUES (:userName,:currentDate,:userEmail,:userType,:activity,:activityPath) ');

        $activityStmt->execute([
            ':userName' => $userFirstName,
            ':currentDate' => $curDate,
            ':userEmail' => $userEmail,
            ':userType' => $userType,
            ':activity' => 'Update Client Signature',
            ':activityPath' => 'Client Id'.$clientId

        ]);
        echo 'success';
    

} catch (PDOException $e) {
    echo $e->getMessage();
}
