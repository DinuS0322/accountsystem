     <div class="row  mt-3">
         <div class="table-responsive">
             <table class="table table-striped table-align-left" id="viewAllSavings"  style="width: 100%;">
             <thead>
                    <tr>
                        <th>#</th>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Short Name</th>
                        <th>Interest</th>
                        <th>Category</th>
                        <th>Years</th>
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

     <!-- Custom JS -->
     <script src='../../js/custom/savings-settings.js?v=<?= $cashClear ?>'></script>
     <!-- Custom JS -->