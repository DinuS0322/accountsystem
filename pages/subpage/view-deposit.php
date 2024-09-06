<div class="card shadow">
    <div class="card-header header-bg">
        <i class="fa fa-briefcase" aria-hidden="true"></i> Deposit Report
    </div>
    <div class="card-body">
        <br>
        <div class="table-responsive">
            <table class="table table-striped table-align-left" id="viewAllTransectionHistory">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Officer Name</th>
                        <th>Officer Type</th>
                        <th>Deposit Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $officeId = $_GET['id'];
                    try {
                        $sqlPMethod = "SELECT * FROM tbl_deposit_history where officerId = '$officeId'";
                        $stmt = $db->prepare($sqlPMethod);
                        $stmt->execute();
                        $i = 1;
                        while ($row = $stmt->fetchObject()) {
                            $id = $row->id;
                            $officerId = $row->officerId;
                            $date = $row->date;
                            $amount = $row->amount;
                            $amount = number_format($amount, 2);
                            $firstName = $db->query("SELECT `firstName` FROM tbl_users WHERE id = '$officerId'")->fetchColumn(0);
                            $userType = $db->query("SELECT `userType` FROM tbl_users WHERE id = '$officerId'")->fetchColumn(0);

                            echo "<tr>";
                            echo "<td>$i</td>";
                            echo "<td>$date</td>";
                            echo "<td>$firstName</td>";
                            echo "<td><span class='badge badge-primary'>$userType</span></td>";
                            echo "<td>$amount</td>";
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
<script src='../../js/custom/account-settings.js?v=<?= $cashClear ?>'></script>
<!-- Custom JS -->