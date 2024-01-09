<?php
// Start database connection
require 'connect.php';
$db = startDbConnection();

// Fetch all orders and return them as JSON
try {
    $query = $db->prepare('SELECT * FROM bestellungen');
    $query->execute();
    $result = $query->fetchAll();
    header('Content-Type: application/json');
    echo json_encode($result);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    exit();
}
