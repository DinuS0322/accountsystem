<?php
require '../../config.php';

// CSRF Protection
if (!isset($_POST['CSRF_TOKEN']) || !isset($_SESSION['CSRF_TOKEN']) || ($_POST['CSRF_TOKEN'] <> $_SESSION['CSRF_TOKEN'])) {
    echo '<p class="error">Error: invalid form submission</p>';
    header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
    exit;
}
// CSRF Protection


$txtFieldOfficerId = filter_var($_POST['txtFieldOfficerId'], FILTER_DEFAULT);

try {

    $sqlPMethodHistory = "SELECT * FROM tbl_collection_history where officerId ='$txtFieldOfficerId' ";
    $stmtHistory = $db->prepare($sqlPMethodHistory);
    $stmtHistory->execute();
    $collectionPendingAmount = 0;
    while ($row = $stmtHistory->fetchObject()) {
        $amount = $row->amount;
        $collectionPendingAmount = $collectionPendingAmount + $amount;
    }


    $sqlPMethod = "SELECT * FROM tbl_collection where officerId ='$txtFieldOfficerId' ";
        $stmt = $db->prepare($sqlPMethod);
        $stmt->execute();
        $i = 0;
        while ($row = $stmt->fetchObject()) {
            $i++;
        }

        if($i == 0){
            $finalCollection = $collectionPendingAmount;
        }else{
            $amount = $db->query("SELECT `amount` FROM tbl_collection WHERE officerId = '$txtFieldOfficerId'")->fetchColumn(0);
            $finalCollection = (float)$collectionPendingAmount - (float)$amount;
        }
    echo $finalCollection;
} catch (PDOException $e) {
    echo $e->getMessage();
}
