<div class="card shadow">
    <div class="card-header header-bg">
        <i class="fa fa-users"></i> View Users
    </div>
    <div class="card-body">
        <div class="row  mt-3">
            <table class="table table-striped table-align-left" id="viewUsers">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Created At</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    try {
                        $sqlPMethod = 'SELECT * FROM tbl_users';
                        $stmt = $db->prepare($sqlPMethod);
                        $stmt->execute();
                        $i = 1;
                        while ($row = $stmt->fetchObject()) {
                            $id = $row->id;
                            $registerDate = $row->registerDate;
                            $email = $row->email;
                            $userType = $row->userType;
                            $firstName = $row->firstName;
                            $lastName = $row->lastName;
                            $fullName = $firstName . ' ' . $lastName;
                            echo "<tr>";
                            echo "<td>$i</td>";
                            echo "<td>$fullName</td>";
                            echo "<td>$email</td>";
                            echo "<td><span class='badge badge-primary'>$userType</span></td>";
                            echo "<td>$registerDate</td>";
                            echo "<td style='text-align: center;'>
                            <div class='btn-group'>
                            <button type='button' class='btn btn-primary btn-sm dropdown-toggle' data-bs-toggle='dropdown' aria-expanded='false'>
                                Action
                            </button>
                            <ul class='dropdown-menu'>
                             <li><a class='dropdown-item ' href='index.php?page=all-subpages&subpage=view-user-details&id=$id'>Details</a></li>
                                <li><a class='dropdown-item ' href='index.php?page=all-subpages&subpage=update-users&id=$id' >Edit</a></li>
                                <li><a class='dropdown-item btnDeleteUser' href='#' user-id='$id'>Delete</a></li>";
                            echo " <li><a class='dropdown-item ' href='index.php?page=all-subpages&subpage=change-password&id=$id' >Change Password</a></li>";
                           echo "</ul>
                            </div>  
                            </td>";
                            echo "</tr>";
                            $i++;
                        }
                    } catch (PDOException $e) {
                        echo $e->getMessage();
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Custom JS -->
<script src='../../js/custom/user-settings.js?v=<?= $cashClear ?>'></script>
<!-- Custom JS -->