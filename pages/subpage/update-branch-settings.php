<?php
$branchId = $_GET['id'];
$sqlPMethod = "SELECT * FROM tbl_branch where id=$branchId";
$stmt = $db->prepare($sqlPMethod);
$stmt->execute();
if ($row = $stmt->fetchObject()) {
    $branchName = $row->branchName;
    $notes = $row->notes;
    $binNumber = $row->binNumber;
    $active = $row->active;
}
if($active == 'Yes'){
    $activeStatusYes = 'selected';
    $activeStatusNo = '';
}else{
    $activeStatusYes = '';
    $activeStatusNo = 'selected';
}
?>
<div class="card shadow">
    <div class="card-header header-bg">
        <i class="fa fa-building"></i> Update Branch Settings
    </div>
    <div class="card-body">
        <div class="row mt-3">
            <div class="col">
                Branch Name
            </div>
            <div class="col">
                <input type="text" class="form-control" id="txtUpdateBranchName" value="<?= $branchName ?>">
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                Notes
            </div>
            <div class="col">
                <textarea id="txtUpdateNotes" class="form-control"><?= $notes ?></textarea>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                Active
            </div>
            <div class="col">
                <select id="txtUpdateActive" class="form-control">
                    <option value="Yes" <?= $activeStatusYes ?>>Yes</option>
                    <option value="No" <?= $activeStatusNo ?>>No</option>
                </select>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                Bin Number
            </div>
            <div class="col">
                <input type="number" class="form-control" id="txtUpdateBinNumber" value="<?= $binNumber ?>">
            </div>
        </div>
        <div class="row-2 d-flex justify-content-end mt-3">
            <button class="btn btn-primary" id="btnUpdateBranch" branch-id="<?= $branchId ?>">Update Branch</button>
        </div>
    </div>
</div>



<!-- Custom JS -->
<script src='../../js/custom/branch-settings.js?v=<?= $cashClear ?>'></script>
<!-- Custom JS -->