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


try{

    $id = filter_var($_POST['id'], FILTER_DEFAULT);
    $deleted = 1;
    $updateSavingStmt = $db->prepare('UPDATE tbl_loan SET deleted=? where id = ? ');

    $updateSavingStmt->bindParam(1, $deleted);
    $updateSavingStmt->bindParam(2, $id);
    $updateSavingStmt->execute();

         $activityPath = 'Delete - ' . $id;

        $activityStmt = $db->prepare('INSERT INTO `tbl_activity_log` (userName, currentDate, userEmail, userType, activity, activityPath)
                                        VALUES (:userName,:currentDate,:userEmail,:userType,:activity,:activityPath) ');

        $activityStmt->execute([
            ':userName' => $userFirstName,
            ':currentDate' => $curDate,
            ':userEmail' => $userEmail,
            ':userType' => $userType,
            ':activity' => 'Delete Loan',
            ':activityPath' => $activityPath
        ]);
} catch (PDOException $e) {
    echo $e->getMessage();
}
