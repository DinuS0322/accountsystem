<?php
require '../../config.php';


// CSRF Protection
if (!isset($_POST['CSRF_TOKEN']) || !isset($_SESSION['CSRF_TOKEN']) || ($_POST['CSRF_TOKEN'] <> $_SESSION['CSRF_TOKEN'])) {
    echo '<p class="error">Error: invalid form submission</p>';
    header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
    exit;
}
// CSRF Protection

$SESS_USER_ID = $_SESSION['SESS_USER_ID'];
$userFirstName = $_SESSION['SESS_USER_NAME'];
$userEmail = $_SESSION['SESS_USER_EMAIL'];
$userType = $_SESSION['SESS_USER_TYPE'];
$curDate = date('d-m-Y H:i:s');
$cDate = date('Y-m-d');

try{

    $id = filter_var($_POST['id'], FILTER_DEFAULT);
    $status = 1;
    $updateSavingStmt = $db->prepare('UPDATE tbl_savings_withdrawal SET status=?, requestOfficerId=?, requestDate=? where withdrawalId = ? ');

    $updateSavingStmt->bindParam(1, $status);
    $updateSavingStmt->bindParam(2, $SESS_USER_ID);
    $updateSavingStmt->bindParam(3, $curDate);
    $updateSavingStmt->bindParam(4, $id);
    $updateSavingStmt->execute();

         $activityPath = 'Requst - ' . $id;

        $activityStmt = $db->prepare('INSERT INTO `tbl_activity_log` (userName, currentDate, userEmail, userType, activity, activityPath)
                                        VALUES (:userName,:currentDate,:userEmail,:userType,:activity,:activityPath) ');

        $activityStmt->execute([
            ':userName' => $userFirstName,
            ':currentDate' => $curDate,
            ':userEmail' => $userEmail,
            ':userType' => $userType,
            ':activity' => 'Update Savings withdrawal',
            ':activityPath' => $activityPath
        ]);
} catch (PDOException $e) {
    echo $e->getMessage();
}
