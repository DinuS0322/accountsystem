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
$SESS_USER_ID = $_SESSION['SESS_USER_ID'];
$userFirstName = $_SESSION['SESS_USER_NAME'];
$userEmail = $_SESSION['SESS_USER_EMAIL'];
$userType = $_SESSION['SESS_USER_TYPE'];
$curDate = date('d-m-Y H:i:s');

$txtApprovalStatus = filter_var($_POST['txtApprovalStatus'], FILTER_DEFAULT);
$txtApprovedReason = filter_var($_POST['txtApprovedReason'], FILTER_DEFAULT);
$loanIdView = filter_var($_POST['loanIdView'], FILTER_DEFAULT);
try {



    if ($txtApprovalStatus == 'approved') {

        $txtCheqeNo = filter_var($_POST['txtCheqeNo'], FILTER_DEFAULT);
        $txtSelectAccount = filter_var($_POST['txtSelectAccount'], FILTER_DEFAULT);
        $txtApprovedDes = filter_var($_POST['txtApprovedDes'], FILTER_DEFAULT);

        $getPrincipal = $db->query("SELECT `principal` FROM tbl_loan WHERE id = $loanIdView")->fetchColumn(0);
        $getPrincipal = (float)$getPrincipal;
        $getbalance = $db->query("SELECT `balance` FROM tbl_account WHERE id = $txtSelectAccount")->fetchColumn(0);
        $getbalance = (float)$getbalance;

        if($getbalance > $getPrincipal){

        $interestRateType = $db->query("SELECT `interestRateType` FROM tbl_loan WHERE id = $loanIdView")->fetchColumn(0);

        if ($interestRateType == 'Flate Rate') {
            //All Payment Data - START
            $sqlPMethod = "SELECT * FROM tbl_loan where id=$loanIdView";
            $stmt = $db->prepare($sqlPMethod);
            $stmt->execute();
            if ($row = $stmt->fetchObject()) {
                $id = $row->id;
                $principal = $row->principal;
                $interestRate = $row->interestRate;
                $interestPer = $row->interestPer;
                $firstPaymentDate = $row->firstPaymentDate;
                $repaymentType = $row->repaymentType;
                $longTerm = $row->longTerm;
            }
            // $formattedNumber = number_format($principal, 2);
            $principal = floatval($principal);
            $interestRate = floatval($interestRate);
            $longTerm = intval($longTerm);
            $firstPaymentDateConver = DateTime::createFromFormat('Y-m-d', $firstPaymentDate);
            $endPaymentDateConver = DateTime::createFromFormat('Y-m-d', $firstPaymentDate);
            if ($interestPer == 'Month') {

                $interestRateConvert = $interestRate / 100;
                $calInterst = $principal * $interestRateConvert;
                $totoalPaymentInterest = $calInterst * $longTerm;
                $totoalPaymentMonth = $totoalPaymentInterest + $principal;
                $monthlyPayment = $totoalPaymentMonth / $longTerm;
                $principalMonthlyPay = $monthlyPayment - $calInterst;
                $balance = $totoalPaymentMonth - $monthlyPayment;
                $balance = number_format($balance, 2);

                if ($repaymentType == 'Months') {
                    // Insert Monthy By month - START

                    $activityStmt = $db->prepare('INSERT INTO `tbl_loan_reschedule` (currentDate, paymentDate, amountToPay, principalAmount, interest, balance, status,latePenalty,LoanId)
                                        VALUES (:currentDate,:paymentDate,:amountToPay,:principalAmount,:interest,:balance, :status, :latePenalty, :LoanId) ');

                    $activityStmt->execute([
                        ':currentDate' => $curDate,
                        ':paymentDate' => $firstPaymentDate,
                        ':amountToPay' => $monthlyPayment,
                        ':principalAmount' => $principalMonthlyPay,
                        ':interest' => $calInterst,
                        ':balance' => $balance,
                        ':status' => 'unpaid',
                        ':latePenalty' => '',
                        ':LoanId' => $loanIdView,
                    ]);
                    // Insert Monthy By month - START
                    for (
                        $i = 1;
                        $i <= $longTerm - 1;
                        $i++
                    ) {
                        $firstPaymentDateConver->modify("+1 month");
                        $monthbymonthpay = $firstPaymentDateConver->format('Y-m-d');
                        $balance = str_replace(',', '', $balance);
                        $finalBalance = $balance - $monthlyPayment;
                        $finalBalance = number_format($finalBalance, 2);

                        // Insert Monthy By month - START

                        $activityStmt = $db->prepare('INSERT INTO `tbl_loan_reschedule` (currentDate, paymentDate, amountToPay, principalAmount, interest, balance, status,latePenalty,LoanId)
                                        VALUES (:currentDate,:paymentDate,:amountToPay,:principalAmount,:interest,:balance, :status, :latePenalty, :LoanId) ');

                        $activityStmt->execute([
                            ':currentDate' => $curDate,
                            ':paymentDate' => $monthbymonthpay,
                            ':amountToPay' => $monthlyPayment,
                            ':principalAmount' => $principalMonthlyPay,
                            ':interest' => $calInterst,
                            ':balance' => $finalBalance,
                            ':status' => 'unpaid',
                            ':latePenalty' => '',
                            ':LoanId' => $loanIdView,
                        ]);
                        // Insert Monthy By month - START

                        $balance = $finalBalance;
                    }
                } else if ($repaymentType == 'Weeks') {

                    $getWeekLongTerm = $longTerm - 1;
                    $endPaymentDateConver->modify("+" . $getWeekLongTerm . "month");
                    $endPayDate = $endPaymentDateConver->format('Y-m-d');

                    $start_date = new DateTime($firstPaymentDate);
                    $end_date = new DateTime($endPayDate);

                    $interval = new DateInterval('P1W');
                    $daterange = new DatePeriod($start_date, $interval, $end_date);

                    $countWeek = 0;
                    foreach ($daterange as $countWeekData) {
                        $countWeek++;
                    }
                    $weeklyPayment = $totoalPaymentMonth / $countWeek;
                    $weekInterest = $totoalPaymentInterest / $countWeek;
                    $weekPrincipalAm = $weeklyPayment - $weekInterest;
                    $weekTototalPay = $totoalPaymentMonth;
                    foreach ($daterange as $date) {
                        $weekPayDate = $date->format('Y-m-d');
                        $weekBalance = $weekTototalPay - $weeklyPayment;
                        $finalWeekBalance = number_format($weekBalance, 2);

                        // Insert Week By Week - START

                        $activityStmt = $db->prepare('INSERT INTO `tbl_loan_reschedule` (currentDate, paymentDate, amountToPay, principalAmount, interest, balance, status,latePenalty,LoanId)
                                        VALUES (:currentDate,:paymentDate,:amountToPay,:principalAmount,:interest,:balance, :status, :latePenalty, :LoanId) ');

                        $activityStmt->execute([
                            ':currentDate' => $curDate,
                            ':paymentDate' => $weekPayDate,
                            ':amountToPay' => $weeklyPayment,
                            ':principalAmount' => $weekPrincipalAm,
                            ':interest' => $weekInterest,
                            ':balance' => $finalWeekBalance,
                            ':status' => 'unpaid',
                            ':latePenalty' => '',
                            ':LoanId' => $loanIdView,
                        ]);
                        // Insert Week By Week - START

                        $weekTototalPay = $weekBalance;
                    }
                } else if ($repaymentType == 'Days') {
                    $getDayLongTerm = $longTerm - 1;
                    $endPaymentDateConver->modify("+" . $getDayLongTerm . "month");
                    $endPayDate = $endPaymentDateConver->format('Y-m-d');

                    $start_date = new DateTime($firstPaymentDate);
                    $end_date = new DateTime($endPayDate);

                    $interval = new DateInterval('P1D');
                    $daterange = new DatePeriod($start_date, $interval, $end_date);

                    $countDays = 0;
                    foreach ($daterange as $countDayskData) {
                        $countDays++;
                    }
                    $daysPayment = $totoalPaymentMonth / $countDays;
                    $daysInterest = $totoalPaymentInterest / $countDays;
                    $daysPrincipalAm = $daysPayment - $daysInterest;
                    $daysTototalPay = $totoalPaymentMonth;

                    foreach ($daterange as $date) {
                        $daysPayDate = $date->format('Y-m-d');
                        $daysBalance = $daysTototalPay - $daysPayment;
                        $finalDaysBalance = number_format($daysBalance, 2);

                        // Insert Day By Day - START

                        $activityStmt = $db->prepare('INSERT INTO `tbl_loan_reschedule` (currentDate, paymentDate, amountToPay, principalAmount, interest, balance, status,latePenalty,LoanId)
                                        VALUES (:currentDate,:paymentDate,:amountToPay,:principalAmount,:interest,:balance, :status, :latePenalty, :LoanId) ');

                        $activityStmt->execute([
                            ':currentDate' => $curDate,
                            ':paymentDate' => $daysPayDate,
                            ':amountToPay' => $daysPayment,
                            ':principalAmount' => $daysPrincipalAm,
                            ':interest' => $daysInterest,
                            ':balance' => $finalDaysBalance,
                            ':status' => 'unpaid',
                            ':latePenalty' => '',
                            ':LoanId' => $loanIdView,
                        ]);
                        // Insert Day By Day - START

                        $daysTototalPay = $daysBalance;
                    }
                }
            } else if ($interestPer == 'Year') {


                $interestRateConvert = ($interestRate / 100) / 12;
                $calInterst = $principal * $interestRateConvert;
                $totoalPaymentInterest = $calInterst * $longTerm;
                $totoalPaymentMonth = $totoalPaymentInterest + $principal;
                $monthlyPayment = $totoalPaymentMonth / $longTerm;
                $principalMonthlyPay = $monthlyPayment - $calInterst;
                $balance = $totoalPaymentMonth - $monthlyPayment;
                $balance = number_format($balance, 2);

                if ($repaymentType == 'Months') {

                    // Insert Monthy By month - START

                    $activityStmt = $db->prepare('INSERT INTO `tbl_loan_reschedule` (currentDate, paymentDate, amountToPay, principalAmount, interest, balance, status,latePenalty,LoanId)
                                        VALUES (:currentDate,:paymentDate,:amountToPay,:principalAmount,:interest,:balance, :status, :latePenalty, :LoanId) ');

                    $activityStmt->execute([
                        ':currentDate' => $curDate,
                        ':paymentDate' => $firstPaymentDate,
                        ':amountToPay' => $monthlyPayment,
                        ':principalAmount' => $principalMonthlyPay,
                        ':interest' => $calInterst,
                        ':balance' => $balance,
                        ':status' => 'unpaid',
                        ':latePenalty' => '',
                        ':LoanId' => $loanIdView,
                    ]);
                    // Insert Monthy By month - START
                    for (
                        $i = 1;
                        $i <= $longTerm - 1;
                        $i++
                    ) {
                        $firstPaymentDateConver->modify("+1 month");
                        $monthbymonthpay = $firstPaymentDateConver->format('Y-m-d');
                        $finalBalance = $balance - $monthlyPayment;
                        $finalBalance = number_format($finalBalance, 2);

                        // Insert Monthy By month - START

                        $activityStmt = $db->prepare('INSERT INTO `tbl_loan_reschedule` (currentDate, paymentDate, amountToPay, principalAmount, interest, balance, status,latePenalty,LoanId)
                                        VALUES (:currentDate,:paymentDate,:amountToPay,:principalAmount,:interest,:balance, :status, :latePenalty, :LoanId) ');

                        $activityStmt->execute([
                            ':currentDate' => $curDate,
                            ':paymentDate' => $monthbymonthpay,
                            ':amountToPay' => $monthlyPayment,
                            ':principalAmount' => $principalMonthlyPay,
                            ':interest' => $calInterst,
                            ':balance' => $finalBalance,
                            ':status' => 'unpaid',
                            ':latePenalty' => '',
                            ':LoanId' => $loanIdView,
                        ]);
                        // Insert Monthy By month - START
                        $balance = $finalBalance;
                    }
                } else if (
                    $repaymentType == 'Weeks'
                ) {


                    $getWeekLongTerm = $longTerm - 1;
                    $endPaymentDateConver->modify("+" . $getWeekLongTerm . "month");
                    $endPayDate = $endPaymentDateConver->format('Y-m-d');

                    $start_date = new DateTime($firstPaymentDate);
                    $end_date = new DateTime($endPayDate);

                    $interval = new DateInterval('P1W');
                    $daterange = new DatePeriod($start_date, $interval, $end_date);

                    $countWeek = 0;
                    foreach ($daterange as $countWeekData) {
                        $countWeek++;
                    }
                    $weeklyPayment = $totoalPaymentMonth / $countWeek;
                    $weekInterest = $totoalPaymentInterest / $countWeek;
                    $weekPrincipalAm = $weeklyPayment - $weekInterest;
                    $weekTototalPay = $totoalPaymentMonth;
                    foreach ($daterange as $date) {
                        $weekPayDate = $date->format('Y-m-d');
                        $weekBalance = $weekTototalPay - $weeklyPayment;
                        $finalWeekBalance = number_format($weekBalance, 2);

                        // Insert Week By Week - START

                        $activityStmt = $db->prepare('INSERT INTO `tbl_loan_reschedule` (currentDate, paymentDate, amountToPay, principalAmount, interest, balance, status,latePenalty,LoanId)
                                        VALUES (:currentDate,:paymentDate,:amountToPay,:principalAmount,:interest,:balance, :status, :latePenalty, :LoanId) ');

                        $activityStmt->execute([
                            ':currentDate' => $curDate,
                            ':paymentDate' => $weekPayDate,
                            ':amountToPay' => $weeklyPayment,
                            ':principalAmount' => $weekPrincipalAm,
                            ':interest' => $weekInterest,
                            ':balance' => $finalWeekBalance,
                            ':status' => 'unpaid',
                            ':latePenalty' => '',
                            ':LoanId' => $loanIdView,
                        ]);
                        // Insert Week By Week - START


                        $weekTototalPay = $weekBalance;
                    }
                } else if (
                    $repaymentType == 'Days'
                ) {

                    $getDayLongTerm = $longTerm - 1;
                    $endPaymentDateConver->modify("+" . $getDayLongTerm . "month");
                    $endPayDate = $endPaymentDateConver->format('Y-m-d');

                    $start_date = new DateTime($firstPaymentDate);
                    $end_date = new DateTime($endPayDate);

                    $interval = new DateInterval('P1D');
                    $daterange = new DatePeriod($start_date, $interval, $end_date);

                    $countDays = 0;
                    foreach ($daterange as $countDayskData) {
                        $countDays++;
                    }
                    $daysPayment = $totoalPaymentMonth / $countDays;
                    $daysInterest = $totoalPaymentInterest / $countDays;
                    $daysPrincipalAm = $daysPayment - $daysInterest;
                    $daysTototalPay = $totoalPaymentMonth;

                    foreach ($daterange as $date) {
                        $daysPayDate = $date->format('Y-m-d');
                        $daysBalance = $daysTototalPay - $daysPayment;
                        $finalDaysBalance = number_format($daysBalance, 2);


                        // Insert Day By Day - START

                        $activityStmt = $db->prepare('INSERT INTO `tbl_loan_reschedule` (currentDate, paymentDate, amountToPay, principalAmount, interest, balance, status,latePenalty,LoanId)
                                        VALUES (:currentDate,:paymentDate,:amountToPay,:principalAmount,:interest,:balance, :status, :latePenalty, :LoanId) ');

                        $activityStmt->execute([
                            ':currentDate' => $curDate,
                            ':paymentDate' => $daysPayDate,
                            ':amountToPay' => $daysPayment,
                            ':principalAmount' => $daysPrincipalAm,
                            ':interest' => $daysInterest,
                            ':balance' => $finalDaysBalance,
                            ':status' => 'unpaid',
                            ':latePenalty' => '',
                            ':LoanId' => $loanIdView,
                        ]);
                        // Insert Day By Day - START

                        $daysTototalPay = $daysBalance;
                    }
                }
            } else {

                $interestRateConvert = ($interestRate / 100);
                $calInterst = $principal * $interestRateConvert;
                $totoalPaymentMonth = $calInterst + $principal;
                $monthlyPayment = $totoalPaymentMonth / $longTerm;
                $principalMonthlyPay = $monthlyPayment - $calInterst;
                $balance = $totoalPaymentMonth - $monthlyPayment;
                $balance = number_format($balance, 2);

                if ($repaymentType == 'Months') {

                    // Insert Monthy By month - START

                    $activityStmt = $db->prepare('INSERT INTO `tbl_loan_reschedule` (currentDate, paymentDate, amountToPay, principalAmount, interest, balance, status,latePenalty,LoanId)
                                        VALUES (:currentDate,:paymentDate,:amountToPay,:principalAmount,:interest,:balance, :status, :latePenalty, :LoanId) ');

                    $activityStmt->execute([
                        ':currentDate' => $curDate,
                        ':paymentDate' => $firstPaymentDate,
                        ':amountToPay' => $monthlyPayment,
                        ':principalAmount' => $principalMonthlyPay,
                        ':interest' => $calInterst,
                        ':balance' => $balance,
                        ':status' => 'unpaid',
                        ':latePenalty' => '',
                        ':LoanId' => $loanIdView,
                    ]);
                    // Insert Monthy By month - START

                    for (
                        $i = 1;
                        $i <= $longTerm - 1;
                        $i++
                    ) {
                        $firstPaymentDateConver->modify("+1 month");
                        $monthbymonthpay = $firstPaymentDateConver->format('Y-m-d');
                        $finalBalance = $balance - $monthlyPayment;
                        $finalBalance = number_format($finalBalance, 2);

                        // Insert Monthy By month - START

                        $activityStmt = $db->prepare('INSERT INTO `tbl_loan_reschedule` (currentDate, paymentDate, amountToPay, principalAmount, interest, balance, status,latePenalty,LoanId)
                                        VALUES (:currentDate,:paymentDate,:amountToPay,:principalAmount,:interest,:balance, :status, :latePenalty, :LoanId) ');

                        $activityStmt->execute([
                            ':currentDate' => $curDate,
                            ':paymentDate' => $monthbymonthpay,
                            ':amountToPay' => $monthlyPayment,
                            ':principalAmount' => $principalMonthlyPay,
                            ':interest' => $calInterst,
                            ':balance' => $finalBalance,
                            ':status' => 'unpaid',
                            ':latePenalty' => '',
                            ':LoanId' => $loanIdView,
                        ]);
                        // Insert Monthy By month - START

                        $balance = $finalBalance;
                    }
                } else if (
                    $repaymentType == 'Weeks'
                ) {

                    $getWeekLongTerm = $longTerm - 1;
                    $endPaymentDateConver->modify("+" . $getWeekLongTerm . "month");
                    $endPayDate = $endPaymentDateConver->format('Y-m-d');

                    $start_date = new DateTime($firstPaymentDate);
                    $end_date = new DateTime($endPayDate);

                    $interval = new DateInterval('P1W');
                    $daterange = new DatePeriod($start_date, $interval, $end_date);

                    $countWeek = 0;
                    foreach ($daterange as $countWeekData) {
                        $countWeek++;
                    }
                    $weeklyPayment = $totoalPaymentMonth / $countWeek;
                    $weekInterest = $calInterst / $countWeek;
                    $weekPrincipalAm = $weeklyPayment - $weekInterest;
                    $weekTototalPay = $totoalPaymentMonth;
                    foreach ($daterange as $date) {
                        $weekPayDate = $date->format('Y-m-d');
                        $weekBalance = $weekTototalPay - $weeklyPayment;
                        $finalWeekBalance = number_format($weekBalance, 2);

                        // Insert Week By Week - START

                        $activityStmt = $db->prepare('INSERT INTO `tbl_loan_reschedule` (currentDate, paymentDate, amountToPay, principalAmount, interest, balance, status,latePenalty,LoanId)
                                        VALUES (:currentDate,:paymentDate,:amountToPay,:principalAmount,:interest,:balance, :status, :latePenalty, :LoanId) ');

                        $activityStmt->execute([
                            ':currentDate' => $curDate,
                            ':paymentDate' => $weekPayDate,
                            ':amountToPay' => $weeklyPayment,
                            ':principalAmount' => $weekPrincipalAm,
                            ':interest' => $weekInterest,
                            ':balance' => $finalWeekBalance,
                            ':status' => 'unpaid',
                            ':latePenalty' => '',
                            ':LoanId' => $loanIdView,
                        ]);
                        // Insert Week By Week - START

                        $weekTototalPay = $weekBalance;
                    }
                } else if (
                    $repaymentType == 'Days'
                ) {

                    $getDayLongTerm = $longTerm - 1;
                    $endPaymentDateConver->modify("+" . $getDayLongTerm . "month");
                    $endPayDate = $endPaymentDateConver->format('Y-m-d');

                    $start_date = new DateTime($firstPaymentDate);
                    $end_date = new DateTime($endPayDate);

                    $interval = new DateInterval('P1D');
                    $daterange = new DatePeriod($start_date, $interval, $end_date);

                    $countDays = 0;
                    foreach ($daterange as $countDayskData) {
                        $countDays++;
                    }
                    $daysPayment = $totoalPaymentMonth / $countDays;
                    $daysInterest = $calInterst / $countDays;
                    $daysPrincipalAm = $daysPayment - $daysInterest;
                    $daysTototalPay = $totoalPaymentMonth;

                    foreach ($daterange as $date) {
                        $daysPayDate = $date->format('Y-m-d');
                        $daysBalance = $daysTototalPay - $daysPayment;
                        $finalDaysBalance = number_format($daysBalance, 2);

                        // Insert Day By Day - START

                        $activityStmt = $db->prepare('INSERT INTO `tbl_loan_reschedule` (currentDate, paymentDate, amountToPay, principalAmount, interest, balance, status,latePenalty,LoanId)
                                        VALUES (:currentDate,:paymentDate,:amountToPay,:principalAmount,:interest,:balance, :status, :latePenalty, :LoanId) ');

                        $activityStmt->execute([
                            ':currentDate' => $curDate,
                            ':paymentDate' => $daysPayDate,
                            ':amountToPay' => $daysPayment,
                            ':principalAmount' => $daysPrincipalAm,
                            ':interest' => $daysInterest,
                            ':balance' => $finalDaysBalance,
                            ':status' => 'unpaid',
                            ':latePenalty' => '',
                            ':LoanId' => $loanIdView,
                        ]);
                        // Insert Day By Day - START


                        $daysTototalPay = $daysBalance;
                    }
                }
            }

            //All Payment Data - END
            $stmt = $db->prepare('UPDATE tbl_loan SET aprovalStatus=? , approveDate=? , aprrovedBy=?, requestLoan=?, approvedusers=?, approvedReason=? where id = ?');
            $requestLoan = 2;
            $approvedusers = 2;
            $stmt->bindParam(1, $txtApprovalStatus);
            $stmt->bindParam(2, $curDate);
            $stmt->bindParam(3, $SESS_USER_ID);
            $stmt->bindParam(4, $requestLoan);
            $stmt->bindParam(5, $approvedusers);
            $stmt->bindParam(6, $txtApprovedDes);
            $stmt->bindParam(7, $loanIdView);
            $stmt->execute();
        } else {
            //All Payment Data Reduce Payment - START
            $sqlPMethod = "SELECT * FROM tbl_loan where id=$loanIdView";
            $stmt = $db->prepare($sqlPMethod);
            $stmt->execute();
            if ($row = $stmt->fetchObject()) {
                $id = $row->id;
                $principal = $row->principal;
                $interestRate = $row->interestRate;
                $interestPer = $row->interestPer;
                $firstPaymentDate = $row->firstPaymentDate;
                $repaymentType = $row->repaymentType;
                $longTerm = $row->longTerm;
            }
            $principal = floatval($principal);
            $defprincipal = floatval($principal);
            $interestRate = floatval($interestRate);
            $longTerm = intval($longTerm);
            $firstPaymentDateConver = DateTime::createFromFormat('Y-m-d', $firstPaymentDate);
            $endPaymentDateConver = DateTime::createFromFormat('Y-m-d', $firstPaymentDate);
            if ($interestPer == 'Month') {

                $interestRateConvert = $interestRate / 100;
                $calInterst = $principal * $interestRateConvert;
                $totoalPaymentInterest = $calInterst * $longTerm;
                $totoalPaymentMonth = $totoalPaymentInterest + $principal;
                $monthlyPayment = $totoalPaymentMonth / $longTerm;
                $principalMonthlyPay = $monthlyPayment - $calInterst;
                $balance = $totoalPaymentMonth - $monthlyPayment;

                if ($repaymentType == 'Months') {
                    for (
                        $i = 1;
                        $i <= $longTerm;
                        $i++
                    ) {

                        $monthbymonthpay = $firstPaymentDateConver->format('Y-m-d');
                        $calPrincipal = $defprincipal / $longTerm;
                        $interestRCal = ($interestRate / 100) * $principal;
                        $totoal = $calPrincipal + $interestRCal;
                        $pddrincipal = $principal - $calPrincipal;
                        $principal = $principal - $calPrincipal;
                        $pddrincipal = number_format($pddrincipal, 2);


                        // Insert Monthy By month - START

                        $activityStmt = $db->prepare('INSERT INTO `tbl_loan_reschedule` (currentDate, paymentDate, amountToPay, principalAmount, interest, balance, status,latePenalty,LoanId)
                                        VALUES (:currentDate,:paymentDate,:amountToPay,:principalAmount,:interest,:balance, :status, :latePenalty, :LoanId) ');

                        $activityStmt->execute([
                            ':currentDate' => $curDate,
                            ':paymentDate' => $monthbymonthpay,
                            ':amountToPay' => $totoal,
                            ':principalAmount' => $calPrincipal,
                            ':interest' => $interestRCal,
                            ':balance' => $pddrincipal,
                            ':status' => 'unpaid',
                            ':latePenalty' => '',
                            ':LoanId' => $loanIdView,
                        ]);
                        // Insert Monthy By month - START

                        $firstPaymentDateConver->modify("+1 month");
                    }
                } else if ($repaymentType == 'Weeks') {

                    $getWeekLongTerm = $longTerm - 1;
                    $endPaymentDateConver->modify("+" . $getWeekLongTerm . "month");
                    $endPayDate = $endPaymentDateConver->format('Y-m-d');

                    $start_date = new DateTime($firstPaymentDate);
                    $end_date = new DateTime($endPayDate);

                    $interval = new DateInterval('P1W');
                    $daterange = new DatePeriod($start_date, $interval, $end_date);

                    $countWeek = 0;
                    foreach ($daterange as $countWeekData) {
                        $countWeek++;
                    }

                    foreach ($daterange as $date) {
                        // Insert Week By Week - START
                        $first = $date->format('Y-m-d');
                        $calPrincipal = $defprincipal / $countWeek;
                        $interW = ($interestRate / 100);
                        $weeklyInterestRate = pow(1 + $interW, 1 / 4) - 1;
                        $weeklyInterestRatePercentage = $weeklyInterestRate * 100;
                        $interestRCal = ($weeklyInterestRatePercentage / 100) * $principal;
                        $totoal = $calPrincipal + $interestRCal;
                        $pddrincipal = $principal - $calPrincipal;
                        $principal = $principal - $calPrincipal;
                        $pddrincipal = number_format($pddrincipal, 2);


                        $activityStmt = $db->prepare('INSERT INTO `tbl_loan_reschedule` (currentDate, paymentDate, amountToPay, principalAmount, interest, balance, status,latePenalty,LoanId)
                                        VALUES (:currentDate,:paymentDate,:amountToPay,:principalAmount,:interest,:balance, :status, :latePenalty, :LoanId) ');

                        $activityStmt->execute([
                            ':currentDate' => $curDate,
                            ':paymentDate' => $first,
                            ':amountToPay' => $totoal,
                            ':principalAmount' => $calPrincipal,
                            ':interest' => $interestRCal,
                            ':balance' => $pddrincipal,
                            ':status' => 'unpaid',
                            ':latePenalty' => '',
                            ':LoanId' => $loanIdView,
                        ]);
                        // Insert Week By Week - START
                    }
                } else if ($repaymentType == 'Days') {
                    $getDayLongTerm = $longTerm - 1;
                    $endPaymentDateConver->modify("+" . $getDayLongTerm . "month");
                    $endPayDate = $endPaymentDateConver->format('Y-m-d');

                    $start_date = new DateTime($firstPaymentDate);
                    $end_date = new DateTime($endPayDate);

                    $interval = new DateInterval('P1D');
                    $daterange = new DatePeriod($start_date, $interval, $end_date);

                    $countDays = 0;
                    foreach ($daterange as $countDayskData) {
                        $countDays++;
                    }

                    foreach ($daterange as $date) {
                        $first = $date->format('Y-m-d');
                        $calPrincipal = $defprincipal / $countDays;
                        $interW = ($interestRate / 100);
                        $daysInMonth = 30;
                        $dailyInterestRate = pow(1 + $interW, 1 / $daysInMonth) - 1;
                        $dailyInterestRatePercentage = $dailyInterestRate * 100;
                        $interestRCal = ($dailyInterestRatePercentage / 100) * $principal;
                        $totoal = $calPrincipal + $interestRCal;
                        $pddrincipal = $principal - $calPrincipal;
                        $principal = $principal - $calPrincipal;
                        $pddrincipal = number_format($pddrincipal, 2);

                        // Insert Day By Day - START

                        $activityStmt = $db->prepare('INSERT INTO `tbl_loan_reschedule` (currentDate, paymentDate, amountToPay, principalAmount, interest, balance, status,latePenalty,LoanId)
                                        VALUES (:currentDate,:paymentDate,:amountToPay,:principalAmount,:interest,:balance, :status, :latePenalty, :LoanId) ');

                        $activityStmt->execute([
                            ':currentDate' => $curDate,
                            ':paymentDate' => $first,
                            ':amountToPay' => $totoal,
                            ':principalAmount' => $calPrincipal,
                            ':interest' => $interestRCal,
                            ':balance' => $pddrincipal,
                            ':status' => 'unpaid',
                            ':latePenalty' => '',
                            ':LoanId' => $loanIdView,
                        ]);
                        // Insert Day By Day - START

                        $daysTototalPay = $daysBalance;
                    }
                }
            } else if ($interestPer == 'Year') {


                $interestRateConvert = ($interestRate / 100) / 12;
                $calInterst = $principal * $interestRateConvert;
                $totoalPaymentInterest = $calInterst * $longTerm;
                $totoalPaymentMonth = $totoalPaymentInterest + $principal;
                $monthlyPayment = $totoalPaymentMonth / $longTerm;
                $principalMonthlyPay = $monthlyPayment - $calInterst;
                $balance = $totoalPaymentMonth - $monthlyPayment;


                if ($repaymentType == 'Months') {

                    for (
                        $i = 1;
                        $i <= $longTerm;
                        $i++
                    ) {

                        $monthbymonthpay = $firstPaymentDateConver->format('Y-m-d');
                        $calPrincipal = $defprincipal / $longTerm;
                        $interestRCal = ($interestRate / 100) / 12 * $principal;
                        $totoal = $calPrincipal + $interestRCal;
                        $pddrincipal = $principal - $calPrincipal;
                        $principal = $principal - $calPrincipal;
                        $pddrincipal = number_format($pddrincipal, 2);


                        // Insert Monthy By month - START

                        $activityStmt = $db->prepare('INSERT INTO `tbl_loan_reschedule` (currentDate, paymentDate, amountToPay, principalAmount, interest, balance, status,latePenalty,LoanId)
                                        VALUES (:currentDate,:paymentDate,:amountToPay,:principalAmount,:interest,:balance, :status, :latePenalty, :LoanId) ');

                        $activityStmt->execute([
                            ':currentDate' => $curDate,
                            ':paymentDate' => $monthbymonthpay,
                            ':amountToPay' => $totoal,
                            ':principalAmount' => $calPrincipal,
                            ':interest' => $interestRCal,
                            ':balance' => $pddrincipal,
                            ':status' => 'unpaid',
                            ':latePenalty' => '',
                            ':LoanId' => $loanIdView,
                        ]);
                        // Insert Monthy By month - START

                        $firstPaymentDateConver->modify("+1 month");
                    }
                } else if (
                    $repaymentType == 'Weeks'
                ) {
                    $getWeekLongTerm = $longTerm - 1;
                    $endPaymentDateConver->modify("+" . $getWeekLongTerm . "month");
                    $endPayDate = $endPaymentDateConver->format('Y-m-d');

                    $start_date = new DateTime($firstPaymentDate);
                    $end_date = new DateTime($endPayDate);

                    $interval = new DateInterval('P1W');
                    $daterange = new DatePeriod($start_date, $interval, $end_date);

                    $countWeek = 0;
                    foreach ($daterange as $countWeekData) {
                        $countWeek++;
                    }

                    foreach ($daterange as $date) {
                        // Insert Week By Week - START
                        $first = $date->format('Y-m-d');
                        $calPrincipal = $defprincipal / $countWeek;
                        $interW = ($interestRate / 100);
                        $weeklyInterestRate = pow(1 + $interW, 1 / 4) - 1;
                        $weeklyInterestRatePercentage = $weeklyInterestRate * 100;
                        $interestRCal = ($weeklyInterestRatePercentage / 100) * $principal;
                        $totoal = $calPrincipal + $interestRCal;
                        $pddrincipal = $principal - $calPrincipal;
                        $principal = $principal - $calPrincipal;
                        $pddrincipal = number_format($pddrincipal, 2);


                        $activityStmt = $db->prepare('INSERT INTO `tbl_loan_reschedule` (currentDate, paymentDate, amountToPay, principalAmount, interest, balance, status,latePenalty,LoanId)
                                        VALUES (:currentDate,:paymentDate,:amountToPay,:principalAmount,:interest,:balance, :status, :latePenalty, :LoanId) ');

                        $activityStmt->execute([
                            ':currentDate' => $curDate,
                            ':paymentDate' => $first,
                            ':amountToPay' => $totoal,
                            ':principalAmount' => $calPrincipal,
                            ':interest' => $interestRCal,
                            ':balance' => $pddrincipal,
                            ':status' => 'unpaid',
                            ':latePenalty' => '',
                            ':LoanId' => $loanIdView,
                        ]);
                        // Insert Week By Week - START
                    }
                } else if (
                    $repaymentType == 'Days'
                ) {
                    $getDayLongTerm = $longTerm - 1;
                    $endPaymentDateConver->modify("+" . $getDayLongTerm . "month");
                    $endPayDate = $endPaymentDateConver->format('Y-m-d');

                    $start_date = new DateTime($firstPaymentDate);
                    $end_date = new DateTime($endPayDate);

                    $interval = new DateInterval('P1D');
                    $daterange = new DatePeriod($start_date, $interval, $end_date);

                    $countDays = 0;
                    foreach ($daterange as $countDayskData) {
                        $countDays++;
                    }

                    foreach ($daterange as $date) {
                        $first = $date->format('Y-m-d');
                        $calPrincipal = $defprincipal / $countDays;
                        $interW = ($interestRate / 100) / 12;
                        $daysInMonth = 30;
                        $dailyInterestRate = pow(1 + $interW, 1 / $daysInMonth) - 1;
                        $dailyInterestRatePercentage = $dailyInterestRate * 100;
                        $interestRCal = ($dailyInterestRatePercentage / 100) * $principal;
                        $totoal = $calPrincipal + $interestRCal;
                        $pddrincipal = $principal - $calPrincipal;
                        $principal = $principal - $calPrincipal;
                        $pddrincipal = number_format($pddrincipal, 2);

                        // Insert Day By Day - START

                        $activityStmt = $db->prepare('INSERT INTO `tbl_loan_reschedule` (currentDate, paymentDate, amountToPay, principalAmount, interest, balance, status,latePenalty,LoanId)
                                        VALUES (:currentDate,:paymentDate,:amountToPay,:principalAmount,:interest,:balance, :status, :latePenalty, :LoanId) ');

                        $activityStmt->execute([
                            ':currentDate' => $curDate,
                            ':paymentDate' => $first,
                            ':amountToPay' => $totoal,
                            ':principalAmount' => $calPrincipal,
                            ':interest' => $interestRCal,
                            ':balance' => $pddrincipal,
                            ':status' => 'unpaid',
                            ':latePenalty' => '',
                            ':LoanId' => $loanIdView,
                        ]);
                        // Insert Day By Day - START

                        $daysTototalPay = $daysBalance;
                    }
                }
            } else {

                $interestRateConvert = ($interestRate / 100);
                $calInterst = $principal * $interestRateConvert;
                $totoalPaymentMonth = $calInterst + $principal;
                $monthlyPayment = $totoalPaymentMonth / $longTerm;
                $principalMonthlyPay = $monthlyPayment - $calInterst;
                $balance = $totoalPaymentMonth - $monthlyPayment;


                if ($repaymentType == 'Months') {
                    for (
                        $i = 1;
                        $i <= $longTerm;
                        $i++
                    ) {

                        $monthbymonthpay = $firstPaymentDateConver->format('Y-m-d');
                        $calPrincipal = $defprincipal / $longTerm;
                        $interestRCal = ($interestRate / 100) * $principal;
                        $totoal = $calPrincipal + $interestRCal;
                        $pddrincipal = $principal - $calPrincipal;
                        $principal = $principal - $calPrincipal;
                        $pddrincipal = number_format($pddrincipal, 2);


                        // Insert Monthy By month - START

                        $activityStmt = $db->prepare('INSERT INTO `tbl_loan_reschedule` (currentDate, paymentDate, amountToPay, principalAmount, interest, balance, status,latePenalty,LoanId)
                                        VALUES (:currentDate,:paymentDate,:amountToPay,:principalAmount,:interest,:balance, :status, :latePenalty, :LoanId) ');

                        $activityStmt->execute([
                            ':currentDate' => $curDate,
                            ':paymentDate' => $monthbymonthpay,
                            ':amountToPay' => $totoal,
                            ':principalAmount' => $calPrincipal,
                            ':interest' => $interestRCal,
                            ':balance' => $pddrincipal,
                            ':status' => 'unpaid',
                            ':latePenalty' => '',
                            ':LoanId' => $loanIdView,
                        ]);
                        // Insert Monthy By month - START

                        $firstPaymentDateConver->modify("+1 month");
                    }
                } else if (
                    $repaymentType == 'Weeks'
                ) {

                    $getWeekLongTerm = $longTerm - 1;
                    $endPaymentDateConver->modify("+" . $getWeekLongTerm . "month");
                    $endPayDate = $endPaymentDateConver->format('Y-m-d');

                    $start_date = new DateTime($firstPaymentDate);
                    $end_date = new DateTime($endPayDate);

                    $interval = new DateInterval('P1W');
                    $daterange = new DatePeriod($start_date, $interval, $end_date);

                    $countWeek = 0;
                    foreach ($daterange as $countWeekData) {
                        $countWeek++;
                    }
                    $weeklyPayment = $totoalPaymentMonth / $countWeek;
                    $weekInterest = $calInterst / $countWeek;
                    $weekPrincipalAm = $weeklyPayment - $weekInterest;
                    $weekTototalPay = $totoalPaymentMonth;
                    foreach ($daterange as $date) {
                        $weekPayDate = $date->format('Y-m-d');
                        $weekBalance = $weekTototalPay - $weeklyPayment;
                        $finalWeekBalance = number_format($weekBalance, 2);

                        // Insert Week By Week - START

                        $activityStmt = $db->prepare('INSERT INTO `tbl_loan_reschedule` (currentDate, paymentDate, amountToPay, principalAmount, interest, balance, status,latePenalty,LoanId)
                                        VALUES (:currentDate,:paymentDate,:amountToPay,:principalAmount,:interest,:balance, :status, :latePenalty, :LoanId) ');

                        $activityStmt->execute([
                            ':currentDate' => $curDate,
                            ':paymentDate' => $weekPayDate,
                            ':amountToPay' => $weeklyPayment,
                            ':principalAmount' => $weekPrincipalAm,
                            ':interest' => $weekInterest,
                            ':balance' => $finalWeekBalance,
                            ':status' => 'unpaid',
                            ':latePenalty' => '',
                            ':LoanId' => $loanIdView,
                        ]);
                        // Insert Week By Week - START

                        $weekTototalPay = $weekBalance;
                    }
                } else if (
                    $repaymentType == 'Days'
                ) {

                    $getDayLongTerm = $longTerm - 1;
                    $endPaymentDateConver->modify("+" . $getDayLongTerm . "month");
                    $endPayDate = $endPaymentDateConver->format('Y-m-d');

                    $start_date = new DateTime($firstPaymentDate);
                    $end_date = new DateTime($endPayDate);

                    $interval = new DateInterval('P1D');
                    $daterange = new DatePeriod($start_date, $interval, $end_date);

                    $countDays = 0;
                    foreach ($daterange as $countDayskData) {
                        $countDays++;
                    }

                    foreach ($daterange as $date) {
                        $first = $date->format('Y-m-d');
                        $calPrincipal = $defprincipal / $countDays;
                        $interW = ($interestRate / 100);
                        $daysInMonth = 30;
                        $dailyInterestRate = pow(1 + $interW, 1 / $daysInMonth) - 1;
                        $dailyInterestRatePercentage = $dailyInterestRate * 100;
                        $interestRCal = ($dailyInterestRatePercentage / 100) * $principal;
                        $totoal = $calPrincipal + $interestRCal;
                        $pddrincipal = $principal - $calPrincipal;
                        $principal = $principal - $calPrincipal;
                        $pddrincipal = number_format($pddrincipal, 2);

                        // Insert Day By Day - START

                        $activityStmt = $db->prepare('INSERT INTO `tbl_loan_reschedule` (currentDate, paymentDate, amountToPay, principalAmount, interest, balance, status,latePenalty,LoanId)
                                        VALUES (:currentDate,:paymentDate,:amountToPay,:principalAmount,:interest,:balance, :status, :latePenalty, :LoanId) ');

                        $activityStmt->execute([
                            ':currentDate' => $curDate,
                            ':paymentDate' => $first,
                            ':amountToPay' => $totoal,
                            ':principalAmount' => $calPrincipal,
                            ':interest' => $interestRCal,
                            ':balance' => $pddrincipal,
                            ':status' => 'unpaid',
                            ':latePenalty' => '',
                            ':LoanId' => $loanIdView,
                        ]);
                        // Insert Day By Day - START

                        $daysTototalPay = $daysBalance;
                    }
                }
            }

            //All Payment Data Reduce Payment - END
            $stmt = $db->prepare('UPDATE tbl_loan SET aprovalStatus=? , approveDate=? , aprrovedBy=?, requestLoan=?, approvedusers=?, approvedReason=?, chequeNo=? where id = ?');
            $requestLoan = 2;
            $approvedusers = 2;
            $stmt->bindParam(1, $txtApprovalStatus);
            $stmt->bindParam(2, $curDate);
            $stmt->bindParam(3, $SESS_USER_ID);
            $stmt->bindParam(4, $requestLoan);
            $stmt->bindParam(5, $approvedusers);
            $stmt->bindParam(6, $txtApprovedReason);
            $stmt->bindParam(7, $txtCheqeNo);
            $stmt->bindParam(8, $loanIdView);
            $stmt->execute();
        }

        $currentDate = date('Y-m-d');

        $getBalance = $db->query("SELECT `balance` FROM tbl_account WHERE id = $txtSelectAccount")->fetchColumn(0);
        $getBalance = (float)$getBalance;
        $getprincipal = $db->query("SELECT `principal` FROM tbl_loan WHERE id = $loanIdView")->fetchColumn(0);
        $getPrincipal = str_replace(',', '', $getPrincipal);
        $getprincipal = (float)$getprincipal;
        $getprincipalLast = (string)$getprincipal;

        $finalGetBalance = $getBalance - $getPrincipal;

        $finalGetBalanceLast = (string)$finalGetBalance;
    
        $db->query("UPDATE tbl_account SET balance = '$finalGetBalance' WHERE id = $txtSelectAccount");
    
        $stmtTRansferFrom = $db->prepare('INSERT INTO `tbl_transfer_history` (transferDate, account, accountStatus, reason, accountBalance, transferAmount )
        VALUES (:transferDate, :account, :accountStatus,  :reason, :accountBalance, :transferAmount)');
    
        $stmtTRansferFrom->execute([
            ':transferDate' => $currentDate,
            ':account' => $txtSelectAccount,
            ':accountStatus' => 'Debit',
            ':reason' => 'Loan - ' . $loanIdView ,
            ':accountBalance' => $finalGetBalanceLast,
            ':transferAmount' => $getprincipalLast,
        ]);
    
    }else{
        echo 1;    
    }
    } else if ($txtApprovalStatus == 'firstAproved') {
        $stmt = $db->prepare('UPDATE tbl_loan SET aprovalStatus=? , firstApprovedDate=? , firstApprovedBy=?, approvedusers=?, firstApprovedReason=? where id = ?');
        $approvedusers = 3;
        $stmt->bindParam(1, $txtApprovalStatus);
        $stmt->bindParam(2, $curDate);
        $stmt->bindParam(3, $SESS_USER_ID);
        $stmt->bindParam(4, $approvedusers);
        $stmt->bindParam(5, $txtApprovedReason);
        $stmt->bindParam(6, $loanIdView);
        $stmt->execute();
    } else if ($txtApprovalStatus == 'secondApproved') {
        $stmt = $db->prepare('UPDATE tbl_loan SET aprovalStatus=? , secondApprovedDate=? , secondApprovedBy=?, approvedusers=?, secondApprovedReason=? where id = ?');
        $approvedusers = 1;
        $stmt->bindParam(1, $txtApprovalStatus);
        $stmt->bindParam(2, $curDate);
        $stmt->bindParam(3, $SESS_USER_ID);
        $stmt->bindParam(4, $approvedusers);
        $stmt->bindParam(5, $txtApprovedReason);
        $stmt->bindParam(6, $loanIdView);
        $stmt->execute();
    }else if ($txtApprovalStatus == 'cancel') {
        $stmt = $db->prepare('UPDATE tbl_loan SET aprovalStatus=? , secondApprovedDate=? , secondApprovedBy=?, approvedusers=?, secondApprovedReason=?,  requestLoan=? where id = ?');
        $approvedusers = 5;
        $requestLoan = 2;
        $appStatus = 'cancelled';
        $stmt->bindParam(1, $appStatus);
        $stmt->bindParam(2, $curDate);
        $stmt->bindParam(3, $SESS_USER_ID);
        $stmt->bindParam(4, $approvedusers);
        $stmt->bindParam(5, $txtApprovedReason);
        $stmt->bindParam(6, $requestLoan);
        $stmt->bindParam(7, $loanIdView);
        $stmt->execute();
    }



    $activityStmt = $db->prepare('INSERT INTO `tbl_activity_log` (userName, currentDate, userEmail, userType, activity, activityPath)
                                        VALUES (:userName,:currentDate,:userEmail,:userType,:activity,:activityPath) ');

    $activityStmt->execute([
        ':userName' => $userFirstName,
        ':currentDate' => $curDate,
        ':userEmail' => $userEmail,
        ':userType' => $userType,
        ':activity' => 'Update Loan Status',
        ':activityPath' => $loanIdView

    ]);
    echo 'success';
} catch (PDOException $e) {
    echo $e->getMessage();
}

}else{
    echo 0;
}