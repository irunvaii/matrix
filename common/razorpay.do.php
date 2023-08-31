<?php
include_once('../common/init.loader.php');

$planlogo = ($bpparr[$doppid]['planlogo'] != '') ? $bpparr[$doppid]['planlogo'] : DEFIMG_LOGO;
$pgdatatokenarr = get_optionvals($payrow['pgdatatoken']);
$razorpaycfg = get_optarr($pgdatatokenarr['razorpaycfg']);

$keyId = $razorpaycfg['razorpaykeyid'];
$keySecret = $razorpaycfg['razorpaysecret'];
$displayCurrency = $_POST['currencycode'];

require_once('../assets/fellow/razorpay-php/Razorpay.php');

// Create the Razorpay Order

use Razorpay\Api\Api;
use Razorpay\Api\Errors\BadRequestError;

$api = new Api($keyId, $keySecret);
try {
//
// We create an razorpay order using orders api
// Docs: https://docs.razorpay.com/docs/orders
//
    $amount = $_POST['amount'];
    $_SESSION['amount'] = $amount;
    $email = $_POST['email'];
    $_SESSION['email'] = $email;
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $orderData = [
        'receipt' => $_POST['item_number'],
        'amount' => $amount * 100, // 2000 rupees in paise
        'currency' => 'INR',
        'payment_capture' => 1 // auto capture
    ];

    $razorpayOrder = $api->order->create($orderData);
    $razorpayOrderId = $razorpayOrder['id'];

    $_SESSION['razorpay_order_id'] = $razorpayOrderId;
} catch (BadRequestError $e) {
    $error = 'RazorPay Error: ' . $e->getMessage();
    $_SESSION['dotoaster'] = "toastr.error('{$error}', 'Info');";
    redirpageto('../member/index.php?hal=planpay');
    exit;
}

$displayAmount = $amount = $orderData['amount'];

if ($displayCurrency !== 'INR') {
    $url = "https://open.er-api.com/v6/latest/INR";
    $exchange = json_decode(file_get_contents($url), true);

    $displayAmount = $exchange['rates'][$displayCurrency] * $amount / 100;
}

$data = [
    "key" => $keyId,
    "amount" => $amount,
    "name" => $_POST['item_name'],
    "description" => $_POST['item_description'],
    "image" => $planlogo,
    "prefill" => [
        "name" => $name,
        "email" => $email,
        "contact" => $contact,
    ],
    "notes" => [
        "merchant_order_id" => $_POST['item_number'],
    ],
    "theme" => [
        "color" => "#F37254"
    ],
    "order_id" => $razorpayOrderId,
];

if ($displayCurrency !== 'INR') {
    $data['display_currency'] = $displayCurrency;
    $data['display_amount'] = $displayAmount;
}

$json = json_encode($data);
?>


<form action="razorpay.ipv.php" method="POST">
    <script
        src="https://checkout.razorpay.com/v1/checkout.js"
        data-key="<?php echo myvalidate($data['key']); ?>"
        data-amount="<?php echo myvalidate($data['amount']); ?>"
        data-currency="INR"
        data-name="<?php echo myvalidate($data['name']); ?>"
        data-image="<?php echo myvalidate($data['image']); ?>"
        data-description="<?php echo myvalidate($data['description']); ?>"
        data-prefill.name="<?php echo myvalidate($data['prefill']['name']); ?>"
        data-prefill.email="<?php echo myvalidate($data['prefill']['email']); ?>"
        data-prefill.contact="<?php echo myvalidate($data['prefill']['contact']); ?>"
        data-notes.shopping_order_id="<?php echo myvalidate($_POST['item_number']); ?>"
        data-order_id="<?php echo myvalidate($data['order_id']); ?>"
        <?php if ($displayCurrency !== 'INR') { ?> data-display_amount="<?php echo myvalidate($data['display_amount']); ?>" <?php } ?>
        <?php if ($displayCurrency !== 'INR') { ?> data-display_currency="<?php echo myvalidate($data['display_currency']); ?>" <?php } ?>
        >
    </script>
    <!-- Any extra fields to be submitted with the form but not sent to Razorpay -->
    <input type="hidden" name="shopping_order_id" value="<?php echo myvalidate($_POST['item_number']); ?>">
</form>