<?php
require_once '../config.php';
$statusCode = 0;
$statusMsg = '';

$postCode = filter_var($_POST['txtPostCode'], FILTER_DEFAULT);

// API Call
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://47fjd86w44.execute-api.ap-southeast-1.amazonaws.com/prod/sg-locate?postcode=$postCode",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        "x-api-key: " . SG_LOCATE_AWS_API_KEY
    ),
));

$response = curl_exec($curl);
curl_close($curl);

echo str_replace('"', "", $response);
// API Call