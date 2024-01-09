<?php
// Set your secret key: remember to change this to your live secret key in production
// See your keys here: https://dashboard.stripe.com/account/apikeys
require('stripe-php-master/init.php');

include 'books.php';

$test = ['name' => 'Test-Buch', 'amount'=> '1299', 'currency' => 'eur', 'quantity' => '1'];

$currency = 'eur';

$public_key_for_js ="1" ; // Definition einer Variable für den public key - Verwendung ganz unten in JS

$live = 0 ;  // Bezahle an G00 - Demo Acount -> bitte auf eigenen Stripe Account umbauen !!

// #################################################################  
// Definition der Stripe-Account-Keys
if( $live == 1  ) {
    // Secret Key des Grosshändlers - bitte so lassen !!!
    \Stripe\Stripe::setApiKey('sk_test_cFnCai0Ye9NM8Tn9CMo6k0fn00P0R9pt9u');

	$public_key_for_js="pk_test_aLcPqdtG2FDzxPWu5N9OBNOs00Yt0nKnhS";  //  PK Großhändler - So lassen !!!!
} else {
      // Der Key Ihres eigenen Stripe-Accounts - bitte hier einsetzen->  der nachfolgende Code ist nicht mehr gültig !!!
      \Stripe\Stripe::setApiKey('sk_test_51OPj2FDtljfWi561Gdu0HP8ZQMHf1vDr2eisoSITN6SxqGfE2yVaP0TpSyUyFxAvVrkrXJ3vMmlBY4tFyeW4PWRC00r3vLjauK');
	
      $public_key_for_js="pk_test_51OPj2FDtljfWi561qNCDC0U2oYxqi2U3Ux1rfRoo1AoXENV9qZp3cu8PuQ21aFVGV2PRjT5TQQCKIjfY1r4RVVqe00P1EQ9PRG";  // PK  G00 
}
// #################################################################  

try {
    $session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
       //'line_items' => [$books[0]],
       'line_items' => [$test],
        'success_url' => 'https://ivm108.informatik.htw-dresden.de/ewa/g20/api/payment/' . 'success.php?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url'  => 'https://ivm108.informatik.htw-dresden.de/ewa/g20/api/payment/' . 'cancel.php?session_id={CHECKOUT_SESSION_ID}',
    ]);
} catch (\Stripe\Exception\ApiErrorException $e) {
    echo "Error in Session::create()" . $e;
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>

<h1>Bookstore</h1>

Sie werden zum Stripe-Checkout weitergeleitet....
<?php // echo "mit PK=" . $public_key_for_js
?>
<script>
    var stripe = Stripe('<?php echo $public_key_for_js ?>'); // Nichts ändern ! Public key oben definiert !!!
	// Hier stand vorher der public key des Test-Accounts G00
    stripe.redirectToCheckout({
        sessionId: '<?php echo $session['id']; ?>'
    }).then(function (result) {
    });
</script>

</body>
</html>