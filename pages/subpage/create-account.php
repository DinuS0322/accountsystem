<?php
    $currentDate = date("Y-m-d");
?>
<div class="card shadow">
    <div class="card-header header-bg">
        <i class="fa fa-cog"></i> Create Account
    </div>
    <div class="card-body">
        <div class="row mt-3">
            <div class="col-12 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Account Name <span class="text text-danger">*</span></label>
                    <input type="text" class="form-control" id="txtAccountName">
                </div>
            </div>
            <div class="col-6 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Branch Name <span class="text text-danger">*</span></label>
                    <input type="text" class="form-control" id="txtBranchName">
                </div>
            </div>
            <div class="col-6 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Account Number <span class="text text-danger">*</span></label>
                    <input type="text" class="form-control" id="txtAccountNumber">
                </div>
            </div>
            <div class="col-6 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Date <span class="text text-danger">*</span></label>
                    <input type="date" class="form-control" id="txtRegisterDate" value="<?= $currentDate ?>">
                </div>
            </div>
            <div class="col-6 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Status <span class="text text-danger">*</span></label>
                    <select id="txtStatus" class="form-control">
                        <option value="active">Active</option>
                        <option value="inActive">Inactive</option>
                    </select>
                </div>
            </div>
            <div class="col-12 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Note <span class="text text-danger">*</span></label>
                    <textarea id="txtNote" class="form-control"></textarea>
                </div>
            </div>
        </div>
        <div class="row-2 mt-3 d-flex justify-content-end">
            <button class="btn btn-primary btn-sm" id="btnCreateAccount">Account Create</button>
        </div>
    </div>

    <!-- Custom JS -->
    <script src='../../js/custom/account-settings.js?v=<?= $cashClear ?>'></script>
    <!-- Custom JS -->