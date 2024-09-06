<div class="card shadow">
    <div class="card-header header-bg">
        <i class="fa fa-building"></i> View Branches
    </div>
    <div class="card-body">
        <div class="row  mt-3">
            <table class="table table-striped table-align-left table-responsive" id="viewBranches">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Branch Name</th>
                        <th>Open Date</th>
                        <th>Status</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    try {
                        $sqlPMethod = 'SELECT * FROM tbl_branch';
                        $stmt = $db->prepare($sqlPMethod);
                        $stmt->execute();
                        $i = 1;
                        while ($row = $stmt->fetchObject()) {
                            $id = $row->id;
                            $branchName = $row->branchName;
                            $openDate = $row->openDate;
                            $active = $row->active;
                            if($active == "Yes"){
                                $active = "<span class='badge badge-success'>Active</span>";
                            }else{
                                $active = "<span class='badge badge-danger'>InActive</span>";
                            }
                            if($SESS_USER_TYPE == 'fieldOfficer'){
                                if($SESS_USER_BRANCH == $id){
                                    echo "<tr>";
                                    echo "<td>$i</td>";
                                    echo "<td>$branchName</td>";
                                    echo "<td>$openDate</td>";
                                    echo "<td>$active</td>";
                                    echo "<td style='text-align: center;' >
                                    <a href='index.php?page=all-subpages&subpage=update-branch-settings&id=$id'>
                                    <button class='btn btn-success btn-sm'>Edit</button>
                                    </a>
                                    </td>";
                                    echo "<td style='text-align: center;'>
                                    <button class='btn btn-danger btn-sm btnDeleteBranch' branch-id='$id'>Delete</button>
                                    </td>";
                                    echo "</tr>";
                                    $i++;
                                }
                            }else{
                                echo "<tr>";
                                echo "<td>$i</td>";
                                echo "<td>$branchName</td>";
                                echo "<td>$openDate</td>";
                                echo "<td>$active</td>";
                                echo "<td style='text-align: center;' >
                                <a href='index.php?page=all-subpages&subpage=update-branch-settings&id=$id'>
                                <button class='btn btn-success btn-sm'>Edit</button>
                                </a>
                                </td>";
                                echo "<td style='text-align: center;'>
                                <button class='btn btn-danger btn-sm btnDeleteBranch' branch-id='$id'>Delete</button>
                                </td>";
                                echo "</tr>";
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
<script src='../../js/custom/branch-settings.js?v=<?= $cashClear ?>'></script>
<!-- Custom JS -->