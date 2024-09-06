<?php
require '../../config.php';
$statusCode = 0;
$statusMsg = '';
$dataOption = '';

// CSRF Protection
if (!isset($_POST['CSRF_TOKEN']) || !isset($_SESSION['CSRF_TOKEN']) || ($_POST['CSRF_TOKEN'] <> $_SESSION['CSRF_TOKEN'])) {
    echo '<p class="error">Error: invalid form submission</p>';
    header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
    exit;
}
// CSRF Protection

$clientData = filter_var($_POST['clientData'], FILTER_DEFAULT);

$dataOption .= '<div class="row mt-3">
<div class="col fw-bold">
    Select a saving account
</div>
<div class="col">
<select id="savingAccount" class="form-control">';  

    try {

        $sql = "SELECT * FROM tbl_savings where clientId=$clientData";
        $stmt = $db->prepare($sql);
        $stmt->execute();


        if ($stmt->rowCount() > 0) {
            $dataOption .= "<option value=''>---Select---</option>";
        while ($row = $stmt->fetchObject()) {
            $productId = $row->productId;
            $savingId = $row->savingId;
            $status = $row->status;
            if($status != 'saving from loan pay'){
            $category = $db->query("SELECT `category` FROM tbl_savings_product WHERE id = $productId")->fetchColumn(0);
            if($category == 'Normal' || $category == 'Others'){
               $name = $row->personalName;
               $dataOption .= "<option value='$savingId'>$savingId $name</option>";
            }else{
                $name = $row->childrenName;
                $dataOption .= "<option value='$savingId'>$savingId - $name</option>";
            }
        }
        }
    }else{
        $dataOption .= "<option value=''>Data not found</option>";
    }

    $statusCode = 200;
      
    } catch (PDOException $e) {
        $statusMsg = $e->getMessage();
        $statusCode = 500;
    }


    $dataOption .= '</select>
        </div>
    </div>';

    $dataOption .= '<div class="row mt-3">
<div class="col fw-bold">
    Saving Amount
</div>
<div class="col">
    <input type="number" id="txtSavingAmount" class="form-control">
    </div>
    </div>';

$responce = new stdClass();
$responce->code = $statusCode;
$responce->message = $statusMsg;
$responce->dataOption = $dataOption;
print_r(json_encode($responce, true));