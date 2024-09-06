<?php
$savingId = $_GET['savingId'];
$date = $db->query("SELECT `date` FROM tbl_savings WHERE savingId = $savingId")->fetchColumn(0);
$productId = $db->query("SELECT `productId` FROM tbl_savings WHERE savingId = $savingId")->fetchColumn(0);
$category = $db->query("SELECT `category` FROM tbl_savings_product WHERE id = $productId")->fetchColumn(0);
if ($category == 'Normal' || $category == 'Others') {
    $name = $db->query("SELECT `personalName` FROM tbl_savings WHERE savingId = $savingId")->fetchColumn(0);
    $startDate = $db->query("SELECT `startDate` FROM tbl_savings WHERE savingId = $savingId")->fetchColumn(0);
} else {
    $name = $db->query("SELECT `childrenName` FROM tbl_savings WHERE savingId = $savingId")->fetchColumn(0);
    $startDate = $db->query("SELECT `childrenDOB` FROM tbl_savings WHERE savingId = $savingId")->fetchColumn(0);
}
$clientId = $db->query("SELECT `clientId` FROM tbl_savings WHERE savingId = $savingId")->fetchColumn(0);
$firstName = $db->query("SELECT `firstName` FROM tbl_client WHERE id = $clientId")->fetchColumn(0);
$lastName = $db->query("SELECT `lastName` FROM tbl_client WHERE id = $clientId")->fetchColumn(0);
$savingAmount = $db->query("SELECT `savingAmount` FROM tbl_savings WHERE savingId = $savingId")->fetchColumn(0);
$savingAmount = number_format($savingAmount, 2);
$paymentStatus = $db->query("SELECT `paymentStatus` FROM tbl_savings WHERE savingId = $savingId")->fetchColumn(0);
if($paymentStatus == 'Credit'){
    $paymentStatus = '<span class="badge bg-success">Credit</span>';
}else{
    $paymentStatus = '<span class="badge bg-danger">Debit</span>';
}

?>
<div class="row mt-3">
    <table class="table table-align-left" style="border: 1px solid black;" id="viewLoanDetailsTable">
        <tbody>
            <tr>
                <td class="fw-bold">Create Date</td>
                <td><?= $date ?></td>
            </tr>
            <?php
            if ($category == 'Normal' || $category == 'Others') {
            ?>
                <tr>
                    <td class="fw-bold">Name</td>
                    <td><?= $name ?></td>
                </tr>
                <tr>
                    <td class="fw-bold">Start Date</td>
                    <td><?= $startDate ?></td>
                </tr>
            <?php
            } else {
            ?>
                <tr>
                    <td class="fw-bold">Children Name</td>
                    <td><?= $name ?></td>
                </tr>
                <tr>
                    <td class="fw-bold">Children DOB</td>
                    <td><?= $startDate ?></td>
                </tr>
            <?php
            }
            ?>
            <tr>
                <td class="fw-bold">Client Name</td>
                <td><?= $firstName . ' ' . $lastName ?></td>
            </tr>
            <tr>
                <td class="fw-bold">Savings Total Amount</td>
                <td><?= $savingAmount ?></td>
            </tr>
            <tr>
                <td class="fw-bold">Status</td>
                <td><?= $paymentStatus ?></td>
            </tr>
        </tbody>
    </table>


</div>