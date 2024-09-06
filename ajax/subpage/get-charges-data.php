<?php
require '../../config.php';
$statusCode = 0;
$statusMsg = '';

// CSRF Protection
if (!isset($_POST['CSRF_TOKEN']) || !isset($_SESSION['CSRF_TOKEN']) || ($_POST['CSRF_TOKEN'] <> $_SESSION['CSRF_TOKEN'])) {
    echo '<p class="error">Error: invalid form submission</p>';
    header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
    exit;
}
// CSRF Protection

$getAllChargers = filter_var($_POST['getAllChargers'], FILTER_DEFAULT);
$searchProduct = filter_var($_POST['searchProduct'], FILTER_DEFAULT);
$searchClient = filter_var($_POST['searchClient'], FILTER_DEFAULT);

$sql = "SELECT * FROM tbl_loan_charge where id=$getAllChargers";
$stmt = $db->prepare($sql);
$stmt->execute();

try {

    // Get the maximum value of the column
    $clientSql = "SELECT MAX(id) AS max_value FROM tbl_loan";
    $cilentStmt = $db->prepare($clientSql);
    $cilentStmt->execute();

    // Fetch the result
    $clientResult = $cilentStmt->fetch(PDO::FETCH_ASSOC);

    $maxValue = $clientResult['max_value'];

    $maxValue = (int)$maxValue + 1;

    $loanNo = "loan No-" . $maxValue;

    if ($row = $stmt->fetchObject()) {
        $chargeName = $row->chargeName;
        $chargeType = $row->chargeType;
        $chargeType = $db->query("SELECT `chargeType` FROM tbl_charge WHERE id = $getAllChargers")->fetchColumn(0);
        $amount = $row->amount;

        $dbStmt = $db->prepare('INSERT INTO `tbl_add_charges` (loanChargeId,productId,clientId,newLoan)
                                        VALUES (:loanChargeId,:productId, :clientId,:newLoan)');

        $dbStmt->execute([
            ':loanChargeId' => (int)$getAllChargers,
            ':productId' => (int)$searchProduct,
            ':clientId' => (int)$searchClient,
            ':newLoan' => $loanNo
        ]);

        $statusCode = 200;
    } else {
        $statusCode = 502;
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}


$responce = new stdClass();
$responce->code = $statusCode;
$responce->message = $statusMsg;
$responce->chargeName = $chargeName;
$responce->chargeType = $chargeType;
$responce->amount = $amount;

print_r(json_encode($responce, true));
