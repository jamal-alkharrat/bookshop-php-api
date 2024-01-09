<?php
require_once '../../admin/config.php';
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    // The request is a preflight request. Respond successfully:
    header('Access-Control-Allow-Origin:'.BASE_URL.'/');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
    exit;
}
require('stripe-php-master/init.php');
require_once '../../admin/config.php';
include 'books.php';
// Get the JSON string from the request body
$json = file_get_contents('php://input');
// Decode the JSON string to an associative array
$data = json_decode($json, true);
$orderQuantity = $data['orderQuantity'];
$userID = $data['userID'];
$orderQuantityJson = json_encode($orderQuantity);
$totalPrice = $data['totalPrice'];
$totalPrice = (int)$totalPrice;
foreach ($orderQuantity as $key => $value) {
    // Adjust the book ID
    $bookId = $key - 1;

    // Get the quantity
    $quantity = $value;
    $book = $books[$bookId];
    $book['quantity'] = $quantity;
    // Add book to new array to send to Stripe
    $booksToPurchase[] = $book;
}
$public_key_for_js ="1" ; // Definition einer Variable für den public key - Verwendung ganz unten in JS
// #################################################################  
// Definition der Stripe-Account-Keys
if($_GET['live'] ) {
    // Secret Key des Grosshändlers - bitte so lassen !!!
    \Stripe\Stripe::setApiKey('sk_test_cFnCai0Ye9NM8Tn9CMo6k0fn00P0R9pt9u');

	$public_key_for_js="pk_test_aLcPqdtG2FDzxPWu5N9OBNOs00Yt0nKnhS";  //  PK Großhändler - So lassen !!!!
} else {
    $secret_key = STRIPE_KEY;
    \Stripe\Stripe::setApiKey($secret_key);
	
	$public_key_for_js="pk_test_51OPj2FDtljfWi561qNCDC0U2oYxqi2U3Ux1rfRoo1AoXENV9qZp3cu8PuQ21aFVGV2PRjT5TQQCKIjfY1r4RVVqe00P1EQ9PRG";  // PK  G00 
}
// #################################################################  
try {
    $session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [$booksToPurchase],
        'mode' => 'payment',
       'success_url' => 'https://ivm108.informatik.htw-dresden.de/ewa/g20/api/payment/' . 'success.php?session_id={CHECKOUT_SESSION_ID}&user_id=' . $userID . '&order_quantity=' . urlencode($orderQuantityJson) . '&total_price=' . $totalPrice,
        'cancel_url'  => 'https://ivm108.informatik.htw-dresden.de/ewa/g20/api/payment/' . 'cancel.php?session_id={CHECKOUT_SESSION_ID}&user_id=' . $userID,
    ]);
    echo json_encode(['sessionId' => $session['id']]);
} catch (\Stripe\Exception\ApiErrorException $e) {
    echo "Error in Session::create()" . $e;
}

?>