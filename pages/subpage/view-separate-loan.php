<?php
$loanId = $_GET['id'];

$sqlPMethod = "SELECT * FROM tbl_loan where id = $loanId";
$stmt = $db->prepare($sqlPMethod);
$stmt->execute();
if ($row = $stmt->fetchObject()) {
    $id = $row->id;
    $clientId = $row->clientId;
    $date = $row->date;
    $principal = $row->principal;
    $loanOfficerId = $row->loanOfficerId;
    $loanPurpose = $row->loanPurpose;
    $productId = $row->productId;
    $fund = $row->fund;
    $longTerm = $row->longTerm;
    $principal = $row->principal;
    $firstPaymentDate = $row->firstPaymentDate;
    $interestRate = $row->interestRate;
    $fundSource = $row->fundSource;
    $newLoanDB = $row->newLoan;
    $aprovalStatus = $row->aprovalStatus;
    $gurantor = $row->gurantor;
    $gurantorClient = $row->gurantorClient;
    $loanNewLoan = $row->newLoan;
    $approveDate = $row->approveDate;
    $interestRateType = $row->interestRateType;
    $aprrovedBy = $row->aprrovedBy;
    $approvedusers = $row->approvedusers;
    $approvedReason = $row->approvedReason;
    $firstApprovedBy = $row->firstApprovedBy;
    $firstApprovedReason = $row->firstApprovedReason;
    $firstApprovedDate = $row->firstApprovedDate;
    $secondApprovedDate = $row->secondApprovedDate;
    $secondApprovedBy = $row->secondApprovedBy;
    $secondApprovedReason = $row->secondApprovedReason;
    $loanRandomId = $row->loanRandomId;
    if($loanRandomId == ''){
        $loanIdView = $loanId;
    }else{
        $loanIdView = $loanRandomId;
    }
    $chequeNo = $row->chequeNo;
    if ($aprovalStatus == 'pending') {
        $aprovalStatusView = "<span class='badge badge-warning'>$aprovalStatus</span>";
    } else if ($aprovalStatus == 'approved') {
        $aprovalStatusView = "<span class='badge badge-success'>$aprovalStatus</span>";
    } else if ($aprovalStatus == 'cancelled') {
        $aprovalStatusView = "<span class='badge badge-danger'>$aprovalStatus</span>";
    } else if ($aprovalStatus == 'Requested') {
        $aprovalStatusView = "<span class='badge badge-info'>$aprovalStatus</span>";
    } else if ($aprovalStatus == 'firstAproved') {
        $aprovalStatusView = "<span class='badge badge-info'>First Approved</span>";
    }

    if ($firstApprovedBy == '') {
        $firstApprovedBy = '-';
    } else {
        $firstApprovedBy = $db->query("SELECT `firstName` FROM tbl_users WHERE id = $firstApprovedBy")->fetchColumn(0);
    }
    if ($firstApprovedDate == '') {
        $firstApprovedDate = '-';
    }
    if ($firstApprovedReason == '') {
        $firstApprovedReason = '-';
    }

    if ($secondApprovedBy == '') {
        $secondApprovedBy = '-';
    } else {
        $secondApprovedBy = $db->query("SELECT `firstName` FROM tbl_users WHERE id = $secondApprovedBy")->fetchColumn(0);
    }
    if ($secondApprovedDate == '') {
        $secondApprovedDate = '-';
    }
    if ($secondApprovedReason == '') {
        $secondApprovedReason = '-';
    }

    if ($approvedReason == '') {
        $approvedReason = '-';
    }

    if ($chequeNo == '') {
        $chequeNo = '-';
    }

    if ($aprrovedBy == '') {
        $aprrovedBy = '-';
    } else {
        $aprrovedBy = $db->query("SELECT `firstName` FROM tbl_users WHERE id = $aprrovedBy")->fetchColumn(0);
    }
    if ($approveDate == '') {
        $approveDate = '-';
    }
    $clientFirstName = $db->query("SELECT `firstName` FROM tbl_client WHERE id = $clientId")->fetchColumn(0);
    $lonOfficerName = $db->query("SELECT `firstName` FROM tbl_users WHERE id = $loanOfficerId")->fetchColumn(0);
    $productName = $db->query("SELECT `productName` FROM tbl_loan_product WHERE id = $productId")->fetchColumn(0);
    if ($fundSource == '') {
        $fundResource = '-';
    } else {
        $fundResource = $db->query("SELECT `fundResource` FROM tbl_account WHERE id = $fundSource")->fetchColumn(0);
    }
}

$sqlPMethodwriteoff = "SELECT * FROM tbl_loan_reschedule where LoanId = $loanId AND status ='writeoff'";
$stmtwriteoff = $db->prepare($sqlPMethodwriteoff);
$stmtwriteoff->execute();
$countWriteOff = 0;
while ($row = $stmtwriteoff->fetchObject()) {
    $countWriteOff++;
}

$interestwiseuserName = $db->query("SELECT `userName` FROM tbl_interestwise WHERE loanId = $loanId")->fetchColumn(0);
if ($interestwiseuserName == null) {
    $interestwiseuserName = '-';
} else {
    $interestwiseuserName = $db->query("SELECT `userName` FROM tbl_interestwise WHERE loanId = $loanId")->fetchColumn(0);
}

$interestwisedate = $db->query("SELECT `date` FROM tbl_interestwise WHERE loanId = $loanId")->fetchColumn(0);
if ($interestwisedate == null) {
    $interestwisedate = '-';
} else {
    $interestwisedate = $db->query("SELECT `date` FROM tbl_interestwise WHERE loanId = $loanId")->fetchColumn(0);
}

$interestwisereason = $db->query("SELECT `reason` FROM tbl_interestwise WHERE loanId = $loanId")->fetchColumn(0);
if ($interestwisereason == null) {
    $interestwisereason = '-';
} else {
    $interestwisereason = $db->query("SELECT `reason` FROM tbl_interestwise WHERE loanId = $loanId")->fetchColumn(0);
}

$writeoffuserName = $db->query("SELECT `userName` FROM tbl_writeoff WHERE loanId = $loanId")->fetchColumn(0);
if ($writeoffuserName == null) {
    $writeoffuserName = '-';
} else {
    $writeoffuserName = $db->query("SELECT `userName` FROM tbl_writeoff WHERE loanId = $loanId")->fetchColumn(0);
}

$writeoffdate = $db->query("SELECT `date` FROM tbl_writeoff WHERE loanId = $loanId")->fetchColumn(0);
if ($writeoffdate == null) {
    $writeoffdate = '-';
} else {
    $writeoffdate = $db->query("SELECT `date` FROM tbl_writeoff WHERE loanId = $loanId")->fetchColumn(0);
}

$writeoffreason = $db->query("SELECT `reason` FROM tbl_writeoff WHERE loanId = $loanId")->fetchColumn(0);
if ($writeoffreason == null) {
    $writeoffreason = '-';
} else {
    $writeoffreason = $db->query("SELECT `reason` FROM tbl_writeoff WHERE loanId = $loanId")->fetchColumn(0);
}

$interestwiseamount = $db->query("SELECT `interestwiseamount` FROM tbl_interestwise WHERE loanId = $loanId")->fetchColumn(0);
?>
<div class="card shadow">
    <div class="card-header header-bg">
        <i class="fas fa-money-check-alt"></i> View Loan Details
    </div>
    <div class="card-body">
        <ul class="nav nav-tabs custom-ul-bg ">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#" data-status="loanDetails">Loan Details</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-status="guarantor">Guarantor</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-status="repaymentSchedule">Repayment Schedule</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-status="repayments">Repayments</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-status="loanCharge">Loan Charges</a>
            </li>
        </ul>

        <input type="text" id="txtfinalLoanId" value="<?= $loanId ?>" class="hidden form-control">

        <div class="row d-flex justify-content-end mt-3">
            <?php
            if ($countWriteOff == 0 && $approvedusers == 2) {
            ?>
                <div class="col-2 ">
                    <button class="btn btn-danger btn-sm" data-bs-toggle='modal' data-bs-target='#btnWriteOffStatusget'>Write Off</button>
                </div>
            <?php
            }

            if ($interestwiseamount == '' && $countWriteOff == 0 && $approvedusers == 2) {
            ?>
                <div class="col-2">
                    <button class="btn btn-warning btn-sm " data-bs-toggle='modal' data-bs-target='#interestwisestatus'>Interest Wise</button>
                </div>
            <?php
            }
            ?>

        </div>
        <?php
        if ($approvedusers == 0 && $SESS_USER_TYPE != 'fieldOfficer') {
        ?>
            <div class="row-2 d-flex justify-content-end mt-3">
                <button class="btn btn-primary btn-sm btnChangeApprovalModal" id='<?= $loanId ?>' data-bs-toggle='modal' data-bs-target='#changeApprovalStatus'>First Approved</button>
            </div>
        <?php
        } else if ($approvedusers == 3 && $SESS_USER_TYPE != 'fieldOfficer') {
        ?>
            <div class="row-2 d-flex justify-content-end mt-3">
                <button class="btn btn-primary btn-sm btnChangeApprovalModal" id='<?= $loanId ?>' data-bs-toggle='modal' data-bs-target='#changeApprovalStatus'>Secound Approved</button>
            </div>
        <?php
        } else if ($approvedusers == 1 && $SESS_USER_TYPE != 'fieldOfficer') {
        ?> <div class="row-2 d-flex justify-content-end mt-3">
                <button class="btn btn-primary btn-sm btnChangeApprovalModalThird" data-id='<?= $loanId ?>' data-bs-toggle='modal' data-bs-target='#changeApprovalStatusThird'>Third Approved</button>
            </div>
        <?php
        }
        ?>
        <div id="viewLoanDetails" class="row mt-5">
            <table class="table table-align-left" style="border: 1px solid black;" id="viewLoanDetailsTable">
                <tbody>
                    <tr>
                        <td class="fw-bold">Loan Id</td>
                        <td><?= $loanIdView ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Date</td>
                        <td><?= $date ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Client Name</td>
                        <td><?= $clientFirstName ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Product Name</td>
                        <td><?= $productName ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Fund</td>
                        <td><?= $fund ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Principal Amount</td>
                        <td><?= $principal ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Long Term</td>
                        <td><?= $longTerm ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Interest Rate</td>
                        <td><?= $interestRate ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Loan Officer Name</td>
                        <td><?= $lonOfficerName ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">First Approved By</td>
                        <td><?= $firstApprovedBy ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">First Approved Reason</td>
                        <td><?= $firstApprovedReason ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">First Approved Date</td>
                        <td><?= $firstApprovedDate ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Secound Approved By</td>
                        <td><?= $secondApprovedBy ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Secound Approved Reason</td>
                        <td><?= $secondApprovedReason ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Secound Approved Date</td>
                        <td><?= $secondApprovedDate ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Third Approved By</td>
                        <td><?= $aprrovedBy ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Third Approved Reason</td>
                        <td><?= $approvedReason ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Cheque No</td>
                        <td><?= $chequeNo ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Third Approved Date</td>
                        <td><?= $approveDate ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Loan Purpose</td>
                        <td><?= $loanPurpose ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">First Payment Date</td>
                        <td><?= $firstPaymentDate ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Fund Source</td>
                        <td><?= $fundResource ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Interest Type</td>
                        <td><?= $interestRateType ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Interest wise Officer</td>
                        <td><?= $interestwiseuserName ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Interest wise Date</td>
                        <td><?= $interestwisedate ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Interest wise Reason</td>
                        <td><?= $interestwisereason ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Write off officer</td>
                        <td><?= $writeoffuserName ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Write off date</td>
                        <td><?= $writeoffdate ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Write off reason</td>
                        <td><?= $writeoffreason ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Status</td>
                        <td><?= $aprovalStatusView ?></td>
                    </tr>

                </tbody>
            </table>
        </div>

        <div class="row hidden mt-5" id="viewGurantos">
            <div class="row-2 d-flex justify-content-end">
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addOtherGurantorsView">Add Guarantor</button>
            </div>
            <div class="row mt-3">
                <table class="table table-striped table-align-left" id="viewGuarantors">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>NIC Number</th>
                            <th>Address</th>
                            <th>Phone Number</th>
                            <th>monthlySalary</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        try {
                            if ($gurantor == 'Gurantors from others') {
                                $sqlPMethod = 'SELECT * FROM tbl_gurantors';
                                $stmt = $db->prepare($sqlPMethod);
                                $stmt->execute();
                                $i = 1;
                                while ($row = $stmt->fetchObject()) {
                                    $id = $row->id;
                                    $name = $row->name;
                                    $nicNumber = $row->nicNumber;
                                    $address = $row->address;
                                    $phone = $row->phone;
                                    $monthlySalary = $row->monthlySalary;
                                    $dbClientId = $row->clientId;
                                    $dbProductId = $row->productId;
                                    $dbNewLoan = $row->newLoan;
                                    if ($dbClientId == $clientId && $dbProductId == $productId && $dbNewLoan == $loanNewLoan) {
                                        echo "<tr>";
                                        echo "<td>$i</td>";
                                        echo "<td>$name</td>";
                                        echo "<td>$nicNumber</td>";
                                        echo "<td>$address</td>";
                                        echo "<td>$phone</td>";
                                        echo "<td>$monthlySalary</td>";
                                        echo "</tr>";
                                        $i++;
                                    }
                                }
                            } else if ($gurantor == 'Gurantors from client') {
                                $i = 1;
                                $gurantorClient = explode(",", $gurantorClient);

                                // Loop through the array and print each element
                                foreach ($gurantorClient as $element) {
                                    $clientFirstName = $db->query("SELECT `firstName` FROM tbl_client WHERE id = $element")->fetchColumn(0);
                                    $nicNumber = $db->query("SELECT `nicNumber` FROM tbl_client WHERE id = $element")->fetchColumn(0);
                                    $phoneNumber = $db->query("SELECT `phoneNumber` FROM tbl_client WHERE id = $element")->fetchColumn(0);
                                    echo "<tr>";
                                    echo "<td>$i</td>";
                                    echo "<td>$clientFirstName</td>";
                                    echo "<td>$nicNumber</td>";
                                    echo "<td>-</td>";
                                    echo "<td>$phoneNumber</td>";
                                    echo "<td>-</td>";
                                    echo "</tr>";
                                    $i++;
                                }
                            } else {
                            }
                        } catch (PDOException $e) {
                            echo $e->getMessage();
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row mt-5 hidden" id="rePaymentScheduleView">
            <div class="row mt-3">
                <table class="table table-striped table-align-left" id="viewRepaymentTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Amount to Pay</th>
                            <th>Principal Amount</th>
                            <th>Interest</th>
                            <th>Balance</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        try {
                            $sqlPMethod = "SELECT * FROM tbl_loan_reschedule where LoanId = '$loanId' ";
                            $stmt = $db->prepare($sqlPMethod);
                            $stmt->execute();
                            $i = 1;
                            $calIntere = 0;
                            $calAmount = 0;
                            $calPaid = 0;
                            $calUnPaid = 0;
                            $calwriteoff = 0;
                            while ($row = $stmt->fetchObject()) {

                                $id = $row->id;
                                $paymentDate = $row->paymentDate;
                                $amountToPay = $row->amountToPay;
                                $principalAmount = $row->principalAmount;
                                $interest = $row->interest;
                                $balance = $row->balance;
                                $status = $row->status;
                                $calInterest = (float)$interest;
                                $calIntere = $calInterest + $calIntere;

                                $calAmounttoPay = (float)$amountToPay;
                                $calAmount = $calAmounttoPay + $calAmount;
                                // $balance = number_format($balance, 2);
                                $amountToPay = number_format($amountToPay, 2);
                                $principalAmount = number_format($principalAmount, 2);
                                $interest = number_format($interest, 2);
                                if ($status == 'unpaid') {
                                    $aprovalStatusView = "<span class='badge badge-warning'>$status</span>";
                                    $calUnpaidAm = (float)$calAmounttoPay;
                                    $calUnPaid = $calUnpaidAm + $calUnPaid;
                                } else if ($status == 'paid') {
                                    $aprovalStatusView = "<span class='badge badge-success'>$status</span>";
                                    $calpaidAm = (float)$calAmounttoPay;
                                    $calPaid = $calpaidAm + $calPaid;
                                } else if ($status == 'due') {
                                    $aprovalStatusView = "<span class='badge badge-danger'>$status</span>";
                                } else if ($status == 'writeoff') {
                                    $aprovalStatusView = "<span class='badge badge-danger'>$status</span>";
                                    $calwriteoffAm = (float)$calAmounttoPay;
                                    $calwriteoff = $calwriteoffAm + $calwriteoff;
                                }
                                echo "<tr>";
                                echo "<td>$i</td>";
                                echo "<td>$paymentDate</td>";
                                echo "<td>$amountToPay</td>";
                                echo "<td>$principalAmount</td>";
                                echo "<td>$interest</td>";
                                echo "<td>$balance</td>";
                                echo "<td>$aprovalStatusView</td>";
                                echo "</tr>";
                                $i++;
                            }
                        } catch (PDOException $e) {
                            echo $e->getMessage();
                        }
                        $calIntere = number_format($calIntere, 2);
                        $calAmount = number_format($calAmount, 2);
                        $calPaid = number_format($calPaid, 2);
                        $calUnPaid = number_format($calUnPaid, 2);
                        $calwriteoff = number_format($calwriteoff, 2);
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="row mt-5">
                <h4 class="fw-bold" style="text-align: center;">View Details</h4>
            </div>
            <div class="row mt-3">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <label for="" class="fw-bold">Total Interest Amount</label>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <p>Rs. <?= $calIntere ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <label for="" class="fw-bold">Total Loan Amount</label>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <p>Rs. <?= $calAmount ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <label for="" class="fw-bold">Total Paid Amount</label>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <p>Rs. <?= $calPaid ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <label for="" class="fw-bold">Total Un-Paid Amount</label>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <p>Rs. <?= $calUnPaid ?></p>
                            </div>
                        </div>
                    </div>
                    <?php
                    if ($calUnPaid == 0.00) {
                    ?>
                        <div class="col-md-6 col-sm-12">
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <label for="" class="fw-bold">Total write Off Amount</label>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <p>Rs. <?= $calwriteoff ?></p>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>

                    <?php
                    if ($interestwiseamount != '') {
                        $interestwiseamount = number_format($interestwiseamount, 2);
                    ?>
                        <div class="col-md-6 col-sm-12">
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <label for="" class="fw-bold">Total interest wise Amount</label>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <p>Rs. <?= $interestwiseamount ?></p>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
        $repaymentLink = "index.php?page=all-subpages&subpage=add-repayment&loanId=$loanId";
        ?>
        <div class="row mt-5 hidden" id="rePaymentView">
            <div class="row-2 d-flex justify-content-end">
                <a href="<?= $repaymentLink ?>">
                    <div class="col">
                        <button class="btn btn-primary">Add Payment</button>
                    </div>
                </a>

            </div>
            <div class="row mt-3">
                <table class="table table-striped table-align-left" id="viewpaymentTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Loan Id</th>
                            <th>Payment Date</th>
                            <th>Principal Amount</th>
                            <th>Interest</th>
                            <th>Total Amount</th>
                            <th>Payment Amount</th>
                            <th>Officer</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        try {
                            $sqlPMethod = "SELECT * FROM tbl_loan_repayment where loanId = $loanId";
                            $stmt = $db->prepare($sqlPMethod);
                            $stmt->execute();
                            $i = 1;
                            while ($row = $stmt->fetchObject()) {
                                $loanId = $row->loanId;
                                $id = $row->id;
                                $paymentDate = $row->paymentDate;
                                $monthlyPrincipalAmount = $row->monthlyPrincipalAmount;
                                $monthlyInterest = $row->monthlyInterest;
                                $monthlyTotalPayment = $row->monthlyTotalPayment;
                                $repaymentOfficer = $row->repaymentOfficer;
                                $paymentAmount = $row->paymentAmount;
                                if ($paymentAmount == '') {
                                    $paymentAmount = '-';
                                }
                                $firstName = $db->query("SELECT `firstName` FROM tbl_users WHERE id = $repaymentOfficer")->fetchColumn(0);
                                $lastName = $db->query("SELECT `lastName` FROM tbl_users WHERE id = $repaymentOfficer")->fetchColumn(0);
                                $fullName = $firstName . " " . $lastName;
                                echo "<tr>";
                                echo "<td>$i</td>";
                                echo "<td>$loanId</td>";
                                echo "<td>$paymentDate</td>";
                                echo "<td>$monthlyPrincipalAmount</td>";
                                echo "<td>$monthlyInterest</td>";
                                echo "<td>$monthlyTotalPayment</td>";
                                echo "<td>$paymentAmount</td>";
                                echo "<td>$fullName</td>";
                                echo "<td>
                            <a href='index.php?page=all-subpages&subpage=view-repayment-report&id=$id'>
                            <button class='btn btn-success btn-sm'>View</button>
                            </a></td>";
                                echo "</tr>";
                                $i++;
                            }
                        } catch (PDOException $e) {
                            echo $e->getMessage();
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row mt-5 hidden" id="loanChargesView">
            <div class="row mt-3">
                <table class="table table-striped table-align-left" id="viewLoanChargeTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        try {
                            $sqlPMethod = "SELECT * FROM tbl_add_charges where newLoan = '$newLoanDB' ";
                            $stmt = $db->prepare($sqlPMethod);
                            $stmt->execute();
                            $i = 1;
                            while ($row = $stmt->fetchObject()) {
                                $id = $row->id;
                                $loanChargeId = $row->loanChargeId;
                                $chargeName = $db->query("SELECT `chargeName` FROM tbl_loan_charge WHERE id = $loanChargeId")->fetchColumn(0);
                                $chargeType = $db->query("SELECT `chargeType` FROM tbl_loan_charge WHERE id = $loanChargeId")->fetchColumn(0);
                                $chargeTypeDB = $db->query("SELECT `chargeType` FROM tbl_charge WHERE id = $loanChargeId")->fetchColumn(0);
                                $amount = $db->query("SELECT `amount` FROM tbl_loan_charge WHERE id = $loanChargeId")->fetchColumn(0);
                                $active = $db->query("SELECT `active` FROM tbl_loan_charge WHERE id = $loanChargeId")->fetchColumn(0);
                                if ($active == 'Yes') {
                                    $activeView = "<span class='badge badge-success'>$active</span>";
                                } else {
                                    $activeView = "<span class='badge badge-danger'>$active</span>";
                                }
                                echo "<tr>";
                                echo "<td>$i</td>";
                                echo "<td>$chargeName</td>";
                                echo "<td>$chargeTypeDB</td>";
                                echo "<td>$amount</td>";
                                echo "<td>$activeView</td>";
                                echo "</tr>";
                                $i++;
                            }
                        } catch (PDOException $e) {
                            echo $e->getMessage();
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>



<!-- Add change approval Modal -->
<div class="modal fade" id="changeApprovalStatus" tabindex="-1" aria-labelledby="changeApprovalStatusLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changeApprovalStatusLabel"><i class="fa fa-user-plus" aria-hidden="true"></i>
                    Change Approval Status </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control hidden" id="loanIdView">
                <div class="row mt-3">
                    <div class="col">
                        Status
                    </div>
                    <div class="col">
                        <select id="txtApprovalStatus" class="form-control">
                            <?php
                            if ($approvedusers == 0 && $SESS_USER_TYPE != 'fieldOfficer') {
                            ?>
                                <option value="firstAproved">First Approved</option>
                                <option value="cancel">Cancel</option>
                            <?php
                            } else if ($approvedusers == 1 && $SESS_USER_TYPE != 'fieldOfficer') {
                            ?>
                                <option value="approved">Third Approved</option>
                                <option value="cancel">Cancel</option>
                            <?php
                            } else if ($approvedusers == 3 && $SESS_USER_TYPE != 'fieldOfficer') {
                            ?>
                                <option value="secondApproved">Secound Approved</option>
                                <option value="cancel">Cancel</option>
                            <?php
                            }
                            ?>

                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        Reason
                    </div>
                    <div class="col">
                        <textarea name="" id="txtApprovedReason" class="form-control"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="modalClose">Close</button>
                <button type="button" class="btn btn-primary" id="btnChangeApprovalStatus">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Add change approval Modal third -->
<div class="modal fade" id="changeApprovalStatusThird" tabindex="-1" aria-labelledby="changeApprovalStatusThirdLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changeApprovalStatusThirdLabel"><i class="fa fa-user-plus" aria-hidden="true"></i>
                    Change Approval Status </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control hidden" id="loanIdViewThird">
                <div class="row mt-3">
                    <div class="col">
                        Status
                    </div>
                    <div class="col">
                        <select id="txtApprovalStatusGet" class="form-control">
                            <?php
                            if ($approvedusers == 0 && $SESS_USER_TYPE != 'fieldOfficer') {
                            ?>
                                <option value="firstAproved">First Approved</option>
                                <option value="cancel">Cancel</option>
                            <?php
                            } else if ($approvedusers == 1 && $SESS_USER_TYPE != 'fieldOfficer') {
                            ?>
                                <option value="approved">Third Approved</option>
                                <option value="cancel">Cancel</option>
                            <?php
                            } else if ($approvedusers == 3 && $SESS_USER_TYPE != 'fieldOfficer') {
                            ?>
                                <option value="secondApproved">Secound Approved</option>
                                <option value="cancel">Cancel</option>
                            <?php
                            }
                            ?>

                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        Cheque No
                    </div>
                    <div class="col">
                        <input type="text" id="txtCheqeNo" class="form-control">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        Select Account
                    </div>
                    <div class="col">
                        <select id="txtSelectAccount" class="form-control">
                            <?php
                                $sqlPMethod = "SELECT * FROM tbl_account ";
                                $stmt = $db->prepare($sqlPMethod);
                                $stmt->execute();
                                while ($row = $stmt->fetchObject()) {
                                    $id = $row->id;
                                    $accountName = $row->accountName;
                                    $balance = $row->balance;
                                    $balance = number_format($balance, 2);

                                    echo "<option value='$id'>$accountName ($balance)</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        Description
                    </div>
                    <div class="col">
                        <textarea  id="txtApprovedDes" class="form-control"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="modalClose">Close</button>
                <button type="button" class="btn btn-primary" id="btnChangeApprovalStatusThird">Save</button>
            </div>
        </div>
    </div>
</div>


<!-- Add other gurantos Modal -->
<div class="modal fade" id="addOtherGurantorsView" tabindex="-1" aria-labelledby="addOtherGurantorsViewLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addOtherGurantorsViewLabel"><i class="fa fa-user-plus" aria-hidden="true"></i>
                    Gurantors from others </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mt-3">
                    <div class="col">
                        Name
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" id="txtName">
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col">
                        NIC Number
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" id="txtNicNumber">
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col">
                        Address
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" id="txtAddress">
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col">
                        Phone Number
                    </div>
                    <div class="col">
                        <input type="number" class="form-control" id="txtPhoneNumber">
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col">
                        Monthly Salary
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" id="txtMonthlySalary">
                    </div>
                </div>


                <div class="row mt-3">
                    <div class="col">
                        Other Details
                    </div>
                    <div class="col">
                        <textarea id="txtOtherDetails" class="form-control"></textarea>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="modalClose">Close</button>
                <button type="button" class="btn btn-primary" id="btnAddOtherGurantosNew" data-loanId="<?= $loanId ?>" data-clientId="<?= $clientId ?>" data-productId="<?= $productId ?>">Save</button>
            </div>
        </div>
    </div>
</div>


<!-- Add interest wise Modal -->
<div class="modal fade" id="interestwisestatus" tabindex="-1" aria-labelledby="interestwisestatusLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="interestwisestatusLabel"><i class="fa fa-user-plus" aria-hidden="true"></i>
                    Interest wise </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control hidden" id="loanIdView">
                <div class="row mt-3">
                    <div class="col">
                        Reason
                    </div>
                    <div class="col">
                        <textarea name="" id="txtInterestWiseReason" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="modalClose">Close</button>
                    <button type="button" class="btn btn-primary" id="btnInterestWise">Save</button>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Add write off Modal -->
<div class="modal fade" id="btnWriteOffStatusget" tabindex="-1" aria-labelledby="btnWriteOffStatusLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="btnWriteOffStatusLabel"><i class="fa fa-user-plus" aria-hidden="true"></i>
                    write off </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mt-3">
                    <div class="col">
                        Reason
                    </div>
                    <div class="col">
                        <textarea name="" id="writeoffReason" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="modalClose">Close</button>
                    <button type="button" class="btn btn-primary" id="btnWriteOff">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom JS -->
<script src='../../js/custom/loan-settings.js?v=<?= $cashClear ?>'></script>
<!-- Custom JS -->