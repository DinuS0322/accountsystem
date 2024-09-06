
<?php
$id = $_GET['id'];

$sqlPMethod = "SELECT * FROM tbl_account_transfer where id = $id";
$stmt = $db->prepare($sqlPMethod);
$stmt->execute();
if ($row = $stmt->fetchObject()) {
    $id = $row->id;
    $transferDate = $row->transferDate;
    $fromAccount = $row->fromAccount;
    $toAccount = $row->toAccount;
    $transferAmount = $row->transferAmount;
    $reason = $row->reason;
    $firstApprovalBy = $row->firstApprovalBy;
    $firstApprovalDate = $row->firstApprovalDate;
    $secoundApprovalBy = $row->secoundApprovalBy;
    $secoundApprovalDate = $row->secoundApprovalDate;
    $requestApproval = $row->requestApproval;
    $transferNote = $row->transferNote;
}

if ($requestApproval == 0) {
    $requestStatus = '<span class="badge badge-warning">Pending</span>';
} else if ($requestApproval == 1) {
    $requestStatus = '<span class="badge badge-primary">First Approved</span>';
} else if ($requestApproval == 2) {
    $requestStatus = '<span class="badge badge-success">Transferred</span>';
}

if($firstApprovalBy == ""){
    $firstApprovalBy = '-';
}
if($firstApprovalDate == ""){
    $firstApprovalDate = '-';
}
if($secoundApprovalBy == ""){
    $secoundApprovalBy = '-';
}
if($secoundApprovalDate == ""){
    $secoundApprovalDate = '-';
}
$transferAmount = number_format($transferAmount, 2);
$fromAccountName = $db->query("SELECT `accountName` FROM tbl_account WHERE id = $fromAccount")->fetchColumn(0);
$balance = $db->query("SELECT `balance` FROM tbl_account WHERE id = $fromAccount")->fetchColumn(0);
$toAccountName = $db->query("SELECT `accountName` FROM tbl_account WHERE id = $toAccount")->fetchColumn(0);

?>

<div class="card shadow">
    <div class="card-header header-bg">
        <i class="fa fa-users"></i> Balance Transfer
    </div>
    <div class="card-body">
        <div class="row-2 d-flex mt-3 justify-content-end">
            <?php
            if ($requestApproval == 0) {
            ?>
            <button class="btn btn-primary btn-sm btnFirstApproval" data-id="<?= $id ?>" balance="<?= $balance ?>" transferAmount="<?= $transferAmount ?>">First Approved</button>
            <?php
            } else if ($requestApproval == 1) {
            ?>
             <button class="btn btn-primary btn-sm btnSecondApproval" data-id="<?= $id ?>" balance="<?= $balance ?>" transferAmount="<?= $transferAmount ?>">Second Approved</button>
            <?php
            }
            ?>
        </div>
        <div class="row">
        <div id="viewLoanDetails" class="row mt-5">
            <table class="table table-align-left" style="border: 1px solid black;" id="viewLoanDetailsTable">
                <tbody>
                    <tr>
                        <td class="fw-bold">Transfer Id</td>
                        <td><?= $id ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Transfer Date</td>
                        <td><?= $transferDate ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Available Balance</td>
                        <td><?= $balance ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">From Account</td>
                        <td><?= $fromAccountName ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">To Account</td>
                        <td><?= $toAccountName ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Transfer Amount</td>
                        <td><?= $transferAmount ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Transfer Reason</td>
                        <td><?= $reason ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">First approved By </td>
                        <td><?= $firstApprovalBy ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">First approved Date </td>
                        <td><?= $firstApprovalDate ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Second approved By </td>
                        <td><?= $secoundApprovalBy ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Second approved Date </td>
                        <td><?= $secoundApprovalDate ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Transfer Note </td>
                        <td><?= $transferNote ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Status </td>
                        <td><?= $requestStatus ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Custom JS -->
<script src='../../js/custom/account-settings.js?v=<?= $cashClear ?>'></script>
<!-- Custom JS -->