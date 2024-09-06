<div class="card shadow">
    <div class="card-header header-bg">
        <i class="fa fa-user-plus"></i> Add User
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12 col-md-6 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">First Name</label>
                    <input type="text" class="form-control" id="txtFirstName">
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Last Name</label>
                    <input type="text" class="form-control" id="txtLastName">
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Gender</label>
                    <select id="txtGender" class="form-control">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Phone</label>
                    <input type="number" class="form-control" id="txtNumber">
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Role</label>
                    <select id="txtUserType" class="form-control">
                        <?php
                        if ($SESS_USER_TYPE == 'admin') {
                        ?>
                            <option value="fieldOfficer">Field Officer</option>
                            <option value="branchOfficer">Branch Officer</option>
                            <option value="financeManager">Finance Manager</option>
                        <?php
                        } else if ($SESS_USER_TYPE == 'director') {
                        ?>
                            <option value="admin">admin</option>
                            <option value="fieldOfficer">Field Officer</option>
                            <option value="branchOfficer">Branch Officer</option>
                            <option value="financeManager">Finance Manager</option>
                        <?php
                        }else{
                        ?>
                        <option value="superAdmin">Super Admin</option>
                        <option value="admin">admin</option>
                        <option value="fieldOfficer">Field Officer</option>
                        <option value="branchOfficer">Branch Officer</option>
                        <option value="financeManager">Finance Manager</option>
                        <option value="director">Director</option>
                        <?php
                        }
                        ?>

                    </select>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">email</label>
                    <input type="email" class="form-control" id="txtEmail">
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mt-3 hidden" id="branchDiv">
                <div class="form-group">
                    <label class="fw-bold mt-1">Branches</label>
                    <select id="txtbranchData" class="form-control">
                        <?php
                            $sqlPMethod = 'SELECT * FROM tbl_branch where active = "Yes"';
                            $stmt = $db->prepare($sqlPMethod);
                            $stmt->execute();
                            $i = 1;
                            while ($row = $stmt->fetchObject()) {
                                $id = $row->id;
                                $branchName = $row->branchName;
                                echo '<option value="'. $id. '">'. $branchName. '</option>';
                            }
                        ?>
                    </select>
                </div>
            </div>
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
            <div class="col-sm-12 col-md-12 mt-3">
                <div class="form-group">
                    <label class="fw-bold mt-1">Address</label>
                    <textarea id="txtAddress" class="form-control"></textarea>
                </div>
            </div>
        </div>
        <div class="row-2 d-flex justify-content-end mt-3">
            <button class="btn btn-primary" id="btnAddUser">Add User</button>
        </div>
    </div>
</div>

<!-- Custom JS -->
<script src='../../js/custom/user-settings.js?v=<?= $cashClear ?>'></script>
<!-- Custom JS -->