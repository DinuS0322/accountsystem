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

$txtName = filter_var($_POST['txtName'], FILTER_DEFAULT);
$txtNicNumber = filter_var($_POST['txtNicNumber'], FILTER_DEFAULT);
$txtAddress = filter_var($_POST['txtAddress'], FILTER_DEFAULT);
$txtPhoneNumber = filter_var($_POST['txtPhoneNumber'], FILTER_DEFAULT);
$txtMonthlySalary = filter_var($_POST['txtMonthlySalary'], FILTER_DEFAULT);
$txtOtherDetails = filter_var($_POST['txtOtherDetails'], FILTER_DEFAULT);
$searchClient = filter_var($_POST['searchClient'], FILTER_DEFAULT);
$searchProduct = filter_var($_POST['searchProduct'], FILTER_DEFAULT);

// Get the maximum value of the column
$clientSql = "SELECT MAX(id) AS max_value FROM tbl_loan";
$cilentStmt = $db->prepare($clientSql);
$cilentStmt->execute();

// Fetch the result
$clientResult = $cilentStmt->fetch(PDO::FETCH_ASSOC);

$maxValue = $clientResult['max_value'];

$maxValue = (int)$maxValue + 1;

$loanNo = "loan No-" . $maxValue;

try {
    $stmt = $db->prepare('INSERT INTO `tbl_gurantors` (date,name,nicNumber,address,phone,monthlySalary,otherDetails,clientId,productId,newLoan )
                                        VALUES (:date,:name,:nicNumber,:address,:phone,:monthlySalary,:otherDetails,:clientId,:productId,:newLoan)');

    $stmt->execute([
        ':date' => $curDate,
        ':name' => $txtName,
        ':nicNumber' => $txtNicNumber,
        ':address' => $txtAddress,
        ':phone' => (int)$txtPhoneNumber,
        ':monthlySalary' => (int)$txtMonthlySalary,
        ':otherDetails' => $txtOtherDetails,
        ':clientId' => (int)$searchClient,
        ':productId' => (int)$searchProduct,
        ':newLoan' => $loanNo
    ]);

    $activityStmt = $db->prepare('INSERT INTO `tbl_activity_log` (userName, currentDate, userEmail, userType, activity, activityPath)
                                        VALUES (:userName,:currentDate,:userEmail,:userType,:activity,:activityPath) ');

    $activityStmt->execute([
        ':userName' => $userFirstName,
        ':currentDate' => $curDate,
        ':userEmail' => $userEmail,
        ':userType' => $userType,
        ':activity' => 'Create Gurantors',
        ':activityPath' => $txtName

    ]);
    echo 'success';
} catch (PDOException $e) {
    echo $e->getMessage();
}
