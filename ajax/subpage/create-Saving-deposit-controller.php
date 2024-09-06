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

    $clientData = filter_var($_POST['clientData'], FILTER_DEFAULT);
    $savingAccount = filter_var($_POST['savingAccount'], FILTER_DEFAULT);
    $txtSavingAmount = filter_var($_POST['txtSavingAmount'], FILTER_DEFAULT);

    $productId = $db->query("SELECT `productId` FROM tbl_savings WHERE savingId = $savingAccount")->fetchColumn(0);
    $savingAmount = $db->query("SELECT `savingAmount` FROM tbl_savings WHERE savingId = $savingAccount")->fetchColumn(0);

    $savingAmount = (float)$savingAmount;
    $txtSavingAmountCon = (float)$txtSavingAmount;

    $totalSavings = $savingAmount + $txtSavingAmountCon;
    $totalSavings = (string)$totalSavings;

    $finalSaving = $clientData . '-' . $txtSavingAmount;
    try {

        $updateSavingStmt = $db->prepare('UPDATE tbl_savings SET savingAmount=? where savingId = ? ');

        $updateSavingStmt->bindParam(1, $totalSavings);
        $updateSavingStmt->bindParam(2, $savingAccount);
        $updateSavingStmt->execute();


        $stmtHistory = $db->prepare('INSERT INTO `tbl_savings_history` (date,clientId,savingAmount,paymentStatus,productId,savingId )
        VALUES (:date,:clientId,:savingAmount, :paymentStatus,:productId,:savingId)');

        $stmtHistory->execute([
            ':date' => $curDate,
            ':clientId' => $clientData,
            ':savingAmount' => $txtSavingAmount,
            ':paymentStatus' => 'Credit',
            ':productId' => $productId,
            ':savingId' => $savingAccount
        ]);


        $stmtCollection = $db->prepare('INSERT INTO `tbl_collection_history` (date, officerId,amount,collectionStatus)
        VALUES (:date, :officerId, :amount, :collectionStatus)');

        $stmtCollection->execute([
            ':date' => $curDate,
            ':officerId' => $SESS_USER_ID,
            ':amount' => $txtSavingAmount,
            ':collectionStatus' => 'savings'
        ]);


        $firstName = $db->query("SELECT `firstName` FROM tbl_client WHERE id = $clientData")->fetchColumn(0);


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

        $savingAmountTotal = $db->query("SELECT `savingAmountTotal` FROM tbl_savings_total WHERE clientId = $clientData")->fetchColumn(0);
        if ($savingAmountTotal == '') {
            $category = $db->query("SELECT `category` FROM tbl_savings_product WHERE id = $productId")->fetchColumn(0);
            if ($category == 'Normal') {
                $savingtotalStmt = $db->prepare('INSERT INTO `tbl_savings_total` (date,clientId, savingAmountTotal)
            VALUES (:date,:clientId, :savingAmountTotal)');

                $savingtotalStmt->execute([
                    ':date' => $curDate,
                    ':clientId' => $clientData,
                    ':savingAmountTotal' => $txtSavingAmount
                ]);
            }
        } else {
            $savingDB = floatval($savingAmountTotal);
            $savingTotal = floatval($txtSavingAmount);
            $finalTotalSavings = $savingDB + $savingTotal;

            $category = $db->query("SELECT `category` FROM tbl_savings_product WHERE id = $productId")->fetchColumn(0);
            if ($category == 'Normal') {
                $updateSavingStmt = $db->prepare('UPDATE tbl_savings_total SET savingAmountTotal=?, date=? where clientId = ? ');

                $updateSavingStmt->bindParam(1, $finalTotalSavings);
                $updateSavingStmt->bindParam(2, $curDate);
                $updateSavingStmt->bindParam(3, $clientData);
                $updateSavingStmt->execute();
            }
        }


        $currentDate = date('Y-m-d');

        $getBalance = $db->query("SELECT `balance` FROM tbl_account WHERE id = $accountId")->fetchColumn(0);
        $getBalance = (float)$getBalance;
        $txtSavingAmountGet = (float)$txtSavingAmount;
        $finalGetBalance = $getBalance + $txtSavingAmountGet;
        $finalGetBalanceStr = (string)$finalGetBalance;

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
