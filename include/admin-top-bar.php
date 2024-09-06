<?php
$userId = $SESS_USER_ID;

?>

<header id="header" class="header fixed-top d-flex align-items-center">

    <!-- Logo -->
    <div class="d-flex align-items-center justify-content-between">
        <i class="bi bi-list toggle-sidebar-btn"></i>

        <a href="index.php?page=dashboard" class="navbar-brand ms-2 d-none d-lg-block font-monospace subheading-2">
            <span>ACCOUNT SYSTEM</span>
        </a>
    </div>
    <!-- End Logo -->



    <?php
    $sqlPMethod = 'SELECT * FROM tbl_loan where requestLoan = 1';
    $stmt = $db->prepare($sqlPMethod);
    $stmt->execute();

    $sqlPMethodTransfer = 'SELECT * FROM tbl_account_transfer where requestApproval = 1 OR requestApproval = 0';
    $stmtTransfer = $db->prepare($sqlPMethodTransfer);
    $stmtTransfer->execute();

    $sqlPMethodWithdraw = 'SELECT * FROM tbl_savings_withdrawal where status = 1 OR status = 2 OR status = 3';
    $stmtWithdraw = $db->prepare($sqlPMethodWithdraw);
    $stmtWithdraw->execute();

    $withdrawCount = $stmtWithdraw->rowCount();
    $withdrawCount = (int)$withdrawCount;

    $transferCount = $stmtTransfer->rowCount();
    $transferCount = (int)$transferCount;

    $loanCount = $stmt->rowCount();
    $loanCount = (int)$loanCount;

    $rowCount = $transferCount + $loanCount + $withdrawCount;
    ?>

    <!-- Navigation -->
    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
            <!-- notification -->
            <!-- Profile -->
            <li class="">
                <a href="#" data-bs-toggle="dropdown">
                    <button type="button" class="btn btn-dark btn-sm position-relative" style="margin-right: 30px;">
                        <i class="fa fa-bell" aria-hidden="true"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            <?= $rowCount ?>
                            <span class="visually-hidden">unread messages</span>
                        </span>
                    </button>
                </a>

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <?php
                    if ($rowCount == 0) {
                    ?>
                        <div class="alert alert-warning d-flex justify-content-center" role="alert">
                            Not Available
                        </div>
                    <?php
                    } else {
                    ?>
                        <li>
                            <hr class='dropdown-divider'>
                            <a class='dropdown-item d-flex justify-content-center text-uppercase'>
                                <span class="fw-bold">Request Loan</span>
                            </a>
                        </li>

                        <?php
                        try {
                            $sqlPMethod = 'SELECT * FROM tbl_loan where requestLoan = 1';
                            $stmt = $db->prepare($sqlPMethod);
                            $stmt->execute();
                            $i = 1;
                            while ($row = $stmt->fetchObject()) {
                                $id = $row->id;
                                $principal = $row->principal;
                                $principal = number_format(floatval($principal), 2, '.', '');
                                $clientId = $row->clientId;
                                $ClientFirstName = $db->query("SELECT `firstName` FROM tbl_client WHERE id = $clientId")->fetchColumn(0);
                                $ClientlastName = $db->query("SELECT `lastName` FROM tbl_client WHERE id = $clientId")->fetchColumn(0);
                                echo "<li>
                                    <hr class='dropdown-divider'>
                                    <a class='dropdown-item d-flex align-items-center' href='index.php?page=all-subpages&subpage=view-separate-loan&id=$id'>
                                         <span>Client Name :- $ClientFirstName $ClientlastName <br>Loan Amount :- $principal</span>
                                    </a>
                                </li>";
                                $i++;
                            }
                        } catch (PDOException $e) {
                            echo $e->getMessage();
                        }
                        ?>
                        <li>
                            <hr class='dropdown-divider'>
                            <a class='dropdown-item d-flex justify-content-center text-uppercase'>
                                <span class="fw-bold">Request Transfer</span>
                            </a>
                        </li>

                        <?php
                        try {
                            $sqlPMethod = 'SELECT * FROM tbl_account_transfer where  requestApproval = 1 OR requestApproval = 0';
                            $stmt = $db->prepare($sqlPMethod);
                            $stmt->execute();
                            $i = 1;
                            while ($row = $stmt->fetchObject()) {
                                $id = $row->id;
                                $toAccount = $row->toAccount;
                                $fromAccount = $row->fromAccount;
                                $transferAmount = $row->transferAmount;
                                $transferAmount = number_format($transferAmount, 2);
                                $fromAccountName = $db->query("SELECT `accountName` FROM tbl_account WHERE id = $fromAccount")->fetchColumn(0);
                                $toAccountName = $db->query("SELECT `accountName` FROM tbl_account WHERE id = $toAccount")->fetchColumn(0);
                                echo "<li>
                                    <hr class='dropdown-divider'>
                                    <a class='dropdown-item d-flex align-items-center' href='index.php?page=all-subpages&subpage=transfer-approval&id=$id'>
                                         <span>From Account :- $fromAccountName <br>To Account :- $toAccountName  <br>Amount :- $transferAmount</span>
                                    </a>
                                </li>";
                                $i++;
                            }
                        } catch (PDOException $e) {
                            echo $e->getMessage();
                        }
                        ?>

                        <li>
                            <hr class='dropdown-divider'>
                            <a class='dropdown-item d-flex justify-content-center text-uppercase'>
                                <span class="fw-bold">Request Withdrawal</span>
                            </a>
                        </li>

                        <?php
                        try {
                            $sqlPMethod = 'SELECT * FROM tbl_savings_withdrawal where status = 1 OR status = 2 OR status = 3';
                            $stmt = $db->prepare($sqlPMethod);
                            $stmt->execute();
                            $i = 1;
                            while ($row = $stmt->fetchObject()) {
                                $id = $row->id;
                                $amount = $row->amount;
                                $withdrawalId = $row->withdrawalId;
                                $amount = number_format(floatval($amount), 2, '.', '');
                                $clientId = $row->clientId;
                                $ClientFirstName = $db->query("SELECT `firstName` FROM tbl_client WHERE id = $clientId")->fetchColumn(0);
                                $ClientlastName = $db->query("SELECT `lastName` FROM tbl_client WHERE id = $clientId")->fetchColumn(0);
                                echo "<li>
                                    <hr class='dropdown-divider'>
                                    <a class='dropdown-item d-flex align-items-center' href='index.php?page=all-subpages&subpage=view-saving-withdrawal&id=$withdrawalId'>
                                         <span>Client Name :- $ClientFirstName $ClientlastName <br>Withdraw Amount :- $amount</span>
                                    </a>
                                </li>";
                                $i++;
                            }
                        } catch (PDOException $e) {
                            echo $e->getMessage();
                        }
                        ?>
                    <?php
                    }
                    ?>


                </ul>
            </li>
            <!-- End Profile -->
            <!-- <a href="#">
                <button type="button" class="btn btn-dark btn-sm position-relative" style="margin-right: 30px;">
                    <i class="fa fa-bell" aria-hidden="true"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        10
                        <span class="visually-hidden">unread messages</span>
                    </span>
                </button>
            </a> -->
            <!-- notification -->
            <!-- Profile -->
            <li class="nav-item dropdown pe-3">
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <img class="rounded-circle" src="/images/user-logo.png" alt="System Logo" />
                    <span class="d-none d-md-block dropdown-toggle ps-2 text-light"><?= $SESS_USER_NAME ?></span>
                </a>

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6><?= $SESS_USER_NAME ?></h6>
                        <span><?= $SESS_USER_TYPE ?></span>
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                        <a class="dropdown-item d-flex align-items-center" href="index.php?page=user-profile">
                            <i class="bi bi-person"></i> <span>My Profile</span>
                        </a>
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                        <a class="dropdown-item d-flex align-items-center" href="logout.php">
                            <i class="bi bi-box-arrow-right"></i> <span>Sign Out</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- End Profile -->
        </ul>
    </nav>
    <!-- End Navigation -->
</header>