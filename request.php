<?php

$merchantCode = 'YOUR_MERCHANT_CODE'; # you can see your terminal's merchant code in your panel
$amount = 10000; # amount of transaction in rial (amount must be between 10,000 and 500,000,000 rial)
$callbackURL = 'https://example.com'; # callback url that after payment is done (successful or not) information returns to this url with POST method
$orderId = time(); # you can set your desired unique order id for transaction
$cardNumber = '1234123412341234'; # by sending cardnumber , your user can not pay with another card number // OPTIONAL
$mobile = '09111111111'; # for more information in transaction's detail // OPTIONAL
$desription = 'YOUR_DESIRED_DESCRIPTION'; # for more information in transaction's detail // OPTIONAL


if(!extension_loaded("soap")) {
    throw new \Exception('SOAP is not enabled in this server, please enable it first');
}

$client = new SoapClient('https://dargaah.com/wsdl', ['cache_wsdl' => WSDL_CACHE_NONE]);

try {
    $result = $client->IRDPayment([
        'merchantID' => $merchantCode,
        'amount' => $amount,
        'callbackURL' => $callbackURL,
        'orderId' => $orderId,
        'cardNumber' => $cardNumber,
        'mobile' => $mobile,
        'description' => $desription
    ]);

    if($result->status == 200) {
        // Connection successfully has been established. Redirecting to gateway...;
        header('Location: https://dargaah.com/ird/startpay/' . $result->authority);
    } else {
        die('Error in connecting to gateway: ' . $result->message);
    }
} catch (\SoapFault $fault) {
    throw new \Exception('Error in soap connection: ' . $fault->getMessage());
}

