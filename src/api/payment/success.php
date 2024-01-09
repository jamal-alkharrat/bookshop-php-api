<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Success</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

<?php
$userID =  intval($_GET['user_id']);
$orderQuantity = json_decode($_GET['order_quantity'], true);
$totalPrice = intval($_GET['total_price']);

// Add to database
require_once('connectDB.php');
$db = startDbConnection();

// IF userID is not null, add order to database
if ($userID){
    try {
        $query = $db->prepare('INSERT INTO bestellungen (UserID, GesamtPreis, StripeID) VALUES (:userID, :totalPrice, :stripeID)');
        $query->bindParam(':userID', $userID);
        $query->bindParam(':totalPrice', $totalPrice);
        $query->bindParam(':stripeID', $_GET['session_id']);
        $query->execute();
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Faild to insert order into Database. Database error: ' . $e->getMessage()]);
        exit();
    }
} else {
    try {
        $query = $db->prepare('INSERT INTO bestellungen (GesamtPreis, StripeID) VALUES (:totalPrice, :stripeID)');
        $query->bindParam(':totalPrice', $totalPrice);
        $query->bindParam(':stripeID', $_GET['session_id']);
        $query->execute();
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Faild to insert order into Database. Database error: ' . $e->getMessage()]);
        exit();
    }
}


// Get product information from database to add them to the order positions
try {
    $query = $db->prepare('SELECT * FROM buecher');
    $query->execute();
    $products = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Faild to fetch product information from Database. Database error: ' . $e->getMessage()]);
    exit();
}
// Add order positions to database
try {
    $query = $db->prepare('SELECT MAX(BestellungID) FROM bestellungen');
    $query->execute();
    $orderID = $query->fetchColumn();
    foreach ($orderQuantity as $bookID => $quantity) {
        foreach ($products as $product) {
            if ($product['ProduktID'] == $bookID) {
                $priceNet = $product['PreisNetto'];
                $taxRate = $product['Mwstsatz'];
                $priceGross = $product['PreisBrutto'];
                $query = $db->prepare('INSERT INTO bestellpositionen (BestellungID, ProduktID, Anzahl, PreisNetto, Mwstsatz, PreisBrutto) VALUES (:orderID, :productID, :quantity, :priceNet, :taxRate, :priceGross)');
                $query->bindParam(':orderID', $orderID);
                $query->bindParam(':productID', $bookID);
                $query->bindParam(':quantity', $quantity);
                $query->bindParam(':priceNet', $priceNet);
                $query->bindParam(':taxRate', $taxRate);
                $query->bindParam(':priceGross', $priceGross);
                $query->execute();
            }
        }
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Faild to add order position to Database. Database error: ' . $e->getMessage()]);
    exit();
}

// Update stock
try {
    foreach ($orderQuantity as $bookID => $quantity) {
        $query = $db->prepare('UPDATE buecher SET Lagerbestand = Lagerbestand - :quantity WHERE ProduktID = :bookID');
        $query->bindParam(':quantity', $quantity);
        $query->bindParam(':bookID', $bookID);
        $query->execute();
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Faild to update stock. Database error: ' . $e->getMessage()]);
    exit();
}

require_once('../../admin/config.php');
# Redirect to shop after 10 seconds
header("refresh:10;url=".BASE_URL."/");
?>

<div class="container">
        <div class="py-5 text-center">
            <h2>Bookstore</h2>
            <p class="lead">Thanks for shopping with us!</p>
        </div>

        <div class="row">
            <div class="col-md-12 order-md-1">
                <h4 class="mb-3">Order Details</h4>
                <ul class="list-group mb-3">
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                            <h6 class="my-0">User ID</h6>
                        </div>
                        <span class="text-muted"><?php echo $userID; ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                            <h6 class="my-0">Total Price</h6>
                        </div>
                        <span class="text-muted"><?php echo $totalPrice; ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                            <h6 class="my-0">Stripe Session ID</h6>
                        </div>
                        <span class="text-muted"><?php echo $_GET['session_id']; ?></span>
                    </li>
                </ul>
            </div>
        </div>
        <a class="btn btn-primary" href="http://localhost:3000/" role="button">Back to shop</a>
    </div>

    <p id="countdown" class="text-center">Redirecting in 10 seconds...</p>
    <script>
        var timeleft = 10;
        var countdownTimer = setInterval(function(){
            document.getElementById("countdown").innerHTML = "Redirecting in " + timeleft + " seconds...";
            timeleft -= 1;
            if(timeleft <= 0){
                clearInterval(countdownTimer);
                document.getElementById("countdown").innerHTML = "Redirecting..."
            }
        }, 1000);
    </script>

</body>
</html>