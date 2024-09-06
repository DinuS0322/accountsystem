<?php
if ($SESS_USER_TYPE != 'fieldOfficer') {
    $hidden = '';
} else {
    $hidden = 'hidden';
}
?>

<div class="card shadow">
    <div class="card-header header-bg">
        <i class="fa fa-users"></i> View Clients Details
    </div>
    <div class="card-body">
        <div class="row-6  d-flex justify-content-end mt-3">
            <div class="btn-group" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-primary active" id="clientBasic">Personal Details</button>
                <button type="button" class="btn btn-primary" id="clientLoanDetails">Loan Details</button>
                <button type="button" class="btn btn-primary" id="clientSavingsDetails">Savings Details</button>
                <button type="button" class="btn btn-primary" id="clientTransectionDetails">Transection Details</button>
                <button type="button" class="btn btn-primary <?= $hidden ?>" id="loginDetails">Login Details</button>


            </div>
        </div>
        <div class="row mt-3" id="basicDetailsDiv">
            <?php
            include "client-basic-details.php";
            ?>

        </div>
        <div class="row mt-3 hidden" id="loanDetailsDiv">
            <?php
            include "client-loan-details.php";
            ?>
        </div>
        <div class="row mt-3 hidden" id="savingsDetailsDiv">
            <?php
            include "client-savings-details.php";
            ?>
        </div>
        <div class="row mt-3 hidden" id="transectionDetailsDiv">
            <?php
            include "client-transection-details.php";
            ?>
        </div>
        <div class="row mt-3 <?= $hidden ?>" id="loginDetailsDiv">
            <?php
            include "client-login-details.php";
            ?>
        </div>

    </div>
</div>

<!-- Custom JS -->
<script src='../../js/custom/client-settings.js?v=<?= $cashClear ?>'></script>
<!-- Custom JS -->