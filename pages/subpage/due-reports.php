<div class="card shadow">
    <div class="card-header header-bg">
        <i class="fa fa-tasks"></i> View Arrears Reports 
    </div>
    <div class="card-body">
       <div class="row mt-3">
        <div class="col-6 mt-1">
            <input type="date" class="form-control" id="txtEndDate">
        </div>
        <div class="col-6 d-flex justify-content-start">
            <button type="button" class="btn btn-primary" id="btnViewArrears"><i class="bi bi-funnel-fill"></i> Filter</button>
        </div>
       </div>
       <div id="viewArreasDiv"></div>
    </div>
</div>

<?php

?>

<!-- Custom JS -->
<script src='../../js/custom/reports.js?v=<?= $cashClear ?>'></script>
<!-- Custom JS -->