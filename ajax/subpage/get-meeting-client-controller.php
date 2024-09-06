<?php
require '../../config.php';
$statusCode = 0;
$statusMsg = '';
$dueRepaymentDate = '';
$clientDetails = '';

// CSRF Protection
if (!isset($_POST['CSRF_TOKEN']) || !isset($_SESSION['CSRF_TOKEN']) || ($_POST['CSRF_TOKEN'] <> $_SESSION['CSRF_TOKEN'])) {
    echo '<p class="error">Error: invalid form submission</p>';
    header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
    exit;
}
// CSRF Protection

$txtBranch = filter_var($_POST['txtBranch'], FILTER_DEFAULT);

try {

    try {
        $sqlPMethod = "SELECT * FROM tbl_client where branchId =$txtBranch ";
        $stmt = $db->prepare($sqlPMethod);
        $stmt->execute();
        while ($row = $stmt->fetchObject()) {
            $id = $row->id;
            $firstName = $row->firstName;
            $lastName = $row->lastName;
            $clientDetails .= "      
            
            <div class='col-12 mt-3'>
                 <div class='row mt-3'>
                     <div class='col-6'>
                         <label class='fw-bold'>$firstName $lastName</label>
                         <input type='text' class='form-control getClientId hidden' value='$id'>
                     </div>
                     <div class='col-4'>
                         <div class='row'>
                             <div class='col-3'>
                                 <label class='fw-bold '>Yes</label>
                             </div>
                             <div class='col-6'>
                                 <input class='form-check-input ' type='radio' name='meetingDetails-$id' id='$id' value='Yes'>
                             </div>
                         </div>
                         <div class='row'>
                             <div class='col-3'>
                                 <label class='fw-bold '>No</label>
                             </div>
                             <div class='col-6'>
                                 <input class='form-check-input' type='radio' name='meetingDetails-$id' id='$id' value='No'>
                             </div>
                         </div>
                     </div>
                     <div class='col-2'>
                        <select class='form-control hidden' id='reason-$id'>
                            <option value='fever' >Fever</option>
                        </select>
                     </div>
                 </div>
             </div>";
            $statusCode = 200;
        }
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
$responce->clientDetails = $clientDetails;
print_r(json_encode($responce, true));
