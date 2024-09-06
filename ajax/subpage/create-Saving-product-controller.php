<?php
require '../../config.php';

$sqlPMethod = "SELECT * FROM tbl_account_settings  where accountType = 'DEFAULT_ACCOUNT'";
$stmtCount = $db->prepare($sqlPMethod);
$stmtCount->execute();

if ($row = $stmtCount->fetchObject()) {
    $accountId = $row->accountId;
}

if($stmtCount->rowCount() > 0){

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
$curDate = date('Y-m-d');

$txtProductCategory = filter_var($_POST['txtProductCategory'], FILTER_DEFAULT);
$txtOtherProductYears = filter_var($_POST['txtOtherProductYears'], FILTER_DEFAULT);
$txtProductName = filter_var($_POST['txtProductName'], FILTER_DEFAULT);
$txtProductShortName = filter_var($_POST['txtProductShortName'], FILTER_DEFAULT);
$txtProductDescription = filter_var($_POST['txtProductDescription'], FILTER_DEFAULT);
$txtProductInterest = filter_var($_POST['txtProductInterest'], FILTER_DEFAULT);

$productId = randomCode(10);

if($txtProductCategory == 'Normal'){
    $categoryYears = '';
}else if($txtProductCategory == 'Children'){
    $categoryYears = '18';
}else{
    $categoryYears = $txtOtherProductYears;
}

try {
    $stmt = $db->prepare('INSERT INTO `tbl_savings_product` (date,category,years,name,shortName,descriptions,interest,productId )
                                        VALUES (:date,:category,:years,:name, :shortName, :descriptions,:interest,:productId)');

    $stmt->execute([
        ':date' => $curDate,
        ':category' => $txtProductCategory,
        ':years' => $categoryYears,
        ':name' => $txtProductName,
        ':shortName' => $txtProductShortName,
        ':descriptions' => $txtProductDescription,
        ':interest' => (float)$txtProductInterest,
        ':productId' => $productId
    ]);

    $activityStmt = $db->prepare('INSERT INTO `tbl_activity_log` (userName, currentDate, userEmail, userType, activity, activityPath)
                                        VALUES (:userName,:currentDate,:userEmail,:userType,:activity,:activityPath) ');

    $activityStmt->execute([
        ':userName' => $userFirstName,
        ':currentDate' => $curDate,
        ':userEmail' => $userEmail,
        ':userType' => $userType,
        ':activity' => 'Create Savings Product',
        ':activityPath' => $txtProductName

    ]);

    echo 'success';
} catch (PDOException $e) {
    echo $e->getMessage();
}

}else{
    echo 0;
}