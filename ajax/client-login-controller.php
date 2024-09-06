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
$txtLoginNic = trim(strtolower(filter_var($_POST['txtLoginNic'], FILTER_DEFAULT)));
$password = filter_var($_POST['txtLoginPassword'], FILTER_DEFAULT);
//Geting Data

try {
    $sql = "SELECT * FROM tbl_client_users WHERE nicNumber = :login";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':login', $txtLoginNic, PDO::PARAM_STR);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {

        if ($row = $stmt->fetchObject()) {
            $encryptPassword = $row->password;
            $firstName = $row->firstName;
            $lastName = $row->lastName;
            $id = $row->id;
            $userType = $row->userType;
            $nicNumber = $row->nicNumber;
            $status = $row->status;
            if (password_verify($password, $encryptPassword)) {

                $accessUserTypes = ['Client'];
                if (in_array($userType, $accessUserTypes)) {
                    session_regenerate_id();
                    if($status == 0){
                        $_SESSION['SESS_USER_ID'] = $id;
                        $_SESSION['SESS_USER_NAME'] = $firstName;
                        $_SESSION['SESS_USER_LAST_NAME'] = $lastName;
                        $_SESSION['SESS_USER_EMAIL'] = "";
                        $_SESSION['SESS_USER_TYPE'] = $userType;
                        $_SESSION['SESS_USER_ADDRESS'] = "";
                        $_SESSION['SESS_USER_PHONE'] = "";
                        $_SESSION['SESS_USER_NIC'] = $nicNumber;
    
                        $statusCode = 200;
                        $statusMsg = 'login success';
                    }else{
                        $statusCode = 405;
                        $statusMsg = 'blocked';
                    }
          
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
