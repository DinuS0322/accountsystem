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

$txtMeetingName = filter_var($_POST['txtMeetingName'], FILTER_DEFAULT);
$txtDate = filter_var($_POST['txtDate'], FILTER_DEFAULT);
$txtTime = filter_var($_POST['txtTime'], FILTER_DEFAULT);
$txtSpecialGuest = filter_var($_POST['txtSpecialGuest'], FILTER_DEFAULT);
$Remarks = filter_var($_POST['Remarks'], FILTER_DEFAULT);
$txtBranch = filter_var($_POST['txtBranch'], FILTER_DEFAULT);
$checkedRadioButtons = filter_var($_POST['checkedRadioButtons'], FILTER_DEFAULT);
$timestamp = strtotime($txtTime);
$timeInAMPM = date('h:i a', $timestamp);

try {
    $stmt = $db->prepare('INSERT INTO `tbl_meeting` (meetingName, Date, Time, specialGuest,remarks,branch,clientReaction, createDate )
                                        VALUES (:meetingName, :Date, :Time, :specialGuest, :remarks, :branch, :clientReaction, :createDate)');

    $stmt->execute([
        ':meetingName' => $txtMeetingName,
        ':Date' => $txtDate,
        ':Time' => $timeInAMPM,
        ':specialGuest' => $txtSpecialGuest,
        ':remarks' => $Remarks,
        ':branch' => $txtBranch,
        ':clientReaction' => "$checkedRadioButtons",
        ':createDate' => $curDate
    ]);

    $activityStmt = $db->prepare('INSERT INTO `tbl_activity_log` (userName, currentDate, userEmail, userType, activity, activityPath)
                                        VALUES (:userName,:currentDate,:userEmail,:userType,:activity,:activityPath) ');

    $activityStmt->execute([
        ':userName' => $userFirstName,
        ':currentDate' => $curDate,
        ':userEmail' => $userEmail,
        ':userType' => $userType,
        ':activity' => 'Create Meeting',
        ':activityPath' => $txtMeetingName

    ]);
    echo 'success';
} catch (PDOException $e) {
    echo $e->getMessage();
}
