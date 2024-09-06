<div class="card shadow">
    <div class="card-header header-bg">
        <i class="fas fa-money-check-alt"></i> View Savings
    </div>
    <div class="card-body">
        <div class="row  mt-3">
            <table class="table table-striped table-align-left" id="viewAllSavings">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Client Name</th>
                        <th>NIC Number</th>
                        <th>Phone Number</th>
                        <th>Account Number</th>
                        <th>Savings Amount</th>
                        <th></th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    try {
                        $sqlPMethod = 'SELECT * FROM tbl_client';
                        $stmt = $db->prepare($sqlPMethod);
                        $stmt->execute();
                        $i = 1;
                        while ($row = $stmt->fetchObject()) {
                            $id = $row->id;
                            $firstName = $row->firstName;
                            $lastName = $row->lastName;
                            $fullName = $firstName . ' ' . $lastName;
                            $nicNumber  = $row->nicNumber;
                            $phoneNumber = $row->phoneNumber;
                            $accountNumber = $row->accountNumber;
                            $savingAmountTotal = $db->query("SELECT `savingAmountTotal` FROM tbl_savings_total WHERE clientId = $id")->fetchColumn(0);
                            if ($savingAmountTotal == '') {
                                $savingAmountTotal = '-';
                            } else {
                                $savingAmountTotal = number_format($savingAmountTotal, 2);
                            }
                            $branchId = $db->query("SELECT `branchId` FROM tbl_client WHERE id = $id")->fetchColumn(0);
                            if ($branchId == $SESS_USER_BRANCH && $SESS_USER_TYPE == 'fieldOfficer') {
                            echo "<tr>";
                            echo "<td>$i</td>";
                            echo "<td>$fullName</td>";
                            echo "<td>$nicNumber</td>";
                            echo "<td>$phoneNumber</td>";
                            echo "<td>$accountNumber</td>";
                            echo "<td>$savingAmountTotal</td>";
                            echo "<td>
                            <a href='index.php?page=all-subpages&subpage=view-savings-separate&id=$id'>
                            <button class='btn btn-success btn-sm'>View</button>
                            </a>
                            </td>";

                            $i++;
                            }else if($SESS_USER_TYPE != 'fieldOfficer'){
                                echo "<tr>";
                                echo "<td>$i</td>";
                                echo "<td>$fullName</td>";
                                echo "<td>$nicNumber</td>";
                                echo "<td>$phoneNumber</td>";
                                echo "<td>$accountNumber</td>";
                                echo "<td>$savingAmountTotal</td>";
                                echo "<td>
                                <a href='index.php?page=all-subpages&subpage=view-savings-separate&id=$id'>
                                <button class='btn btn-success btn-sm'>View</button>
                                </a>
                                </td>";
    
                                $i++;
                            }
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
<script src='../../js/custom/savings-settings.js?v=<?= $cashClear ?>'></script>
<!-- Custom JS -->