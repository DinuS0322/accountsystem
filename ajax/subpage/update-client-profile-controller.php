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
$uploadClientPhotoType = filter_var($_POST['uploadClientPhotoType'], FILTER_DEFAULT);
$clientImage = $db->query("SELECT `clientImage` FROM tbl_client WHERE id = $clientId")->fetchColumn(0);
$currDateTime = date('d-m-Y H:i:s');
try {

    if ($uploadClientPhotoType != 'empty') {
        $tempFileLocation = $_FILES['uploadClientPhoto']['tmp_name'];
        $targetLocalPath = "../../upload/clientImagePhoto/" . $clientImage;
        move_uploaded_file($tempFileLocation, $targetLocalPath);
    } else {
        $clientUploadImage = 'empty';
    }





        $activityStmt = $db->prepare('INSERT INTO `tbl_activity_log` (userName, currentDate, userEmail, userType, activity, activityPath)
                                        VALUES (:userName,:currentDate,:userEmail,:userType,:activity,:activityPath) ');

        $activityStmt->execute([
            ':userName' => $userFirstName,
            ':currentDate' => $curDate,
            ':userEmail' => $userEmail,
            ':userType' => $userType,
            ':activity' => 'Update Client Profile',
            ':activityPath' => 'Client Id'.$clientId

        ]);
        echo 'success';
    

} catch (PDOException $e) {
    echo $e->getMessage();
}
