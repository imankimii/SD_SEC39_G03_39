<?php
require_once 'toyyibpay_key.php';

// api request data
$post_data = array(
    'userSecretKey' => $secret_key,
    'categoryCode' => $category_code,
    'billName' => 'Bill Name',
    'billDescription' => 'Bill Description',
    'billPriceSetting' => 1,
    'billPayorInfo' => 0,
    'billAmount' => 100,
    //'billReturnUrl' => 'http://domain.com/response.php',
    'billReturnUrl' => 'http://localhost/diploma/ddwd3723/SD_Project/SD_SEC39_G03_39/response.php',
    //'billCallbackUrl' => 'http://domain.com/callbackresponse.php',
    'billCallbackUrl' => 'http://localhost/diploma/ddwd3723/SD_Project/SD_SEC39_G03_39/callbackresponse.php',
    'billExternalReferenceNo' => time().rand(),
    'billTo' => '',
    'billEmail' => '',
    'billPhone' => '',
    'billSplitPayment' => 0,
    'billSplitPaymentArgs' => '',
    'billPaymentChannel' => 0,
);

// php curl to post data to payment gateway
$curl = curl_init();
curl_setopt($curl, CURLOPT_POST, 1);
//curl_setopt($curl, CURLOPT_URL, 'https://toyyibpay.com/index.php/api/createBill');
//curl_setopt($curl, CURLOPT_URL, 'https://dev.toyyibpay.com/HotelSDamansara');
curl_setopt($curl, CURLOPT_URL, 'https://dev.toyyibpay.com/index.php/bill/collection');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);

$result = curl_exec($curl);
$info = curl_getinfo($curl);
curl_close($curl);
$result = json_decode($result, true);

// echo '<pre>';
// print_r($result);
// echo '</pre>';
// exit;

$post_data['billCode'] = $result[0]['BillCode'];
$post_data['paymentURL'] = 'https://dev.toyyibpay.com/HotelSDamansara' . $result[0]['BillCode'];

header('Location: ' . $post_data['paymentURL']);
