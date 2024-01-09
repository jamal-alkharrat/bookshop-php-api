<?php

require('stripe-php-master/init.php');
include 'books.php';

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

<hr>
<?php
$i = 0;
echo  "<table  border=1 >";
echo  "<tr><td>Buch</td>  <td> Preis in Cent </td>   <td>Kaufen über  </td> <td>Kaufen über </td> </tr>";
foreach ($books as $book) {
    echo "<tr><td><b>Buch '". $book['price_data']['product_data']['name'] .  "</td> <td>" .  $book['price_data']['unit_amount'] . "</td>";
    echo "<td><a href='stripe_redirect.php?live=0&bookId=".$i."'> eigenen Stripe-Account </a> </td>";
    echo "<td><a href='stripe_redirect.php?live=1&bookId=".$i."'> Grosshaendler (bei Abnahme) </a> </td>";
    $i++;
    echo "</tr>"; 
	}
echo "</table>";     
?>
<hr>
</body>
</html>