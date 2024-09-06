<div class="card shadow">
    <div class="card-header header-bg">
        <i class="fa fa-plus-square"></i> View Products
    </div>
    <div class="card-body">
        <div class="row-2 mt-3 d-flex justify-content-end">
            <a href='index.php?page=all-subpages&subpage=loan-manage-product'><button class="btn btn-primary">Add Product</button></a>
        </div>
        <div class="row mt-3">
            <table class="table table-striped table-align-left" id="viewProductTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Default Principal</th>
                        <th>Active</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    try {
                        $sqlPMethod = 'SELECT * FROM tbl_loan_product';
                        $stmt = $db->prepare($sqlPMethod);
                        $stmt->execute();
                        $i = 1;
                        while ($row = $stmt->fetchObject()) {
                            $id = $row->id;
                            $date = $row->date;
                            $productName = $row->productName;
                            $defaultPrincipal = $row->defaultPrincipal;
                            $active = $row->Active;
                            if ($active == 'Yes') {
                                $activeColor = 'badge badge-success';
                            } else {
                                $activeColor = 'badge badge-danger';
                            }
                            echo "<tr>";
                            echo "<td>$i</td>";
                            echo "<td>$date</td>";
                            echo "<td>$productName</td>";
                            echo "<td>$defaultPrincipal</td>";
                            echo "<td><span class='$activeColor'>$active</span></td>";
                            echo "<td style='text-align: center;'>
                            <div class='btn-group'>
                            <button type='button' class='btn btn-primary btn-sm dropdown-toggle' data-bs-toggle='dropdown' aria-expanded='false'>
                                Action
                            </button>
                            <ul class='dropdown-menu'>
                                <li><a class='dropdown-item ' href='index.php?page=all-subpages&subpage=update-loan-product&id=$id'>Edit</a></li>
                                <li><a class='dropdown-item btnDeleteProduct' href='#' data-id='$id'>Delete</a></li>
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
<script src='../../js/custom/loan-manage-product.js?v=<?= $cashClear ?>'></script>
<!-- Custom JS -->