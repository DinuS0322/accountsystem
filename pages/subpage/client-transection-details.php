 <div class="row  mt-3">
     <div class="table-responsive">
         <table class="table table-striped table-align-left" id="viewAllTransection">
             <thead>
                 <tr>
                     <th>#</th>
                     <th>Date</th>
                     <th>Name</th>
                     <th>Amount</th>
                 </tr>
             </thead>
             <tbody>
                 <?php
                    $id = $_GET['id'];
                    try {
                        $sqlPMethod = "SELECT * FROM tbl_loan where clientId= $id";
                        $stmt = $db->prepare($sqlPMethod);
                        $stmt->execute();
                        $i = 1;
                        while ($row = $stmt->fetchObject()) {
                            $id = $row->id;
                            $date = $row->date;
                            $principal = $row->principal;
                            $newLoan = $row->newLoan;
                            $principal = number_format($principal, 2);

                            $sqlPpMethod = "SELECT * FROM tbl_loan_repayment where loanId= $id";
                            $stmtt = $db->prepare($sqlPpMethod);
                            $stmtt->execute();
                            while ($roww = $stmtt->fetchObject()) {
                                $dateDB = $roww->date;
                                $repay = $roww->monthlyTotalPayment;
                                echo "<tr>";
                                echo "<td>$i</td>";
                                echo "<td>$dateDB</td>";
                                echo "<td>Re-Payment</td>";
                                echo "<td>$repay</td>";
                                echo "</tr>";

                                $i++;
                            }

                            echo "<tr>";
                            echo "<td>$i</td>";
                            echo "<td>$date</td>";
                            echo "<td>$newLoan</td>";
                            echo "<td>$principal</td>";
                            echo "</tr>";

                            $i++;
                        }
                    } catch (PDOException $e) {
                        echo $e->getMessage();
                    }

                    try {
                    } catch (PDOException $e) {
                        echo $e->getMessage();
                    }
                    ?>
             </tbody>
         </table>
     </div>
 </div>

 <!-- Custom JS -->
 <script src='../../js/custom/transection-settings.js?v=<?= $cashClear ?>'></script>
 <!-- Custom JS -->