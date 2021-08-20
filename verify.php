<?php

$merchantCode = 'YOUR_MERCHANT_CODE'; # you can see your terminal's merchant code in your panel
$authority = 'AUTHORITY_CODE_OF_YOUR_TRANSACTION'; # this code is received in first step
$amount = 'AMOUNT_OF_YOUR_TRANSACTION'; # this value must be equal to amount of transaction in first step
$orderId = 'ORDER_ID_OF_YOUR_TRANSACTION'; # this value must be equal to orderId of transaction in first step

if(!array_key_exists('code', $_POST)) {
    throw new \Exception('callback has not valid data');
}

$client = new SoapClient('https://dargaah.com/wsdl', ['cache_wsdl' => WSDL_CACHE_NONE]);

if ($_POST['code'] == 100) {
    try {
        $result = $client->IRDVerification([
            'merchantID' => $merchantCode,
            'authority' => $authority, // you can set this variable by: $_POST['authority'],
            'amount' => $amount, // you can set this variable by: intval($_POST['amount']),
            'orderId' => $orderId, // you can set this variable by: $_POST['orderId'],
        ]);

        echo 'transaction verified: ' . $result->message;
        echo '<br />';
        echo 'verification status code: ' . $result->status;
        echo '<br />';
        echo 'transaction refId: ' . $result->refId;
        echo '<br />';
        echo 'transaction cardnumber: ' . $result->cardNumber;
        echo '<br />';
        echo 'transaction order id: ' . $result->orderId;
    } catch (\SoapFault $fault) {
        throw new Exception('Error in sending verification request: ' . $fault->getMessage());
    }
} else {
    die('error in transaction\'s payment: ' . $_POST['message']);
}