<div class="card shadow">
    <div class="card-header header-bg">
        <i class="fa fa-lock"></i> Activity Log
    </div>
    <div class="card-body">
        <div class="row  mt-3">
            <table class="table table-striped table-align-left" id="viewActivity">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date & Time</th>
                        <th>Email</th>
                        <th>User Type</th>
                        <th>Activity</th>
                        <th>Activity Path</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    try {
                        $sqlPMethod = 'SELECT * FROM tbl_activity_log ORDER BY currentDate desc';
                        $stmt = $db->prepare($sqlPMethod);
                        $stmt->execute();
                        $i = 1;
                 
                        while ($row = $stmt->fetchObject()) {
                            $id = $row->id;
                            $currentDate = $row->currentDate;
                            $userEmail = $row->userEmail;
                            $userType = $row->userType;
                            $activity = $row->activity;
                            $activityPath = $row->activityPath;
                   
                            if (strpos($activity, "Create") !== false) {
                                $activityColor = 'badge badge-success';
                            } else  if (strpos($activity, "Update") !== false) {
                                $activityColor = 'badge badge-warning';
                            } else  if (strpos($activity, "Delete") !== false) {
                                $activityColor = 'badge badge-danger';
                            } else {
                                $activityColor = 'badge badge-primary';
                            }
                            if($SESS_USER_TYPE  == 'admin') {
                                if( $userType != 'superAdmin' && $userType != 'director'){
                                    echo "<tr>";
                                    echo "<td>$i</td>";
                                    echo "<td>$currentDate</td>";
                                    echo "<td>$userEmail</td>";
                                    echo "<td>$userType</td>";
                                    echo "<td><span class='$activityColor'>$activity</span></td>";
                                    echo "<td>$activityPath</td>";
                                    echo "</tr>";
                                    $i++;
                                }
                          
                            }else  if($SESS_USER_TYPE  == 'director' ) {
                                if( $userType != 'superAdmin'){
                                    echo "<tr>";
                                    echo "<td>$i</td>";
                                    echo "<td>$currentDate</td>";
                                    echo "<td>$userEmail</td>";
                                    echo "<td>$userType</td>";
                                    echo "<td><span class='$activityColor'>$activity</span></td>";
                                    echo "<td>$activityPath</td>";
                                    echo "</tr>";
                                    $i++;
                                }
                             
                            }else{
                                echo "<tr>";
                                echo "<td>$i</td>";
                                echo "<td>$currentDate</td>";
                                echo "<td>$userEmail</td>";
                                echo "<td>$userType</td>";
                                echo "<td><span class='$activityColor'>$activity</span></td>";
                                echo "<td>$activityPath</td>";
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

<?php

?>

<!-- Custom JS -->
<script src='../../js/custom/common.js?v=<?= $cashClear ?>'></script>
<!-- Custom JS -->