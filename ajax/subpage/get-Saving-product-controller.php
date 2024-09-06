<?php
require '../../config.php';
$statusCode = 0;
$statusMsg = '';
$dueRepaymentDate = '';
$productDetails = '';
$category = '';

// CSRF Protection
if (!isset($_POST['CSRF_TOKEN']) || !isset($_SESSION['CSRF_TOKEN']) || ($_POST['CSRF_TOKEN'] <> $_SESSION['CSRF_TOKEN'])) {
    echo '<p class="error">Error: invalid form submission</p>';
    header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
    exit;
}
// CSRF Protection

$searchProduct = filter_var($_POST['searchProduct'], FILTER_DEFAULT);

try {
    $productDetails .= '    <div class="col-sm-12 col-md-12 d-flex justify-content-center">
    <h5 class="text-primary fw-bold text-uppercase">Product Details</h5>
</div>
<hr>';
    try {
        $sqlPMethod = "SELECT * FROM tbl_savings_product where id =$searchProduct ";
        $stmt = $db->prepare($sqlPMethod);
        $stmt->execute();
        while ($row = $stmt->fetchObject()) {
            $id = $row->id;
            $name = $row->name;
            $shortName = $row->shortName;
            $category = $row->category;
            $interest = $row->interest;
            $years = $row->years;
            $productDetails .= "      
            <div class='col-sm-12 col-md-6'>
            <div class='row'>
                <div class='col'>
                   <h6 class='fw-bold'>Product Name</h6>
                    $name
                </div>
            </div>
            </div>
            
            <div class='col-sm-12 col-md-6'>
            <div class='row'>
                <div class='col'>
                   <h6 class='fw-bold'>Product Short Name</h6>
                    $shortName
                </div>
            </div>
            </div>
            
            <div class='col-sm-12 col-md-6'>
            <div class='row'>
                <div class='col'>
                   <h6 class='fw-bold'>Product Category</h6>
                    $category
                </div>
            </div>
            </div>
            
            <div class='col-sm-12 col-md-6'>
            <div class='row'>
                <div class='col'>
                   <h6 class='fw-bold'>Product Interest</h6>
                    $interest %
                </div>
            </div>
            </div>
            
            <div class='col-sm-12 col-md-6'>
            <div class='row'>
                <div class='col'>
                   <h6 class='fw-bold'>Product years</h6>
                    $years Years
                </div>
            </div>
            </div>";

        }
        $productDetails .= "<hr>";
        $statusCode = 200;
    } catch (PDOException $e) {
        echo $e->getMessage();
        $statusCode = 500;
    }
} catch (PDOException $e) {
    $statusMsg = $e->getMessage();
}



$responce = new stdClass();
$responce->code = $statusCode;
$responce->message = $statusMsg;
$responce->productDetails = $productDetails;
$responce->category = $category;
print_r(json_encode($responce, true));
