<div class="card shadow">
    <div class="card-header header-bg">
        <i class="fa fa-plus-square"></i> View Charges
    </div>
    <div class="card-body">
        <div class="row-2 mt-3 d-flex justify-content-end">
            <a href='index.php?page=all-subpages&subpage=loan-manage-charge'><button class="btn btn-primary">Add Charge</button></a>
        </div>
        <div class="row mt-3">
            <table class="table table-striped table-align-left" id="viewChargeTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Active</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    try {
                        $sqlPMethod = 'SELECT * FROM tbl_loan_charge';
                        $stmt = $db->prepare($sqlPMethod);
                        $stmt->execute();
                        $i = 1;
                        while ($row = $stmt->fetchObject()) {
                            $id = $row->id;
                            $date = $row->date;
                            $chargeName = $row->chargeName;
                            $chargeType = $row->chargeType;
                            $amount = $row->amount;
                            $active = $row->active;
                            if ($active == 'Yes') {
                                $activeColor = 'badge badge-success';
                            } else {
                                $activeColor = 'badge badge-danger';
                            }
                            $chargeTypeName = $db->query("SELECT `chargeType` FROM tbl_charge WHERE id = $chargeType")->fetchColumn(0);
                            echo "<tr>";
                            echo "<td>$i</td>";
                            echo "<td>$date</td>";
                            echo "<td>$chargeName</td>";
                            echo "<td>$chargeTypeName</td>";
                            echo "<td>$amount</td>";
                            echo "<td><span class='$activeColor'>$active</span></td>";
                            echo "<td style='text-align: center;'>
                            <div class='btn-group'>
                            <button type='button' class='btn btn-primary btn-sm dropdown-toggle' data-bs-toggle='dropdown' aria-expanded='false'>
                                Action
                            </button>
                            <ul class='dropdown-menu'>
                                <li><a class='dropdown-item ' href='#'>Edit</a></li>
                                <li><a class='dropdown-item btnDeleteBranch' href='#'>Delete</a></li>
                            </ul>
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
<script src='../../js/custom/loan-manage-charge.js?v=<?= $cashClear ?>'></script>
<!-- Custom JS -->