<div class="card shadow">
    <div class="card-header header-bg">
        <i class="fa fa-building"></i> View Meetings
    </div>
    <div class="card-body">
        <div class="row  mt-3">
            <table class="table table-striped table-align-left" id="viewMeetings">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Meeting Name</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Branch</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    try {
                        $sqlPMethod = 'SELECT * FROM tbl_meeting';
                        $stmt = $db->prepare($sqlPMethod);
                        $stmt->execute();
                        $i = 1;
                        while ($row = $stmt->fetchObject()) {
                            $id = $row->id;
                            $meetingName = $row->meetingName;
                            $Date = $row->Date;
                            $Time = $row->Time;
                            $branch = $row->branch;
                            $branchName = $db->query("SELECT `branchName` FROM tbl_branch WHERE id = $branch")->fetchColumn(0);

                            echo "<tr>";
                            echo "<td>$i</td>";
                            echo "<td>$meetingName</td>";
                            echo "<td>$Date</td>";
                            echo "<td>$Time</td>";
                            echo "<td>$branchName</td>";
                            echo "<td style='text-align: center;'>
                                <a href='index.php?page=all-subpages&subpage=view-separate-meeting&id=$id'>
                                    <button class='btn btn-success btn-sm '>View</button>
                                </a>
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
<script src='../../js/custom/meeting-settings.js?v=<?= $cashClear ?>'></script>
<!-- Custom JS -->