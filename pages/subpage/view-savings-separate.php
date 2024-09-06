<div class="card shadow">
    <div class="card-header header-bg">
        <i class="bi bi-piggy-bank-fill"></i> View savings product
    </div>
    <div class="card-body">
        
        <div class="row  mt-3">
            <table class="table table-striped table-align-left" id="viewAllLoanSavingsData">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Short Name</th>
                        <th>Interest</th>
                        <th>Category</th>
                        <th>Years</th>
                        <th>Balance</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $clientId = $_GET['id'];
                      try {
                          $sqlPMethod = "SELECT * FROM tbl_savings_product ";
                          $stmt = $db->prepare($sqlPMethod);
                          $stmt->execute();
                          $i = 1;
                          while ($row = $stmt->fetchObject()) {
                            $getProductId = $row->id;
                              $name = $row->name;
                              $shortName = $row->shortName;
                              $interest = $row->interest;
                              $category = $row->category;
                              $productId = $row->productId;
                              $years = $row->years;

                              if($years == ''){
                                $years = 0;
                              }else{
                                $years = $row->years;
                              }

                              $sqlPMethodS = "SELECT * FROM tbl_savings where productId = $getProductId ";
                              $stmtS = $db->prepare($sqlPMethodS);
                              $stmtS->execute();
                              $totalAm = 0;
                              while ($rows = $stmtS->fetchObject()) {
                                $totalAm = $totalAm + $rows->savingAmount;
                              }
                              $totalAm = number_format($totalAm, 2, '.', ',');
                              echo "<tr>";
                              echo "<td>$i</td>";
                              echo "<td class='text-primary'>
                              <a href='index.php?page=all-subpages&subpage=view-savings-details&productId=$getProductId&clientId=$clientId'>
                              $productId
                              </a></td>";
                              echo "<td>$name</td>";
                              echo "<td>$shortName</td>";
                              echo "<td>$interest %</td>";
                              echo "<td>$category</td>";
                              echo "<td>$years Years</td>";
                              echo "<td> $totalAm</td>";
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

<div class="card shadow">
    <div class="card-header header-bg">
        <i class="bi bi-piggy-bank-fill"></i> View savings from loan pay
    </div>
    <div class="card-body">
        
        <div class="row  mt-3">
            <table class="table table-striped table-align-left" id="viewAllLoanSavings">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Saving Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $clientId = $_GET['id'];
                      try {
                          $sqlPMethod = "SELECT * FROM tbl_savings where status='saving from loan pay'";
                          $stmt = $db->prepare($sqlPMethod);
                          $stmt->execute();
                          $i = 1;
                          while ($row = $stmt->fetchObject()) {
                            $getProductId = $row->id;
                              $date = $row->date;
                              $savingAmount = $row->savingAmount;
                              $status = $row->status;
                              echo "<tr>";
                              echo "<td>$i</td>";
                              echo "<td> $date</td>";
                              echo "<td>$status</td>";
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