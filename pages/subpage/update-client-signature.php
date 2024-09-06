<?php
$id = $_GET['id'];
$esignImage = $db->query("SELECT `esignImage` FROM tbl_client WHERE id = $id")->fetchColumn(0);
$image = "../../upload/esignature/$esignImage";
?>
<div class="card shadow">
    <div class="card-header header-bg">
        <i class="fa fa-user-plus"></i> Update Client Signature
    </div>
    <div class="card-body">
        <div class="row mt-3">
            <div class="col  d-flex justify-content-center">
                <img src="<?= $image ?>" id="imgClientImage" height="300px" width="50%" />
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">E-signature<span class="text-danger">*</span></label>
                    <input type="file" class="form-control" id="eSignature">
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col d-flex justify-content-end">
                <button type="button" class="btn btn-primary updateClientSignature" data-id="<?= $id ?>">Update</button>
            </div>
        </div>
    </div>
</div>

<!-- Custom JS -->
<script src='../../js/custom/client-settings.js?v=<?= $cashClear ?>'></script>
<!-- Custom JS -->