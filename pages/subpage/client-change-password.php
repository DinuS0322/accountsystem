<div class="card shadow">
    <div class="card-header header-bg">
        <i class="fa fa-unlock-alt"></i> Change Password
    </div>
    <div class="card-body">
        <div class="mb-2">
            <label for="txtCurrentPassword" class="strong pt-2">
                Current Password
            </label>

            <div class="input-group">
                <input type="password" id="txtCurrentPassword" class="form-control" autocomplete="off">
                <span class="input-group-text passwordVisibility" data-visibility='0' data-target='#txtCurrentPassword'>
                    <i class="material-icons">visibility_off</i>
                </span>
            </div>
        </div>

        <div class="mb-2">
            <label for="txtNewPassword" class="strong pt-2">
                New Password
            </label>

            <div class="input-group">
                <input type="password" id="txtNewPassword" class="form-control" autocomplete="off">
                <span class="input-group-text passwordVisibility" data-visibility='0' data-target='#txtNewPassword'>
                    <i class="material-icons">visibility_off</i>
                </span>
            </div>
        </div>

        <div class="mb-2">
            <label for="txtRetypePassword" class="strong pt-2">
                Retype Password
            </label>

            <div class="input-group">
                <input type="password" id="txtRetypePassword" class="form-control" autocomplete="off">
                <span class="input-group-text passwordVisibility" data-visibility='0' data-target='#txtRetypePassword'>
                    <i class="material-icons">visibility_off</i>
                </span>
            </div>
        </div>

        <hr>

        <button class="btn btn-primary float-end" id="btnUpdatePassword">Update Password</button>
    </div>
</div>

<!-- Custom JS -->
<script src='js/custom/client-profile.js?v=<?= $cashClear ?>'></script>
<!-- Custom JS -->