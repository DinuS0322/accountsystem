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

$txtFirstName = filter_var($_POST['txtFirstName'], FILTER_DEFAULT);
$txtLastName = filter_var($_POST['txtLastName'], FILTER_DEFAULT);
$txtNicNumber = filter_var($_POST['txtNicNumber'], FILTER_DEFAULT);
$clientId = filter_var($_POST['clientId'], FILTER_DEFAULT);
$name = substr($txtFirstName, 0, 3);
$randomPassword = randomText(5);
$txtPassword = $name . $randomPassword;
$hashPassword = password_hash($txtPassword, PASSWORD_BCRYPT);
$currDateTime = date('d-m-Y H:i:s');
try {
    $stmt = $db->prepare('INSERT INTO `tbl_client_users` (registerDate, firstName, lastName, password, nicNumber, viewPassword, clientId, userType)
                                        VALUES (:registerDate, :firstName, :lastName, :password, :nicNumber, :viewPassword, :clientId, :userType)');

    $stmt->execute([
        ':registerDate' => $currDateTime,
        ':firstName' => $txtFirstName,
        ':lastName' => $txtLastName,
        ':password' => $hashPassword,
        ':nicNumber' => $txtNicNumber,
        ':viewPassword' => $txtPassword,
        ':clientId' => $clientId,
        ':userType' => 'Client'
    ]);

    $activityStmt = $db->prepare('INSERT INTO `tbl_activity_log` (userName, currentDate, userEmail, userType, activity, activityPath)
                                        VALUES (:userName,:currentDate,:userEmail,:userType,:activity,:activityPath) ');

    $activityStmt->execute([
        ':userName' => $userFirstName,
        ':currentDate' => $curDate,
        ':userEmail' => $userEmail,
        ':userType' => $userType,
        ':activity' => 'Create Client User',
        ':activityPath' => $txtFirstName . '-' . $clientId

    ]);
    echo 'success';
} catch (PDOException $e) {
    echo $e->getMessage();
}
