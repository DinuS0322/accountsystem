<div class="card shadow">
    <div class="card-header header-bg">
        <i class="bi bi-piggy-bank-fill"></i> Create Savings Product
    </div>
    <div class="card-body">
        <div class="row mt-3">

            <div class="col-6 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Product Category</label>
                    <select id="txtProductCategory" class="form-control">
                        <option value="">---Select---</option>
                        <option value="Normal">Normal</option>
                        <option value="Children">Children</option>
                        <option value="Others">Others</option>
                    </select>
                </div>
            </div>

            <div class="col-6 mt-3 hidden" id="txtOtherProductYearsDiv">
                <div class="form-group">
                    <label class="fw-bold mt-1">Years</label>
                    <select id="txtOtherProductYears" class="form-control">
                        <option value="">---Select---</option>
                        <?php
                        for ($i = 1; $i <= 100; $i++) {
                            if($i == 1){
                                echo '<option value="'.$i.'">'.$i.' Year</option>';
                            }else{
                                echo '<option value="'.$i.'">'.$i.' Years</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="col-6 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Name</label>
                    <input type="text" class="form-control" id="txtProductName">
                </div>
            </div>

            <div class="col-6 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Short Name</label>
                    <input type="text" class="form-control" id="txtProductShortName">
                </div>
            </div>

            <div class="col-6 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Interest %</label>
                    <input type="number" class="form-control" id="txtProductInterest">
                </div>
            </div>

            <div class="col-12 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Description</label>
                    <textarea class="form-control" id="txtProductDescription"></textarea>
                </div>
            </div>

        </div>
        <div class="row mt-3">
            <div class="col d-flex justify-content-end">
                <button class="btn btn-primary" id="btnCreateSavingsProduct"><i class="bi bi-plus-circle-fill"></i> Create</button>
            </div>
        </div>
    </div>
</div>

<!-- Custom JS -->
<script src='../../js/custom/savings-settings.js?v=<?= $cashClear ?>'></script>
<!-- Custom JS -->