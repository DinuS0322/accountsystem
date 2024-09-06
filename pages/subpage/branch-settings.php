<div class="card shadow">
    <div class="card-header header-bg">
        <i class="fa fa-building"></i> Branch Settings
    </div>
    <div class="card-body">
        <div class="row mt-3">
            <div class="col">
                Branch Name
            </div>
            <div class="col">
                <input type="text" class="form-control" id="txtBranchName">
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                Open Date
            </div>
            <div class="col">
                <input type="date" class="form-control" id="txtOpenDate">
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                Notes
            </div>
            <div class="col">
                <textarea id="txtNotes" class="form-control"></textarea>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                Active
            </div>
            <div class="col">
                <select id="txtActive" class="form-control">
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                Bin Number
            </div>
            <div class="col">
                <input type="number" class="form-control" id="txtBinNumber">
            </div>
        </div>
        <div class="row-2 d-flex justify-content-end mt-3">
            <button class="btn btn-primary" id="btnCreateBranch">Create Branch</button>
        </div>
    </div>
</div>



<!-- Custom JS -->
<script src='../../js/custom/branch-settings.js?v=<?= $cashClear ?>'></script>
<!-- Custom JS -->