<?php

// require_once '../vendor/autoload.php';
require_once __DIR__ . '/vendor/autoload.php';

use PayOS\PayOS;

// Keep your PayOS key protected by including it by an env variable
$payOSClientId = 'MA CUA BAN';
$payOSApiKey = 'MA CUA BAN';
$payOSChecksumKey = 'MA CUA BAN';

$payOS = new PayOS($payOSClientId, $payOSApiKey, $payOSChecksumKey);
// Hãy thay thế domain chính xác vào đây nhé
$YOUR_DOMAIN = 'http://vinhcao.9.9.9.9.server-test.local:3000';
$DOMAN_SUCESS = 'http://vinhcao.9.9.9.9.server-test.local:3000/success.html';

// Nhận dữ liệu từ form
$fullName = $_POST['fullName'];
$phoneNumber = $_POST['phoneNumber'];
$email = $_POST['email'];

// Tạo dữ liệu cho việc tạo link thanh toán
$data = [
    "orderCode" => intval(substr(strval(microtime(true) * 10000), -6)),
    "amount" => 2000,
    "description" => "SDT" . htmlspecialchars($phoneNumber),
    "items" => [
        0 => [
            'name' => 'Mì tôm Hảo Hảo ly',
            'price' => 2000,
            'quantity' => 1
        ]
    ],
    "returnUrl" => $DOMAN_SUCESS,
    "cancelUrl" => $YOUR_DOMAIN
];

$response = $payOS->createPaymentLink($data);

// Chuyển hướng đến URL thanh toán
header("HTTP/1.1 303 See Other");
header("Location: " . $response['checkoutUrl']);
