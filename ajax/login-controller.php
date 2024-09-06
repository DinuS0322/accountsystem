<?php
require_once '../config.php';
$statusCode = 0;
$statusMsg = '';

// CSRF Protection
if (!isset($_POST['CSRF_TOKEN']) || !isset($_SESSION['CSRF_TOKEN']) || ($_POST['CSRF_TOKEN'] <> $_SESSION['CSRF_TOKEN'])) {
    echo '<p class="error">Error: invalid form submission</p>';
    header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
    exit;
}
// CSRF Protection

//Geting Data
$userEmail = trim(strtolower(filter_var($_POST['txtLoginEmail'], FILTER_DEFAULT)));
$password = filter_var($_POST['txtLoginPassword'], FILTER_DEFAULT);
//Geting Data

try {
    $sql = "SELECT * FROM tbl_users WHERE email = :login";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':login', $userEmail, PDO::PARAM_STR);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {

        if ($row = $stmt->fetchObject()) {
            $encryptPassword = $row->password;
            $userType = $row->userType;
            $firstName = $row->firstName;
            $lastName = $row->lastName;
            $email = $row->email;
            $address = $row->address;
            $id = $row->id;
            $phoneNumber = $row->phoneNumber;
            $nicNumber = $row->nicNumber;
            $branch = $row->branch;
            if (password_verify($password, $encryptPassword)) {

                $accessUserTypes = ['superAdmin','admin','fieldOfficer','branchOfficer','financeManager','director'];
                if (in_array($userType, $accessUserTypes)) {
                    session_regenerate_id();

                    $_SESSION['SESS_USER_ID'] = $id;
                    $_SESSION['SESS_USER_NAME'] = $firstName;
                    $_SESSION['SESS_USER_LAST_NAME'] = $lastName;
                    $_SESSION['SESS_USER_EMAIL'] = $email;
                    $_SESSION['SESS_USER_TYPE'] = $userType;
                    $_SESSION['SESS_USER_ADDRESS'] = $address;
                    $_SESSION['SESS_USER_PHONE'] = $phoneNumber;
                    $_SESSION['SESS_USER_NIC'] = $nicNumber;

                    if($userType == 'fieldOfficer'){
                        $_SESSION['SESS_USER_BRANCH'] = $branch;
                    }else{
                        $_SESSION['SESS_USER_BRANCH'] = '';
                    }
                    $statusCode = 200;
                    $statusMsg = 'login success';
                } else {
                    $statusCode = 505;
                    $statusMsg = 'not authorized';
                }
            } else {
                $statusCode = 401;
                $statusMsg = 'wrong password';
            }
        }
    } else {
        $statusCode = 404;
        $statusMsg = 'user not found';
    }
} catch (Exception $e) {
    $statusCode = 500;
    $statusMsg = $e->getMessage();
}

$responce = new stdClass();
$responce->code = $statusCode;
$responce->message = $statusMsg;
print_r(json_encode($responce, true));
