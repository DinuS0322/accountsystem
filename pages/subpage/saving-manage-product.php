<div class="card shadow">
    <div class="card-header header-bg">
        <i class="bi bi-piggy-bank-fill"></i> Savings Manage Products
    </div>
    <div class="card-body">
        <div class="row mt-3">
            <div class="col d-flex justify-content-end">
                <a href="index.php?page=all-subpages&subpage=create-saving-product">
                    <button class="btn btn-primary">
                        <i class="bi bi-plus"></i> Add Product
                    </button>
                </a>
            </div>
        </div>
        <div class="row  mt-3">
            <table class="table table-striped table-align-left" id="viewManageProduct">
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
                      try {
                          $sqlPMethod = "SELECT * FROM tbl_savings_product ";
                          $stmt = $db->prepare($sqlPMethod);
                          $stmt->execute();
                          $i = 1;
                          while ($row = $stmt->fetchObject()) {
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
                              echo "<td class='text-primary'>$productId</td>";
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
</div>

<!-- Custom JS -->
<script src='../../js/custom/savings-settings.js?v=<?= $cashClear ?>'></script>
<!-- Custom JS -->