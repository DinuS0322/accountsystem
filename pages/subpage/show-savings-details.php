<?php
$savingId = $_GET['savingId'];
?>

<div class="card shadow">
    <div class="card-header header-bg">
        <i class="bi bi-piggy-bank-fill"></i> View Details
    </div>
    <div class="card-body">
        <div class="row-6  d-flex justify-content-end mt-3">
            <div class="btn-group" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-primary active" id="savingBasic">saving  Details</button>
                <button type="button" class="btn btn-primary" id="savingsHistory">Saving history</button>
            </div>
        </div>
        <div class="row mt-3" id="basicDetailsDiv">
            <?php
            include "savings-basic-details.php";
            ?>

        </div>
        <div class="row mt-3 hidden" id="savingHistoryDiv">
            <?php
            include "savings-history-details.php";
            ?>
        </div>
    </div>
</div>

<!-- Custom JS -->
<script src='../../js/custom/savings-settings.js?v=<?= $cashClear ?>'></script>
<!-- Custom JS -->