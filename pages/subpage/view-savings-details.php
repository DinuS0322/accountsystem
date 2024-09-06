<?php
$productId = $_GET['productId'];
$clientId = $_GET['clientId'];
$category = $db->query("SELECT `category` FROM tbl_savings_product WHERE id = $productId")->fetchColumn(0);
?>
<div class="card shadow">
    <div class="card-header header-bg">
        <i class="bi bi-piggy-bank-fill"></i> View savings
    </div>
    <div class="card-body">

        <div class="row  mt-3">
            <table class="table table-striped table-align-left" id="viewAllSavingsDetails">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Id</th>
                        <th>Date</th>
                        <?php
                        if ($category == 'Normal' || $category == 'Others') {
                        ?>
                            <th>Name</th>
                            <th>Start Date</th>
                        <?php
                        } else {
                        ?>
                            <th>Children Name</th>
                            <th>Date of birth</th>
                        <?php
                        }
                        ?>
                        <th>Payment Status</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    try {
                        $sqlPMethod = "SELECT * FROM tbl_savings where clientId = '$clientId' and productId = '$productId'";
                        $stmt = $db->prepare($sqlPMethod);
                        $stmt->execute();
                        $i = 1;
                        while ($row = $stmt->fetchObject()) {
                            $id = $row->id;
                            $currDate = $row->date;
                            $savingAmount = $row->savingAmount;
                            $paymentStatus = $row->paymentStatus;
                            $savingId = $row->savingId;

                            $savingAmount = number_format($savingAmount, 2);

                            if ($paymentStatus == 'Credit') {
                                $paymentStatus = '<span class="badge bg-success">Credit</span>';
                            } else {
                                $paymentStatus = '<span class="badge bg-danger">Debit</span>';
                            }

                            if ($category == 'Normal' || $category == 'Others') {
                                $name = $row->personalName;
                                $Date = $row->startDate;
                            } else {
                                $name = $row->childrenName;
                                $Date = $row->childrenDOB;
                            }

                            echo "<tr>";
                            echo "<td>$i</td>";
                            echo "<td>
                            <a href='index.php?page=all-subpages&subpage=show-savings-details&savingId=$savingId'>
                            $savingId
                            </a></td>";
                            echo "<td>$currDate</td>";
                            echo "<td>$name</td>";
                            echo "<td>$Date</td>";
                            echo "<td>$paymentStatus</td>";
                            echo "<td>$savingAmount</td>";
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
<script src='../../js/custom/savings-settings.js?v=<?= $cashClear ?>'></script>
<!-- Custom JS -->