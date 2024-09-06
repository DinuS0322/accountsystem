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
$txtGender = filter_var($_POST['txtGender'], FILTER_DEFAULT);
$txtNumber = filter_var($_POST['txtNumber'], FILTER_DEFAULT);
$txtUserType = filter_var($_POST['txtUserType'], FILTER_DEFAULT);
$txtEmail = filter_var($_POST['txtEmail'], FILTER_DEFAULT);
$txtPassword = filter_var($_POST['txtPassword'], FILTER_DEFAULT);
$txtAddress = filter_var($_POST['txtAddress'], FILTER_DEFAULT);
$txtBranch = filter_var($_POST['txtBranch'], FILTER_DEFAULT);
$hashPassword = password_hash($txtPassword, PASSWORD_BCRYPT);
$currDateTime = date('d-m-Y H:i:s');
try {
    $sql = "SELECT * FROM tbl_users WHERE email = :login";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':login', $txtEmail, PDO::PARAM_STR);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        echo 'userFound';
    } else {
        $stmt = $db->prepare('INSERT INTO `tbl_users` (registerDate, firstName, lastName, email, password, phoneNumber, address, userType, gender, branch )
        VALUES (:registerDate, :firstName, :lastName, :email, :password, :phoneNumber, :address, :userType, :gender, :branch)');

        $stmt->execute([
            ':registerDate' => $currDateTime,
            ':firstName' => $txtFirstName,
            ':lastName' => $txtLastName,
            ':email' => $txtEmail,
            ':password' => $hashPassword,
            ':phoneNumber' => $txtNumber,
            ':address' => $txtAddress,
            ':userType' => $txtUserType,
            ':gender' => $txtGender,
            ':branch' => $txtBranch
        ]);

        $activityStmt = $db->prepare('INSERT INTO `tbl_activity_log` (userName, currentDate, userEmail, userType, activity, activityPath)
        VALUES (:userName,:currentDate,:userEmail,:userType,:activity,:activityPath) ');

        $activityStmt->execute([
            ':userName' => $userFirstName,
            ':currentDate' => $curDate,
            ':userEmail' => $userEmail,
            ':userType' => $userType,
            ':activity' => 'Create User',
            ':activityPath' => $txtFirstName

        ]);
        echo 'success';
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
