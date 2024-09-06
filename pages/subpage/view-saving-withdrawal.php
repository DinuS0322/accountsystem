<?php
$withdrawalId = $_GET['id'];
    $sqlPMethod = "SELECT * FROM tbl_savings_withdrawal where withdrawalId = $withdrawalId";
    $stmt = $db->prepare($sqlPMethod);
    $stmt->execute();
    $i = 1;
    if ($row = $stmt->fetchObject()) {
        $date = $row->date;
        $date = date('d-m-Y', strtotime($date));
        $withdrawalId = $row->withdrawalId;
        $clientId = $row->clientId;
        $savingId = $row->savingId;
        $amount = $row->amount;
        $status = $row->status;
        $getStatus = $row->status;
        $withdrawalreason = $row->reason;
        $requestOfficerId = $row->requestOfficerId;
        $requestDate = $row->requestDate;
        $firstApprovalOfficerId = $row->firstApprovalOfficerId;
        $firstreason =$row->firstreason;
        $firstApprovalDate = $row->firstApprovalDate;
        $secondApprovalOfficerId = $row->secondApprovalOfficerId;
        $secondReason = $row->secondReason;
        $secondApprovalDate = $row->secondApprovalDate;
        $thirdApprovalOfficerId = $row->thirdApprovalOfficerId;
        $thridReason = $row->thridReason;
        $thirdApprovalDate = $row->thirdApprovalDate;
        $chequeNo = $row->chequeNo;
        $accountId = $row->accountId;
        $cancelDate = $row->cancelDate;
        $cancelOfficerId = $row->cancelOfficerId;
        $cancelreason = $row->cancelreason;
        if($firstreason == ''){
            $firstreason = '-';
        }
        if($cancelreason == ''){
            $cancelreason = '-';
        }
        if($secondReason == ''){
            $secondReason = '-';
        }
        if($thridReason == ''){
            $thridReason = '-';
        }
        if($chequeNo == ''){
            $chequeNo = '-';
        }
        if($accountId == ''){
            $accountName = '-';
        }else{
            $accountName = $db->query("SELECT `accountName` FROM tbl_account WHERE id = $accountId")->fetchColumn(0);
        }
        if($cancelOfficerId == ''){
            $cancelOfficerName = '-';
        }else{
            $cancelOfficerName = $db->query("SELECT `firstName` FROM tbl_users WHERE id = $cancelOfficerId")->fetchColumn(0);
        }
        if($thirdApprovalOfficerId == ''){
            $thirdApprovalOfficerName = '-';
        }else{
            $thirdApprovalOfficerName = $db->query("SELECT `firstName` FROM tbl_users WHERE id = $thirdApprovalOfficerId")->fetchColumn(0);
        }
        if($secondApprovalOfficerId == ''){
            $secondApprovalOfficerName = '-';
        }else{
            $secondApprovalOfficerName = $db->query("SELECT `firstName` FROM tbl_users WHERE id = $secondApprovalOfficerId")->fetchColumn(0);
        }
        if($firstApprovalOfficerId == ''){
            $firstApprovalOfficerName = '-';
        }else{
            $firstApprovalOfficerName = $db->query("SELECT `firstName` FROM tbl_users WHERE id = $firstApprovalOfficerId")->fetchColumn(0);
        }
        if($thirdApprovalDate == ''){
            $thirdApprovalDate = '-';
        }else{
            $thirdApprovalDate = date('d-m-Y', strtotime($thirdApprovalDate));
        }
        if($cancelDate == ''){
            $cancelDate = '-';
        }else{
            $cancelDate = date('d-m-Y', strtotime($cancelDate));
        }
        if($secondApprovalDate == ''){
            $secondApprovalDate = '-';
        }else{
            $secondApprovalDate = date('d-m-Y', strtotime($secondApprovalDate));
        }
        if($requestDate == ''){
            $requestDate = '-';
        }else{
            $requestDate = date('d-m-Y', strtotime($requestDate));
        }
        if($firstApprovalDate == ''){
            $firstApprovalDate = '-';
        }else{
            $firstApprovalDate = date('d-m-Y', strtotime($firstApprovalDate));
        }
        if($requestOfficerId == ''){
            $requestOfficerName = '-';
        }else{
            $requestOfficerName = $db->query("SELECT `firstName` FROM tbl_users WHERE id = $requestOfficerId")->fetchColumn(0);
        }
        $amount = number_format($amount, 2);
        $firstName = $db->query("SELECT `firstName` FROM tbl_client WHERE id = $clientId")->fetchColumn(0);
        $personalName = $db->query("SELECT `personalName` FROM tbl_savings WHERE savingId = $savingId")->fetchColumn(0);
        $childrenName = $db->query("SELECT `childrenName` FROM tbl_savings WHERE savingId = $savingId")->fetchColumn(0);
        if($personalName == ''){
            $savingAccount = $childrenName;
        }else{
            $savingAccount = $personalName;
        }

        if($status == 0){
            $status = '<span class="badge bg-warning">Pending</span>';
        }else if($status == 1){
            $status = '<span class="badge bg-primary">Requested</span>';
        }else if($status == 2){
            $status = '<span class="badge bg-primary">First Approved</span>';
        }else if($status == 3){
            $status = '<span class="badge bg-primary">Second Approved</span>';
        }else if($status == 4){
            $status = '<span class="badge bg-success">Completed</span>';
        }else if($status == 5){
            $status = '<span class="badge bg-danger">Cancelled</span>';
        }
    }
?>
<div class="card shadow">
    <div class="card-header header-bg">
        <i class="fas fa-money-check-alt"></i> View withdrawal Details
    </div>
    <div class="card-body">
    <div class="row mt-3">
    <?php
        if ($getStatus == 1 && $SESS_USER_TYPE != 'fieldOfficer') {
        ?>
            <div class="row-2 d-flex justify-content-end mt-3">
                <button class="btn btn-primary btn-sm btnChangeApprovalModal" id='<?= $withdrawalId ?>' data-bs-toggle='modal' data-bs-target='#changeApprovalStatus'>First Approved</button>
            </div>
        <?php
        } else if ($getStatus == 2 && $SESS_USER_TYPE != 'fieldOfficer') {
        ?>
            <div class="row-2 d-flex justify-content-end mt-3">
                <button class="btn btn-primary btn-sm btnChangeApprovalModal" id='<?= $withdrawalId ?>' data-bs-toggle='modal' data-bs-target='#changeApprovalStatus'>Secound Approved</button>
            </div>
        <?php
        } else if ($getStatus == 3 && $SESS_USER_TYPE != 'fieldOfficer') {
        ?> <div class="row-2 d-flex justify-content-end mt-3">
                <button class="btn btn-primary btn-sm btnChangeApprovalModalThird" data-id='<?= $withdrawalId ?>' data-bs-toggle='modal' data-bs-target='#changeApprovalStatusThird'>Third Approved</button>
            </div>
        <?php
        }
        ?>
    </div>
    <div id="viewLoanDetails" class="row mt-5">
            <table class="table table-align-left" style="border: 1px solid black;" id="viewLoanDetailsTable">
                <tbody>
                    <tr>
                        <td class="fw-bold">Withdrawal Id</td>
                        <td><?= $withdrawalId ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Create Date</td>
                        <td><?= $date ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Member Name</td>
                        <td><?= $firstName ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Saving Account Name</td>
                        <td><?= $savingAccount ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Withdrawal Amount</td>
                        <td><?= $amount ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Withdrawal Reason</td>
                        <td><?= $withdrawalreason ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Request Officer</td>
                        <td><?= $requestOfficerName ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Request Date</td>
                        <td><?= $requestDate ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">First Approved By</td>
                        <td><?= $firstApprovalOfficerName ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">First Approved Reason</td>
                        <td><?= $firstreason ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">First Approved Date</td>
                        <td><?= $firstApprovalDate ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Second Approved By</td>
                        <td><?= $secondApprovalOfficerName ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Second Approved Reason</td>
                        <td><?= $secondReason ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Second Approved Date</td>
                        <td><?= $secondApprovalDate ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Third Approved By</td>
                        <td><?= $thirdApprovalOfficerName ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Third Approved Reason</td>
                        <td><?= $thridReason ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Third Approved Date</td>
                        <td><?= $thirdApprovalDate ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Cheque No</td>
                        <td><?= $chequeNo ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Account Name</td>
                        <td><?= $accountName ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Cancelled By</td>
                        <td><?= $cancelOfficerName ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Cancelled Date</td>
                        <td><?= $cancelDate ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Cancelled Reason</td>
                        <td><?= $cancelreason ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Status</td>
                        <td><?= $status ?></td>
                    </tr>
                </tbody>
            </table>
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
                <input type="text" class="form-control hidden" id="withdrawalIdView">
                <div class="row mt-3">
                    <div class="col">
                        Status
                    </div>
                    <div class="col">
                        <select id="txtApprovalStatus" class="form-control">
                            <?php
                            if ($getStatus == 1 && $SESS_USER_TYPE != 'fieldOfficer') {
                            ?>
                                <option value="firstAproved">First Approved</option>
                                <option value="cancel">Cancel</option>
                            <?php
                            } else if ($getStatus == 3 && $SESS_USER_TYPE != 'fieldOfficer') {
                            ?>
                                <option value="approved">Third Approved</option>
                                <option value="cancel">Cancel</option>
                            <?php
                            } else if ($getStatus == 2 && $SESS_USER_TYPE != 'fieldOfficer') {
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
                <input type="text" class="form-control hidden" id="withdrawalIdViewThird">
                <div class="row mt-3">
                    <div class="col">
                        Status
                    </div>
                    <div class="col">
                        <select id="txtApprovalStatusGet" class="form-control">
                            <?php
                            if ($getStatus == 1 && $SESS_USER_TYPE != 'fieldOfficer') {
                            ?>
                                <option value="firstAproved">First Approved</option>
                                <option value="cancel">Cancel</option>
                            <?php
                            } else if ($getStatus == 3 && $SESS_USER_TYPE != 'fieldOfficer') {
                            ?>
                                <option value="approved">Third Approved</option>
                                <option value="cancel">Cancel</option>
                            <?php
                            } else if ($getStatus == 2 && $SESS_USER_TYPE != 'fieldOfficer') {
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


<!-- Custom JS -->
<script src='../../js/custom/savings-withdrawal.js?v=<?= $cashClear ?>'></script>
<!-- Custom JS -->