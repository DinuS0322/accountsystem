<table class="table table-striped table-align-left" id="viewSavingsHistory">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Category</th>
                        <th>Payment Status</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                      try {
                        $savingId = $_GET['savingId'];
                          $sqlPMethod = "SELECT * FROM tbl_savings_history where savingId = $savingId ";
                          $stmt = $db->prepare($sqlPMethod);
                          $stmt->execute();
                          $i = 1;
                          while ($row = $stmt->fetchObject()) {
                              $date = $row->date;
                              $productId = $row->productId;
                              $paymentStatus = $row->paymentStatus;
                              $savingAmount = $row->savingAmount;
                              $savingAmount = number_format($savingAmount, 2);
                              if($paymentStatus == 'Credit'){
                                $paymentStatus = '<span class="badge bg-success">Credit</span>';
                              }else{
                                $paymentStatus = '<span class="badge bg-danger">Debit</span>';
                              }
                              $category = $db->query("SELECT `category` FROM tbl_savings_product WHERE id = $productId")->fetchColumn(0);
                              echo "<tr>";
                              echo "<td>$i</td>";
                              echo "<td>$date</td>";
                              echo "<td>$category</td>";
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
