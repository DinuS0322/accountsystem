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

$userId = filter_var($_POST['userId'], FILTER_DEFAULT);
$data_status = filter_var($_POST['data_status'], FILTER_DEFAULT);
try {
    $updateSavingStmt = $db->prepare('UPDATE tbl_client_users SET status=? where id = ? ');

    $updateSavingStmt->bindParam(1, $data_status);
    $updateSavingStmt->bindParam(2, $userId);

    $updateSavingStmt->execute();

    $activityStmt = $db->prepare('INSERT INTO `tbl_activity_log` (userName, currentDate, userEmail, userType, activity, activityPath)
                                        VALUES (:userName,:currentDate,:userEmail,:userType,:activity,:activityPath) ');

    $activityStmt->execute([
        ':userName' => $userFirstName,
        ':currentDate' => $curDate,
        ':userEmail' => $userEmail,
        ':userType' => $userType,
        ':activity' => 'Update client users',
        ':activityPath' => 'Users Id -' . $userId

    ]);

    echo 'success';
} catch (PDOException $e) {
    echo $e->getMessage();
}
