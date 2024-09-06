<?php
$id = $_GET['id'];
?>
<div class="card shadow">
    <div class="card-header header-bg">
        <i class="fa fa-user-plus"></i> Password change
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12 col-md-6 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Password</label>
                    <div class="input-group">
                        <input type="password" id="txtPassword" class="form-control" autocomplete="off">
                        <span class="input-group-text passwordVisibility" data-visibility='0' data-target='#txtPassword'>
                            <i class="material-icons">visibility_off</i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Confirm Password</label>
                    <div class="input-group">
                        <input type="password" id="txtConfirmPassword" class="form-control" autocomplete="off">
                        <span class="input-group-text passwordVisibility" data-visibility='0' data-target='#txtConfirmPassword'>
                            <i class="material-icons">visibility_off</i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-2 d-flex justify-content-end mt-3">
            <button class="btn btn-primary" id="btnChangePassword" data-id='<?= $id ?>'>Change Password</button>
        </div>
    </div>
</div>

<!-- Custom JS -->
<script src='../../js/custom/user-settings.js?v=<?= $cashClear ?>'></script>
<!-- Custom JS -->