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

$txtDefaultAccount = filter_var($_POST['txtDefaultAccount'], FILTER_DEFAULT);

try {

    $sqlPMethod = "SELECT * FROM tbl_account_settings  where accountType = 'DEFAULT_ACCOUNT'";
    $stmtCount = $db->prepare($sqlPMethod);
    $stmtCount->execute();

    if ($stmtCount->rowCount() > 0) {
        $stmt = $db->prepare('UPDATE tbl_account_settings SET accountId=? where accountType = ?');
        $accountType  = 'DEFAULT_ACCOUNT';
        $stmt->bindParam(1, $txtDefaultAccount);
        $stmt->bindParam(2, $accountType);
        $stmt->execute();
    } else {
        $stmt = $db->prepare('INSERT INTO `tbl_account_settings` (date, accountType, accountId)
        VALUES (:date, :accountType, :accountId)');

        $stmt->execute([
            ':date' => $curDate,
            ':accountType' => 'DEFAULT_ACCOUNT',
            ':accountId' => $txtDefaultAccount,
        ]);
    }




    $activityStmt = $db->prepare('INSERT INTO `tbl_activity_log` (userName, currentDate, userEmail, userType, activity, activityPath)
                                        VALUES (:userName,:currentDate,:userEmail,:userType,:activity,:activityPath) ');

    $activityStmt->execute([
        ':userName' => $userFirstName,
        ':currentDate' => $curDate,
        ':userEmail' => $userEmail,
        ':userType' => $userType,
        ':activity' => 'Update default account',
        ':activityPath' => "account Id:" . $txtDefaultAccount

    ]);
    echo 'success';
} catch (PDOException $e) {
    echo $e->getMessage();
}
