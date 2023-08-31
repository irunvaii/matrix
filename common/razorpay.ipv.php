<?php

include_once('../common/init.loader.php');

$pgdatatokenarr = get_optionvals($payrow['pgdatatoken']);
$razorpaycfg = get_optarr($pgdatatokenarr['razorpaycfg']);

$keyId = $razorpaycfg['razorpaykeyid'];
$keySecret = $razorpaycfg['razorpaysecret'];

require_once('../assets/fellow/razorpay-php/Razorpay.php');

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

$success = true;
$error = "Payment Failed";

if (empty($_POST['razorpay_payment_id']) === false) {
    $api = new Api($keyId, $keySecret);
    try {
        // Please note that the razorpay order ID must
        // come from a trusted source (session here, but
        // could be database or something else)
        $attributes = array(
            'razorpay_order_id' => $_SESSION['razorpay_order_id'],
            'razorpay_payment_id' => $_POST['razorpay_payment_id'],
            'razorpay_signature' => $_POST['razorpay_signature']
        );

        $api->utility->verifyPaymentSignature($attributes);
    } catch (SignatureVerificationError $e) {
        $success = false;
        $error = 'RazorPay Error: ' . $e->getMessage();
    }
}

if ($success === true) {
    $razorpay_order_id = $_SESSION['razorpay_order_id'];
    $razorpay_payment_id = $_POST['razorpay_payment_id'];
    $email = $_SESSION['email'];
    $amount = $_SESSION['amount'];

    //"Payment ID: {$_POST['razorpay_payment_id']}</p>";
    //Perform necessary action
    include_once('../common/sandbox.php');
    $FORM['sb_type'] = 'payreg';
    doipnbox($_POST['shopping_order_id'], $amount, 'razorpaykeyid', $_POST['razorpay_payment_id'], '', 'continue', 0, '');

    redirpageto('../member/ipnhub.php?hal=dashboard');
    exit;
} else {
    //echo "Transaction was unsuccessful";
    $_SESSION['dotoaster'] = "toastr.error('{$error}', 'Info');";
    redirpageto('../member/index.php?hal=planpay');
    exit;
}
