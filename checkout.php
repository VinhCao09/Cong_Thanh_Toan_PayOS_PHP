<?php

// require_once '../vendor/autoload.php';
require_once __DIR__ . '/vendor/autoload.php';

use PayOS\PayOS;

// Keep your PayOS key protected by including it by an env variable
$payOSClientId = 'f5e38c0b-03db-4892-a0c8-7b2cc91df07a';
$payOSApiKey = 'c909e88d-a836-4fd5-a7ff-692f8ebf481f';
$payOSChecksumKey = '4cf3248785bd3fde18bebfd1d6f1bc21f3a306a6ff96daa9a475f5eb7b2ba52a';

$payOS = new PayOS($payOSClientId, $payOSApiKey, $payOSChecksumKey);

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
