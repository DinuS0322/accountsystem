<div class="row">
    <div class="col-md-6 col-lg-6 col-sm-12">
        <h2 style="font-family: serif;">Hello, <?= $SESS_USER_NAME . ' ' . $SESS_USER_LAST_NAME ?>!</h2>
    </div>

</div>

<hr class="mb-2 mt-2">

<section class="section dashboard">

    <?php
    $clientId = $db->query("SELECT `clientId` FROM tbl_client_users WHERE id = $SESS_USER_ID")->fetchColumn(0);

    $savingAmountTotal = $db->query("SELECT `savingAmountTotal` FROM tbl_savings_total WHERE clientId = $clientId")->fetchColumn(0);
    $savingAmountTotal = number_format($savingAmountTotal, 2);
    ?>
    <div class="row mt-3">
        <div class="notification col-sm-12 col-md-4">
            <div class="notiglow"></div>
            <div class="notiborderglow"></div>
            <div class="notititle mt-2">
                <h4 class="fw-bold">Total Savings</h4>
            </div>
            <div class="notibody mt-2"> <h6> RS. <?= $savingAmountTotal ?></h6></div>
        </div>
    </div>

    <div class="row mt-3 ">
        <div class="client-card-alignment col-sm-12 col-md-4 d-flex justify-content-center">
            <div class="client-card">
                <a class="client-card1" href="index.php?page=all-subpages&subpage=view-client-loan-details">
                    <p class="fw-bold mt-3">View Loan Details</p>
                    <p class="small"></p>
                    <div class="go-corner" href="index.php?page=all-subpages&subpage=view-client-loan-details">
                        <div class="go-arrow">
                            →
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="client-card-alignment col-sm-12 col-md-4 d-flex justify-content-center">
            <div class="client-card">
                <a class="client-card1" href="index.php?page=all-subpages&subpage=view-client-savings-details">
                    <p class="fw-bold mt-3">View Savings Details</p>
                    <p class="small"></p>
                    <div class="go-corner" href="index.php?page=all-subpages&subpage=view-client-savings-details">
                        <div class="go-arrow">
                            →
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="client-card-alignment col-sm-12 col-md-4 d-flex justify-content-center">
            <div class="client-card">
                <a class="client-card1" href="index.php?page=all-subpages&subpage=view-client-transection-details">
                    <p class="fw-bold mt-3">View Transection Details</p>
                    <p class="small"></p>
                    <div class="go-corner" href="index.php?page=all-subpages&subpage=view-client-transection-details">
                        <div class="go-arrow">
                            →
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>


</section>



<!-- Custom JS -->
<script src='js/custom/dashboard.js?v=<?= $cashClear ?>'></script>
<!-- Custom JS -->