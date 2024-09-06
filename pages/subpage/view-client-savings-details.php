<div class="card shadow">
    <div class="card-header header-bg">
        <i class="fa fa-cog"></i> View Savings Details
    </div>
    <div class="card-body">
        <div class="row  mt-3">
            <div class="table-responsive">
                <table class="table table-striped table-align-left" id="viewAllClientSavings">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Saving Amount</th>
                            <th>status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $clientId = $db->query("SELECT `clientId` FROM tbl_client_users WHERE id = $SESS_USER_ID")->fetchColumn(0);
                        try {
                            $sqlPMethod = "SELECT * FROM tbl_savings where clientId= $clientId";
                            $stmt = $db->prepare($sqlPMethod);
                            $stmt->execute();
                            $i = 1;
                            while ($row = $stmt->fetchObject()) {
                                $id = $row->id;
                                $date = $row->date;
                                $savingAmount = $row->savingAmount;
                                $status = $row->status;

                                echo "<tr>";
                                echo "<td>$i</td>";
                                echo "<td>$date</td>";
                                echo "<td>$savingAmount</td>";
                                echo "<td>$status</td>";
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
    <script src='../../js/custom/loan-settings.js?v=<?= $cashClear ?>'></script>
    <!-- Custom JS -->