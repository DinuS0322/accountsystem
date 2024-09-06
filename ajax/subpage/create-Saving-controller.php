<?php
require '../../config.php';
$SESS_USER_ID = $_SESSION['SESS_USER_ID'];

$sqlPMethod = "SELECT * FROM tbl_account_settings  where accountType = 'DEFAULT_ACCOUNT'";
$stmtCount = $db->prepare($sqlPMethod);
$stmtCount->execute();

if ($row = $stmtCount->fetchObject()) {
    $accountId = $row->accountId;
}

if ($stmtCount->rowCount() > 0) {

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

    $txtSavingAmount = filter_var($_POST['txtSavingAmount'], FILTER_DEFAULT);
    $searchClient = filter_var($_POST['searchClient'], FILTER_DEFAULT);
    $searchProduct = filter_var($_POST['searchProduct'], FILTER_DEFAULT);

    $txtPersonalName = filter_var($_POST['txtPersonalName'], FILTER_DEFAULT);
    $txtStartDate = filter_var($_POST['txtStartDate'], FILTER_DEFAULT);
    $txtChildrenName = filter_var($_POST['txtChildrenName'], FILTER_DEFAULT);
    $txtChildrenDateOfBirth = filter_var($_POST['txtChildrenDateOfBirth'], FILTER_DEFAULT);

    $savingId = randomCode(10);

    $finalSaving = $searchClient . '-' . $txtSavingAmount;
    try {
        $stmt = $db->prepare('INSERT INTO `tbl_savings` (date,clientId,savingAmount,status,paymentStatus,productId,personalName,startDate,childrenName,childrenDOB,savingId )
                                        VALUES (:date,:clientId,:savingAmount,:status, :paymentStatus,:productId,:personalName,:startDate,:childrenName,:childrenDOB,:savingId)');

        $stmt->execute([
            ':date' => $curDate,
            ':clientId' => $searchClient,
            ':savingAmount' => $txtSavingAmount,
            ':status' => 'saving directly',
            ':paymentStatus' => 'Credit',
            ':productId' => $searchProduct,
            ':personalName' => $txtPersonalName,
            ':startDate' => $txtStartDate,
            ':childrenName' => $txtChildrenName,
            ':childrenDOB' => $txtChildrenDateOfBirth,
            ':savingId' => $savingId
        ]);


        $stmtCollection = $db->prepare('INSERT INTO `tbl_collection_history` (date, officerId,amount,collectionStatus)
        VALUES (:date, :officerId, :amount, :collectionStatus)');

        $stmtCollection->execute([
            ':date' => $curDate,
            ':officerId' => $SESS_USER_ID,
            ':amount' => $txtSavingAmount,
            ':collectionStatus' => 'savings'
        ]);

        $stmtHistory = $db->prepare('INSERT INTO `tbl_savings_history` (date,clientId,savingAmount,paymentStatus,productId,savingId )
        VALUES (:date,:clientId,:savingAmount, :paymentStatus,:productId,:savingId)');

        $stmtHistory->execute([
            ':date' => $curDate,
            ':clientId' => $searchClient,
            ':savingAmount' => $txtSavingAmount,
            ':paymentStatus' => 'Credit',
            ':productId' => $searchProduct,
            ':savingId' => $savingId
        ]);


        $firstName = $db->query("SELECT `firstName` FROM tbl_client WHERE id = $searchClient")->fetchColumn(0);


        $activityStmt = $db->prepare('INSERT INTO `tbl_activity_log` (userName, currentDate, userEmail, userType, activity, activityPath)
                                        VALUES (:userName,:currentDate,:userEmail,:userType,:activity,:activityPath) ');

        $activityStmt->execute([
            ':userName' => $userFirstName,
            ':currentDate' => $curDate,
            ':userEmail' => $userEmail,
            ':userType' => $userType,
            ':activity' => "Create Savings- $firstName",
            ':activityPath' => $finalSaving

        ]);

        $savingAmountTotal = $db->query("SELECT `savingAmountTotal` FROM tbl_savings_total WHERE clientId = $searchClient")->fetchColumn(0);
        if ($savingAmountTotal == '') {
            $category = $db->query("SELECT `category` FROM tbl_savings_product WHERE id = $searchProduct")->fetchColumn(0);
            if ($category == 'Normal') {
                $savingtotalStmt = $db->prepare('INSERT INTO `tbl_savings_total` (date,clientId, savingAmountTotal)
            VALUES (:date,:clientId, :savingAmountTotal)');

                $savingtotalStmt->execute([
                    ':date' => $curDate,
                    ':clientId' => $searchClient,
                    ':savingAmountTotal' => $txtSavingAmount
                ]);
            }
        } else {
            $savingDB = floatval($savingAmountTotal);
            $savingTotal = floatval($txtSavingAmount);
            $finalTotalSavings = $savingDB + $savingTotal;

            $category = $db->query("SELECT `category` FROM tbl_savings_product WHERE id = $searchProduct")->fetchColumn(0);
            if ($category == 'Normal') {
                $updateSavingStmt = $db->prepare('UPDATE tbl_savings_total SET savingAmountTotal=?, date=? where clientId = ? ');

                $updateSavingStmt->bindParam(1, $finalTotalSavings);
                $updateSavingStmt->bindParam(2, $curDate);
                $updateSavingStmt->bindParam(3, $searchClient);
                $updateSavingStmt->execute();
            }
        }


        $currentDate = date('Y-m-d');

        $getBalance = $db->query("SELECT `balance` FROM tbl_account WHERE id = $accountId")->fetchColumn(0);
        $getBalance = (float)$getBalance;
        $txtSavingAmountGet = (float)$txtSavingAmount;
        $finalGetBalance = $getBalance + $txtSavingAmountGet;
        $finalGetBalanceStr = (string)$finalGetBalance;

        $category = $db->query("SELECT `category` FROM tbl_savings_product WHERE id = $searchProduct")->fetchColumn(0);

        $db->query("UPDATE tbl_account SET balance = '$finalGetBalanceStr' WHERE id = $accountId");


        $stmtTRansferFrom = $db->prepare('INSERT INTO `tbl_transfer_history` (transferDate, account, accountStatus, reason, accountBalance, transferAmount )
        VALUES (:transferDate, :account, :accountStatus,  :reason, :accountBalance, :transferAmount)');

        $stmtTRansferFrom->execute([
            ':transferDate' => $currentDate,
            ':account' => $accountId,
            ':accountStatus' => 'Credit',
            ':reason' => "Savings - clientName - $firstName",
            ':accountBalance' => $finalGetBalanceStr,
            ':transferAmount' => $txtSavingAmount,
        ]);




        echo 'success';
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
} else {
    echo 0;
}
