<?php
require_once '../../admin/config.php';

$host = DB_HOST; 
$username = DB_USER;
$password = DB_PASS;

$conn = mysqli_connect ($host, $username, $password);


// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

echo "Connected successfully";

$query = "SHOW DATABASES";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error running $query: " . mysqli_error($conn));
}

echo "<br><br>Databases:<br>";

while ($row = mysqli_fetch_assoc($result)) {
    echo $row['Database'] . "<br>";
}

// Check if the "bookshop" database exists
$databaseName = 'bookshop';
$query = "SHOW DATABASES LIKE '$databaseName'";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error checking database existence: " . mysqli_error($conn));
}

if (mysqli_num_rows($result) == 0) {
    die("The '$databaseName' database does not exist.");
}

// The "bookshop" database exists, proceed with connecting to it
$db = mysqli_select_db($conn, $databaseName);

if (!$db) {
    die("Error selecting database: " . mysqli_error($conn));
}

echo "Connected to database successfully!";
?>