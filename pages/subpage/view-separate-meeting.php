<?php
$id = $_GET['id'];
$sqlPMethod = "SELECT * FROM tbl_meeting where id='$id'";
$stmt = $db->prepare($sqlPMethod);
$stmt->execute();
if ($row = $stmt->fetchObject()) {
    $id = $row->id;
    $meetingName = $row->meetingName;
    $Date = $row->Date;
    $Time = $row->Time;
    $specialGuest = $row->specialGuest;
    $remarks = $row->remarks;
    $branch = $row->branch;
    $clientReaction = $row->clientReaction;
    $branchName = $db->query("SELECT `branchName` FROM tbl_branch WHERE id = $branch")->fetchColumn(0);
}
?>

<div class="card shadow">
    <div class="card-header header-bg">
        <i class="fa fa-building"></i> View
    </div>
    <div class="card-body">
        <div class="row mt-3">
            <table class="table table-align-left" style="border: 1px solid black;" id="viewLoanDetailsTable">
                <tbody>
                    <tr>
                        <td class="fw-bold">Meeting Name</td>
                        <td><?= $meetingName ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Meeting Date</td>
                        <td><?= $Date ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Meeting Time</td>
                        <td><?= $Time ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Special Guest</td>
                        <td><?= $specialGuest ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Remarks</td>
                        <td><?= $remarks ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Branch</td>
                        <td><?= $branchName ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Participate</td>
                        <td>
                            <?php
                            $clientReactions = json_decode($clientReaction, true);
                            foreach ($clientReactions as $item) {
                                $id = $item['id'];
                                $value = $item['value'];
                                if ($value == 'Yes') {
                                    $firstName = $db->query("SELECT `firstName` FROM tbl_client WHERE id = $id")->fetchColumn(0);
                                    $lastName = $db->query("SELECT `lastName` FROM tbl_client WHERE id = $id")->fetchColumn(0);
                                    echo  "<span class='badge badge-success'>$firstName $lastName</span>" . '<br>';
                                }
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Not Participate</td>
                        <td>
                            <?php
                            $clientReactionss = json_decode($clientReaction, true);
                            foreach ($clientReactionss as $item) {
                                $id = $item['id'];
                                $value = $item['value'];
                                if ($value == 'No') {
                                    $firstName = $db->query("SELECT `firstName` FROM tbl_client WHERE id = $id")->fetchColumn(0);
                                    $lastName = $db->query("SELECT `lastName` FROM tbl_client WHERE id = $id")->fetchColumn(0);
                                    echo  "<span class='badge badge-danger'>$firstName $lastName</span>" . '<br>';
                                }
                            }
                            ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>