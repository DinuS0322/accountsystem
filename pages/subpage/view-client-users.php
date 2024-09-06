<div class="card shadow">
    <div class="card-header header-bg">
        <i class="fa fa-cog"></i> View Client Users
    </div>
    <div class="card-body">
        <div class="row  mt-3">
            <div class="table-responsive">
                <table class="table table-striped table-align-left" id="viewAllClientUsers">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>NIC Number</th>
                            <th>status</th>
                            <th ></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        try {
                            $sqlPMethod = "SELECT * FROM tbl_client_users ";
                            $stmt = $db->prepare($sqlPMethod);
                            $stmt->execute();
                            $i = 1;
                            while ($row = $stmt->fetchObject()) {
                                $id = $row->id;
                                $clientId = $row->clientId;
                                $firstName = $row->firstName;
                                $lastName = $row->lastName;
                                $nicNumber = $row->nicNumber;
                                $status = $row->status;
                                if($status == 1){
                                    $statusUpdate = "<button class='btn btn-success btn-sm btnActive' userId = '$id' data-status='0'>Active</button>";
                                    $status = "<span class='badge badge-danger'>Non Active</span>";
                                }else{
                                    $statusUpdate = "<button class='btn btn-danger btn-sm btnNonActive' userId = '$id' data-status='1'>Non Active</button>";
                                    $status = "<span class='badge badge-success'>Active</span>";
                                }
                                echo "<tr>";
                                echo "<td>$i</td>";
                                echo "<td>$firstName</td>";
                                echo "<td>$lastName</td>";
                                echo "<td>$nicNumber</td>";
                                echo "<td>$status</td>";
                                echo "<td style='text-align: center;'>$statusUpdate</td>";
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
    <script src='../../js/custom/client-user-settings.js?v=<?= $cashClear ?>'></script>
    <!-- Custom JS -->