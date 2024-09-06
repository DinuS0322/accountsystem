<?php
$id = $_GET['id'];
$clientImage = $db->query("SELECT `clientImage` FROM tbl_client WHERE id = $id")->fetchColumn(0);
$image = "../../upload/clientImagePhoto/$clientImage";
?>
<div class="card shadow">
    <div class="card-header header-bg">
        <i class="fa fa-user-plus"></i> Update Client Profile
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
                    <label class="fw-bold mt-1">Photo</label>
                    <input type="file" class="form-control" id="uploadClientPhoto">
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col d-flex justify-content-end">
                <button type="button" class="btn btn-primary updateClientPhoto" data-id="<?= $id ?>">Update</button>
            </div>
        </div>
    </div>
</div>

<!-- Custom JS -->
<script src='../../js/custom/client-settings.js?v=<?= $cashClear ?>'></script>
<!-- Custom JS -->